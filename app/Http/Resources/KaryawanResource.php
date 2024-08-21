<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KaryawanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nomor_induk' => $this->nomor_induk,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'tanggal_lahir' => $this->tanggal_lahir,
            'tanggal_bergabung' => $this->tanggal_bergabung,
        ];
    }
}

