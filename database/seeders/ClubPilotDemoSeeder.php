<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\BudgetTransaction;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\ClubNotification;
use App\Models\Event;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClubPilotDemoSeeder extends Seeder
{
    public function run(): void
    {
        $president = User::create([
            'name' => 'President Demo',
            'email' => 'president@clubpilot.test',
            'password' => Hash::make('ClubPilot1'),
        ]);

        $admin = User::create([
            'name' => 'Admin Demo',
            'email' => 'admin@clubpilot.test',
            'password' => Hash::make('ClubPilot2'),
        ]);

        $member = User::create([
            'name' => 'Membre Demo',
            'email' => 'membre@clubpilot.test',
            'password' => Hash::make('ClubPilot3'),
        ]);

        $pendingMember = User::create([
            'name' => 'Demandeur Demo',
            'email' => 'demandeur@clubpilot.test',
            'password' => Hash::make('ClubPilot4'),
        ]);

        $club = Club::create([
            'name' => 'Cyberspace',
            'description' => 'Club dedie a la cybersécurite, aux CTF et aux ateliers techniques.',
            'created_by' => $president->id,
        ]);

        ClubMember::create([
            'user_id' => $president->id,
            'club_id' => $club->id,
            'role' => 'president',
            'status' => 'active',
            'joined_at' => now()->subMonths(3),
        ]);

        ClubMember::create([
            'user_id' => $admin->id,
            'club_id' => $club->id,
            'role' => 'admin',
            'status' => 'active',
            'joined_at' => now()->subMonths(2),
        ]);

        ClubMember::create([
            'user_id' => $member->id,
            'club_id' => $club->id,
            'role' => 'member',
            'status' => 'active',
            'joined_at' => now()->subMonth(),
        ]);

        ClubMember::create([
            'user_id' => $pendingMember->id,
            'club_id' => $club->id,
            'role' => 'member',
            'status' => 'pending',
        ]);

        $event = Event::create([
            'club_id' => $club->id,
            'created_by' => $president->id,
            'title' => 'FST CTF',
            'description' => 'Competition CTF pour les etudiants.',
            'location' => 'Salle informatique',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(5)->addHours(4),
            'status' => 'planned',
            'qr_code' => Str::uuid()->toString(),
        ]);

        Event::create([
            'club_id' => $club->id,
            'created_by' => $admin->id,
            'title' => 'Atelier Laravel',
            'description' => 'Introduction pratique a Laravel.',
            'location' => 'Amphi B',
            'start_date' => now()->addDays(12),
            'end_date' => now()->addDays(12)->addHours(2),
            'status' => 'planned',
            'qr_code' => Str::uuid()->toString(),
        ]);

        $task = Task::create([
            'club_id' => $club->id,
            'assigned_to' => $member->id,
            'created_by' => $president->id,
            'title' => 'Préparer les challenges CTF',
            'description' => 'Créer trois challenges faciles pour les nouveaux membres.',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => now()->addDays(2)->toDateString(),
        ]);

        Task::create([
            'club_id' => $club->id,
            'assigned_to' => $admin->id,
            'created_by' => $president->id,
            'title' => 'Réserver la salle',
            'description' => 'Confirmer la disponibilité de la salle informatique.',
            'status' => 'todo',
            'priority' => 'medium',
            'due_date' => now()->subDay()->toDateString(),
        ]);

        BudgetTransaction::create([
            'club_id' => $club->id,
            'created_by' => $president->id,
            'type' => 'income',
            'category' => 'sponsorship',
            'amount' => 3000,
            'description' => 'Sponsoring initial.',
            'transaction_date' => now()->subWeeks(2)->toDateString(),
        ]);

        BudgetTransaction::create([
            'club_id' => $club->id,
            'created_by' => $president->id,
            'type' => 'expense',
            'category' => 'event',
            'amount' => 700,
            'description' => 'Goodies pour le CTF.',
            'transaction_date' => now()->subDays(3)->toDateString(),
        ]);

        Attendance::create([
            'event_id' => $event->id,
            'user_id' => $member->id,
            'checked_at' => now()->subMinutes(15),
        ]);

        ClubNotification::create([
            'user_id' => $member->id,
            'club_id' => $club->id,
            'title' => 'Préparation FST CTF',
            'message' => 'Merci de vérifier les challenges avant vendredi.',
            'is_read' => false,
        ]);

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => $member->id,
            'comment' => 'Je commence par les challenges web.',
        ]);
    }
}