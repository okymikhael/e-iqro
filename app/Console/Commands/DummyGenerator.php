<?php

namespace App\Console\Commands;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Pelajaran;
use App\Models\Kegiatan;
use Illuminate\Console\Command;

class DummyGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dummy:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Siswa::factory()->count(100)->create();
        Guru::factory()->count(100)->create();
        Pelajaran::factory()->count(100)->create();
        Kegiatan::factory()->count(100)->create();
        echo 'Done...';
        return 0;
    }
}
