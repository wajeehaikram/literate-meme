<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionAttendance extends Model
{
    protected $table = 'session_attendance';
    
    protected $fillable = [
        'tutoring_session_id',
        'attended',
        'notes'
    ];
    
    protected $casts = [
        'attended' => 'boolean'
    ];
    
    public function session(): BelongsTo
    {
        return $this->belongsTo(TutoringSession::class, 'tutoring_session_id');
    }
}