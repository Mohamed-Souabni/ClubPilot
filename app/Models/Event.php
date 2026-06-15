<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'club_id', 'created_by', 'title', 'description',
        'location', 'start_date', 'end_date', 'status', 'qr_code',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'attendances')
            ->withPivot('checked_at')
            ->withTimestamps();
    }
}