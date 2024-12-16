<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = ['participant_id', 'certificate_id', 'status','error_message'];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'certificate_id', 'id');
    }
}
