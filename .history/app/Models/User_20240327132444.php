<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'date_of_birth', 'gender', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('role')->withTimestamps();
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
    // User.php

public function scopeFilter($query, $filters)
{
    $query->when($filters['first_name'] ?? false, function ($query, $first_name) {
        return $query->where('first_name', 'like', '%' . $first_name . '%');
    })
    ->when($filters['last_name'] ?? false, function ($query, $last_name) {
        return $query->where('last_name', 'like', '%' . $last_name . '%');
    })
    ->when($filters['gender'] ?? false, function ($query, $gender) {
        return $query->where('gender', $gender);
    })
    ->when($filters['date_of_birth'] ?? false, function ($query, $date_of_birth) {
        return $query->whereDate('date_of_birth', $date_of_birth);
    });
}
}