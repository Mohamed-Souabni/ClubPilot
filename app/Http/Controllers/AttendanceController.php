<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Attendance;
use App\Models\Club;
use App\Models\Event;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function qr(Request $request, Club $club, Event $event)
    {
        abort_unless($event->club_id === $club->id, 404);
        abort_unless($request->user()->canManageClubOperations($club), 403);

        if (empty($event->qr_code)) {
            $event->update(['qr_code' => Str::uuid()->toString()]);
        }

        $scanUrl = route('attendance.scan', $event->qr_code);

        $result = (new Builder(
            writer: new SvgWriter(),
            data: $scanUrl,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        ))->build();

        $qrCode = $result->getDataUri();

        return view('attendances.qr', compact('club', 'event', 'scanUrl', 'qrCode'));
    }

    public function scan(Request $request, string $qrCode)
    {
        $event = Event::where('qr_code', $qrCode)->firstOrFail();
        $club = $event->club;

        abort_unless($request->user()->isActiveMemberOf($club), 403);

        return view('attendances.scan', compact('club', 'event'));
    }

    public function store(Request $request, string $qrCode)
    {
        $event = Event::where('qr_code', $qrCode)->firstOrFail();
        $club = $event->club;

        abort_unless($request->user()->isActiveMemberOf($club), 403);

        $attendance = Attendance::firstOrCreate(
            ['event_id' => $event->id, 'user_id' => $request->user()->id],
            ['checked_at' => now()]
        );

        $message = $attendance->wasRecentlyCreated
            ? 'Presence confirmee avec succes.'
            : 'Votre presence etait deja confirmee.';

        return redirect()->route('clubs.events.show', [$club, $event])
            ->with('success', $message);
    }

    public function index(Request $request, Club $club, Event $event)
    {
        abort_unless($event->club_id === $club->id, 404);
        abort_unless($request->user()->canManageClubOperations($club), 403);

        $attendances = $event->attendances()
            ->with('user')
            ->latest('checked_at')
            ->get();

        return view('attendances.index', compact('club', 'event', 'attendances'));
    }

   
    
    public function exportPdf(Request $request, Club $club, Event $event)
{
    abort_unless($event->club_id === $club->id, 404);
    abort_unless($request->user()->canManageClubOperations($club), 403);

    $attendances = $event->attendances()
        ->with('user')
        ->latest('checked_at')
        ->get();

    $pdf = Pdf::loadView('attendances.pdf', compact('club', 'event', 'attendances'))
        ->setPaper('a4', 'portrait');

    $fileName = 'presences-' . $event->id . '-' . Str::slug($event->title) . '.pdf';

    return $pdf->download($fileName);
}
}