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

    public function __construct($nomorUrut, $nama, $posisi, $tempatTanggalLahir, $usia, $karir)
    {
        $this->nomorUrut = $nomorUrut;
        $this->nama = $nama;
        $this->posisi = $posisi;
        $this->tempatTanggalLahir = $tempatTanggalLahir;
        $this->usia = $usia;
        $this->karir = $karir;
    }
}
