<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
    
    /**
     * Check if the user is a tutor
     *
     * @return bool
     */
    public function isTutor()
    {
        return $this->user_type === 'tutor';
    }
    
    /**
     * Get the tutor profile associated with the user
     */
    public function tutorProfile(): HasOne
    {
        return $this->hasOne(TutorProfile::class);
    }
    
    /**
     * Get the parent profile associated with the user
     */
    public function parentProfile(): HasOne
    {
        return $this->hasOne(ParentProfile::class);
    }
    
    public function tutorSessions(): HasMany
    {
        return $this->hasMany(TutoringSession::class, 'tutor_id');
    }
    
    public function parentSessions(): HasMany
    {
        return $this->hasMany(TutoringSession::class, 'parent_id');
    }
    
    public function availability(): HasMany
    {
        return $this->hasMany(TutorAvailability::class, 'tutor_id');
    }
    
    public function isParent(): bool
    {
        return $this->user_type === 'parent';
    }
    
    /**
     * Get the children associated with the parent user
     */
    public function children(): HasMany
    {
        return $this->hasMany(Child::class, 'user_id');
    }
}
