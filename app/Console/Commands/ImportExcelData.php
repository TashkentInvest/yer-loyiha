<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportExcelData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Excel data from 2024_data_complete file to aktivs table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting Excel data import...');

        // Use the seeder through the application's service container
        $this->call('db:seed', [
            '--class' => 'Database\\Seeders\\AktivsDataSeeder'
        ]);

        $this->info('Excel data import completed!');

        return 0;
    }
}
