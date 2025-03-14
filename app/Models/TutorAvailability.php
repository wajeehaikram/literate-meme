<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TutorAvailability extends Model
{
    protected $table = 'tutor_availability';
    
    protected $fillable = [
        'tutor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_recurring',
        'specific_date',
        'is_available'
    ];
    
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'specific_date' => 'date',
        'is_recurring' => 'boolean',
        'is_available' => 'boolean'
    ];
    
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
    
    public function tutorProfile(): BelongsTo
    {
        return $this->belongsTo(TutorProfile::class, 'tutor_id', 'user_id');
    }
}