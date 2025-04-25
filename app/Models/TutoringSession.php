<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TutoringSession extends Model
{
    protected $table = 'tutoring_sessions';
    
    protected $fillable = [
        'tutor_id',
        'parent_id',
        'start_time',
        'end_time',
        'status',
        'subject',
        'notes',
        'session_fee',
        'is_paid'
    ];
    
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'session_fee' => 'decimal:2',
        'is_paid' => 'boolean'
    ];
    
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
    
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // Add this relationship if using child records
    public function child()
    {
        return $this->belongsTo(User::class, 'child_id'); // Assuming child is stored as child_id
    }

    // Existing student relationship
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function tutorProfile(): BelongsTo
    {
        return $this->belongsTo(TutorProfile::class, 'tutor_id', 'user_id');
    }
    
    public function parentProfile(): BelongsTo
    {
        return $this->belongsTo(ParentProfile::class, 'parent_id', 'user_id');
    }
    
    public function attendance(): HasOne
    {
        return $this->hasOne(SessionAttendance::class, 'tutoring_session_id');
    }
    
    public function feedback(): HasMany
    {
        return $this->hasMany(SessionFeedback::class, 'tutoring_session_id');
    }
}