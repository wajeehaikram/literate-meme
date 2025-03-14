<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionFeedback extends Model
{
    protected $table = 'session_feedback';
    
    protected $fillable = [
        'tutoring_session_id',
        'feedback_content',
        'rating',
        'feedback_from'
    ];
    
    protected $casts = [
        'rating' => 'integer'
    ];
    
    public function session(): BelongsTo
    {
        return $this->belongsTo(TutoringSession::class, 'tutoring_session_id');
    }
}