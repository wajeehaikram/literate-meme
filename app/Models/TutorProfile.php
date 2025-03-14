<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TutorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'subjects',
        'age_groups',
        'hourly_rate',
        'qualifications'
    ];

    protected $casts = [
        'subjects' => 'array',
        'age_groups' => 'array',
        'qualifications' => 'array',
        'hourly_rate' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function availability(): HasMany
    {
        return $this->hasMany(TutorAvailability::class, 'tutor_id', 'user_id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(TutoringSession::class, 'tutor_id', 'user_id');
    }
}