<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintHistory extends Model
{
    protected $fillable = [
        'complaint_id',
        'status',
        'note',
        'created_by',
    ];

    // Riwayat ini milik aduan yang mana?
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    // Siapa yang mengubah status ini (CC Room atau Kadiv)?
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}