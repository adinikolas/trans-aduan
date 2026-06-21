<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name'];

    // Relasi: Satu divisi bisa memiliki banyak user (misal: beberapa Kadiv/Staf)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi: Satu divisi bisa menerima banyak aduan
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}