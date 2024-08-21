<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'data_karyawan'; // Pastikan nama tabel di sini sesuai dengan yang ada di migration

    protected $fillable = [
        'nama',
        'nomor_induk',
        'alamat',
        'tanggal_lahir',
        'tanggal_bergabung',
    ];
    public function data_cuti()
    {
        return $this->hasMany(Cuti::class);
    }

}
