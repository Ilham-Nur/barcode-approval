<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'tanggal_masuk',
        'nama_kapal',
        'lokasi',
        'jenis_pekerjaan',
        'tanggal_inspeksi',
        'tanggal_selesai',
        'status_id',
        'user_id',
        'pdf_path',
        'barcode_path',
        
    ];

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id');
    }
}
