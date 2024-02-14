<?php

namespace App\Services;

use App\DTO\KarirData;
use App\DTO\ProfilData;
use App\Enum\PosisiEnum;
use Exception;
use Illuminate\Database\LostConnectionException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ApiCapresService
{
    public static function getCapresData(): array
    {
        try {
            $api = Http::get('https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7');

            if (!$api->successful()) {
                return [];
            }
        } catch (ConnectionException $e) {
            report($e);

            return [];
        } catch (Exception $e) {
            report($e);

            return [];
        }

        return $api->json();
    }

    public static function capresData(): array
    {
        $data = ApiCapresService::getCapresData();
        if (empty($data)) {
            throw new Exception('Tidak ada data yang ditemukan.');
        }

        $parseData = [];

        $posisiEnums = [
            'calon_presiden' => PosisiEnum::CALON_PRESIDEN,
            'calon_wakil_presiden' => PosisiEnum::CALON_WAKIL_PRESIDEN,
        ];

        foreach ($posisiEnums as $key => $posisi) {
            foreach ($data[$key] as $value) {
                $parseData[$value['nomor_urut']][] = new ProfilData(
                    $value['nomor_urut'],
                    $value['nama_lengkap'],
                    $posisi->value,
                    $value['tempat_tanggal_lahir'],
                    ApiCapresService::hitungUmur($value['tempat_tanggal_lahir']),
                    ApiCapresService::parseKarir($value['karir'])
                );
            }
        }

        return $parseData;
    }

    public static function parseTanggalLahir(string $tempatTanggalLahir): string
    {
        $tempatTanggalLahir = explode(', ', $tempatTanggalLahir);

        return is_array($tempatTanggalLahir) && isset($tempatTanggalLahir[1]) ? $tempatTanggalLahir[1] : '';
    }

    public static function parseKarir(array $karir): array
    {
        $karirData = [];

        foreach ($karir as $posisi) {
            $dataKarir = explode(' ', $posisi);
            $jabatan = implode(' ', array_slice($dataKarir, 0, -1));
            $tahun = explode('-', $dataKarir[count($dataKarir) - 1]);

            if (count($tahun) !== 2) {
                error_log("Format data karir tidak valid: $posisi");

                continue;
            }

            $tahunMulai = (int) str_replace('(', '', $tahun[0]);
            $tahunSelesai = (int) str_replace(')', '', $tahun[1]);

            $karirData[] = new KarirData($jabatan, $tahunMulai, $tahunSelesai);
        }

        return $karirData;
    }

    public static function hitungUmur(string $tempatTanggalLahir): int
    {
        $tempatTanggalLahir = explode(', ', $tempatTanggalLahir);
        $tanggal = explode(' ', $tempatTanggalLahir[1]);

        $tahunLahir = (int) $tanggal[2];

        return now()->year - $tahunLahir;
    }
}
