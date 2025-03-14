<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Child extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'year_group',
        'exam_board'
    ];

    /**
     * Get the parent that owns the child
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}