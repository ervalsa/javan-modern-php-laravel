<?php

namespace App\DTO;

class KarirData
{
    public string $jabatan;

    public int $tahunMulai;

    public ?int $tahunSelesai;

    public function __construct(string $jabatan, int $tahunMulai, int $tahunSelesai)
    {
        $this->jabatan = $jabatan;
        $this->tahunMulai = $tahunMulai;
        $this->tahunSelesai = $tahunSelesai;
    }
}
