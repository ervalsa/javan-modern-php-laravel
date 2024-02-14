<?php

use App\DTO\ProfilData;
use App\Services\ApiCapresService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

it('returns an array of capres data', function () {
    $result = ApiCapresService::getCapresData();

    expect($result)->toBeArray();
});

it('returns an empty array when API request fails', function () {
    Http::fake([
        'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7' => Http::response([], 500)
    ]);

    $result = ApiCapresService::getCapresData();

    expect($result)->toBeArray();
    expect($result)->toBeEmpty();
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
