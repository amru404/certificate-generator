<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CertificateTemplates;

class CertificateTemplate  extends Model
{
    use HasFactory;

    protected $table = 'certificate_templates';
    protected $fillable = ['id','nama_template', 'preview','nama','deskripsi','tanggal','ttd','uid','nomor_certificate','logo','cap'];

    
    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'certificate_templates_id'); 
    }
}
