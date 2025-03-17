<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Child extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'year_group'
    ];

    /**
     * Get the parent that owns the child
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the subjects that belong to the child
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'child_subject');
    }
}