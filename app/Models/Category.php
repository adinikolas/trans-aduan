<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'division_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
