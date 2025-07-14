<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'credits',
        'semester',
        'year',
        'instructor',
        'capacity',
        'schedule',
        'room',
        'status',
    ];

    protected $casts = [
        'credits' => 'integer',
        'capacity' => 'integer',
        'year' => 'integer',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function getEnrolledCountAttribute()
    {
        return $this->enrollments()->count();
    }

    public function getAvailableSlotsAttribute()
    {
        return $this->capacity - $this->enrolled_count;
    }

    public function isAvailable()
    {
        return $this->status === 'active' && $this->available_slots > 0;
    }
}