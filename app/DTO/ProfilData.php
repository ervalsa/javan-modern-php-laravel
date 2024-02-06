<?php

namespace App\DTO;

class ProfilData
{
    public int $nomorUrut;

    public string $nama;

    public string $posisi;

    public string $tempatTanggalLahir;

    public int $usia;

    public array $karir;

    public function __construct(int $nomorUrut, string $nama, string $posisi, string $tempatTanggalLahir, int $usia, array $karir)
    {
        $this->nomorUrut = $nomorUrut;
        $this->nama = $nama;
        $this->posisi = $posisi;
        $this->tempatTanggalLahir = $tempatTanggalLahir;
        $this->usia = $usia;
        $this->karir = $karir;
    }
}
