<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    // Definisikan nama tabel jika berbeda dari nama model
    protected $table = 'data_cuti';
    protected $fillable = [
        'nomor_induk',
        'tanggal_cuti',
        'lama_cuti',
        'keterangan',
        
    ];

    // Relasi banyak ke satu dengan karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}


