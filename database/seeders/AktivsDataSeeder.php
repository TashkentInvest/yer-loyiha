<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Aktiv;
use Carbon\Carbon;

class AktivsDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Starting import of Excel data to aktivs table...');

        // Path to the Excel file
        $filePath = public_path('assets/data/2024_data_complete_20250416_112034_complete_with_coordinates.xlsx');

        if (!file_exists($filePath)) {
            $this->command->error('Excel file not found at: ' . $filePath);
            return;
        }

        $this->command->info('Loading Excel file...');

        try {
            // Load Excel file
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Remove the header row
            $headers = array_shift($rows);

            $this->command->info('Processing ' . count($rows) . ' rows...');

            $insertCount = 0;
            $errorCount = 0;

            DB::beginTransaction();

            try {
                foreach ($rows as $index => $row) {
                    try {
                        // Set default value for lat/lng to prevent NULL constraint errors
                        // If a cell is empty in the Excel, provide a default value of 0
                        $latValue = isset($row[28]) && $row[28] !== '' ? $row[28] : '';
                        $lngValue = isset($row[29]) && $row[29] !== '' ? $row[29] : '';

                        // Create a new Aktiv record
                        Aktiv::create([
                            'user_id' => 1, // Default admin user
                            'lot_number' => $row[1] ?? '', // Лот рақами
                            'object_name' => !empty($row[3]) ? $row[3] : "Lot #{$row[1]}", // Address or lot number
                            'balance_keeper' => $row[13] ?? '', // Ғолиб номи
                            'location' => trim(($row[2] ?? '') . ' ' . ($row[3] ?? '')), // Туман + Ер манзили
                            'land_area' => $row[6] ?? 0, // Ер майдони
                            'building_area' => $row[23] ?? 0, // Қурилиш умумий майдони
                            'building_type' => $this->mapBuildingType($row[7] ?? ''), // Қурилиш объект тури
                            'building_type_comment' => $row[7] ?? '', // Қурилиш объект тури
                            'start_price' => $row[9] ?? 0, // Бошланғич нархи
                            'sold_price' => $row[11] ?? 0, // Сотилган нархи
                            'auction_date' => $row[10] ?? null, // Аукцион санаси
                            'winner_name' => $row[13] ?? '', // Ғолиб номи
                            'winner_phone' => $row[14] ?? '', // Телефон рақами
                            'payment_type' => $row[15] ?? '', // Тўлов тури
                            'zone' => $row[5] ?? '', // Зона
                            'kadastr_raqami' => $row[4] ?? '', // Уникал рақами
                            'geolokatsiya' => $row[22] ?? '', // geolocation
                            'latitude' => $latValue,
                            'longitude' => $lngValue,
                            'gas' => 'Yes', // Default value
                            'water' => 'Yes', // Default value
                            'electricity' => 'Yes', // Default value
                            'auction_status' => $row[18] ?? '', // Лот ҳолати
                            'additional_info' => $this->buildAdditionalInfo([
                                'Лот рақами' => $row[1] ?? '',
                                'Объект турлари' => $row[8] ?? '',
                                'Аукцион ғолиби' => $row[12] ?? '',
                                'Тўлов тури' => $row[15] ?? '',
                                'Асос' => $row[16] ?? '',
                                'Аукцион тури' => $row[17] ?? '',
                                'Киритиладиган инвестиция' => $row[24] ?? '',
                                'Яратиладиган иш ўринлари' => $row[25] ?? '',
                            ]),
                            'investment_amount' => $row[24] ?? 0,
                            'job_creation_count' => $row[25] ?? 0,
                            'lot_link' => $row[26] ?? '',
                            'main_image' => $row[27] ?? '',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                        $insertCount++;

                        if ($insertCount % 20 == 0) {
                            $this->command->info("Imported {$insertCount} records so far...");
                        }
                    } catch (\Exception $e) {
                        $this->command->error("Error on row #" . ($index + 2) . ": " . $e->getMessage());
                        $errorCount++;
                    }
                }

                DB::commit();
                $this->command->info("Import completed. Successfully imported {$insertCount} records with {$errorCount} errors.");
            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error("Transaction failed: " . $e->getMessage());
            }
        } catch (\Exception $e) {
            $this->command->error("Failed to process Excel file: " . $e->getMessage());
        }
    }

    /**
     * Map building type from Excel to database enum values
     *
     * @param string $excelValue
     * @return string
     */
    private function mapBuildingType($excelValue)
    {
        $excelValue = mb_strtolower(trim($excelValue));

        if (
            strpos($excelValue, 'maktab') !== false ||
            strpos($excelValue, 'таълим') !== false
        ) {
            return 'NoturarBino';
        } elseif (
            strpos($excelValue, 'savdo') !== false ||
            strpos($excelValue, 'oshxona') !== false ||
            strpos($excelValue, 'kafe') !== false
        ) {
            return 'NoturarBino';
        } elseif (
            strpos($excelValue, 'turar') !== false ||
            strpos($excelValue, 'уй') !== false
        ) {
            return 'TurarBino';
        } else {
            return 'yer';
        }
    }

    /**
     * Build additional info from various Excel columns
     *
     * @param array $data Key-value pairs of data to include
     * @return string
     */
    private function buildAdditionalInfo($data)
    {
        $info = [];

        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $info[] = "{$key}: {$value}";
            }
        }

        return implode("\n", $info);
    }
}
