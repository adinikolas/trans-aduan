<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'category_id',
        'division_id',
        'title',
        'description',
        'incident_time',
        'bus_number',
        'evidence_path',
        'status',
        'resolution_notes',
        'resolution_proof_path',
    ];

    // Aduan ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Aduan ini masuk kategori apa?
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Aduan ini ditangani divisi mana?
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // Riwayat perubahan status aduan ini
    public function histories()
    {
        return $this->hasMany(ComplaintHistory::class);
    }

    // Ulasan (Feedback) untuk aduan ini
    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}