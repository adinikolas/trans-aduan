<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'division_id'];

    // Relasi: Kategori ini secara otomatis masuk ke divisi mana
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}