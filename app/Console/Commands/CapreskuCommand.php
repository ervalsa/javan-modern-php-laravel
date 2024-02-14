<?php

namespace App\Console\Commands;

use App\Services\ApiCapresService;
use Illuminate\Console\Command;

class CapreskuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'capresku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get profile data of Indonesian President Candidate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataCapres = (new ApiCapresService())->capresData();
        ksort($dataCapres);

        $this->newLine();
        $this->info("Profil Calon Presiden dan Calon Wakil Presiden 2024");
        $this->newLine();

        foreach ($dataCapres as $keyData => $value) {
            $this->line("Calon Nomor Urut $keyData");
            $this->newLine();
            foreach ($value as $key => $calon) {
                echo "Nama : $calon->nama,\nPosisi : $calon->posisi, \nUsia : $calon->usia \n" . PHP_EOL;
            }
            $this->newLine();
        }
    }
}
