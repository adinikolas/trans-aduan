<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks'; // Memastikan nama tabel benar
    
    protected $fillable = [
        'complaint_id',
        'rating',
        'comment',
    ];

    // Feedback ini untuk aduan yang mana?
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}