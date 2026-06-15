<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function createdClubs(): HasMany
{
    return $this->hasMany(Club::class, 'created_by');
}

public function clubMemberships(): HasMany
{
    return $this->hasMany(ClubMember::class);
}

public function clubs(): BelongsToMany
{
    return $this->belongsToMany(Club::class, 'club_members')
        ->withPivot(['role', 'status', 'joined_at', 'reviewed_by', 'reviewed_at'])
        ->withTimestamps();
}

public function assignedTasks(): HasMany
{
    return $this->hasMany(Task::class, 'assigned_to');
}

public function createdTasks(): HasMany
{
    return $this->hasMany(Task::class, 'created_by');
}

public function attendances(): HasMany
{
    return $this->hasMany(Attendance::class);
}

public function budgetTransactions(): HasMany
{
    return $this->hasMany(BudgetTransaction::class, 'created_by');
}

public function clubNotifications(): HasMany
{
    return $this->hasMany(ClubNotification::class);
}

public function taskComments(): HasMany
{
    return $this->hasMany(TaskComment::class);
}
public function isActiveMemberOf(Club $club): bool
{
    return $this->clubMemberships()
        ->where('club_id', $club->id)
        ->where('status', 'active')
        ->exists();
}

public function isPresidentOf(Club $club): bool
{
    return $this->clubMemberships()
        ->where('club_id', $club->id)
        ->where('role', 'president')
        ->where('status', 'active')
        ->exists();
}

public function isAdminOf(Club $club): bool
{
    return $this->clubMemberships()
        ->where('club_id', $club->id)
        ->where('role', 'admin')
        ->where('status', 'active')
        ->exists();
}

public function canManageClubOperations(Club $club): bool
{
    return $this->isPresidentOf($club) || $this->isAdminOf($club);
}

public function canManageBudget(Club $club): bool
{
    return $this->isPresidentOf($club);
}

}
