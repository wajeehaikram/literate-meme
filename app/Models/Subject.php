<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Get the children that belong to the subject
     */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class, 'child_subject');
    }
}
