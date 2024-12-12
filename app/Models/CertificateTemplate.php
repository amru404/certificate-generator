<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CertificateTemplates;

class CertificateTemplate  extends Model
{
    use HasFactory;

    protected $table = 'certificate_templates';
    protected $fillable = ['nama_template', 'preview','nama','deskripsi','tanggal','ttd','uid'];

    
    public function certificate()
    {
        return $this->hasMany(Certificate::class, 'certificate_templates_id'); 
    }
}
