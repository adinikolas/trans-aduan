<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'division_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Divisi.
    // Tetap dipertahankan karena aduan masih memiliki division_id.
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // Relasi: Satu user bisa membuat banyak aduan
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
