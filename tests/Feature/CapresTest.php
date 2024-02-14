<?php

use App\DTO\ProfilData;
use App\Services\ApiCapresService;

it('returns an array of capres data', function () {
    $result = ApiCapresService::getCapresData();

    expect($result)->toBeArray();
});

it('returns an array of parsed Capres data', function () {
    $data = [
        'calon_presiden' => [
            [
                'nomor_urut' => 1,
                'nama_lengkap' => 'Joko Widodo',
                'tempat_tanggal_lahir' => 'Surakarta, 21 Juni 1961',
                'karir' => [
                    'Politikus',
                    'Pebisnis',
                ],
            ],
        ],
        'calon_wakil_presiden' => [
            [
                'nomor_urut' => 2,
                'nama_lengkap' => 'Ma\'ruf Amin',
                'tempat_tanggal_lahir' => 'Tangerang, 11 Maret 1943',
                'karir' => [
                    'Agamawan',
                    'Ulama',
                ],
            ],
        ],
    ];

    $result = ApiCapresService::capresData($data);

    expect($result)->toBeArray();
    expect($result[1])->toBeArray();
    expect($result[1][0])->toBeInstanceOf(ProfilData::class);
});
