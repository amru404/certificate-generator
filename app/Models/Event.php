<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_event',
        'email',
        'no_telp',
        'deskripsi',
        'tanggal',
        'logo',
        'nomor_certificate',
        'cap',
        'ttd',
        'tampilkan_nama_event',
        'tampilkan_email',
        'tampilkan_no_telp',
        'tampilkan_deskripsi',
        'tampilkan_tanggal',
    ];

    protected $casts = [
        'logo' => 'array',
        'ttd' => 'array',
        'cap' => 'array',
    ];

    
    public function participants()
{
    return $this->hasMany(Participant::class, 'event_id');
}
    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
