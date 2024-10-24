<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected static function boot() {
        parent::boot();

        static::created(function () {
            Cache::forget("user_list");
        });

        static::updated(function () {
            Cache::forget("user_list");
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'requester_type_id',
        'requester_id',
        'designation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function tickets() {
        return $this->belongsToMany(Ticket::class, 'ticket_ownerships', 'owner_id', 'ticket_id');
    }
    public function teams() {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
    }

    public function requester_type() {
        return $this->belongsTo(RequesterType::class, 'requester_type_id', 'id');
    }
}
