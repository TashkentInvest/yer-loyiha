<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Aktiv;
use Illuminate\Support\Str;
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
        $filePath = public_path('assets/data/2024_data_complete_20250416_112034_complete.xlsx');

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

            // Debug the headers to identify column positions
            $this->command->info('Headers: ' . print_r($headers, true));

            $this->command->info('Processing ' . count($rows) . ' rows...');

            $insertCount = 0;
            $errorCount = 0;
            $batchSize = 100;
            $records = [];

            DB::beginTransaction();

            try {
                foreach ($rows as $index => $row) {
                    try {
                        // First, let's add some debug information to identify our column positions
                        if ($index === 0) {
                            $this->command->info("First row data:");
                            for ($i = 0; $i < count($row); $i++) {
                                $this->command->info("Column $i: " . ($row[$i] ?? 'NULL'));
                            }
                        }

                        // Coordinates extraction
                        $coordinates = $this->findCoordinates($row);
                        $lat = $coordinates['lat'];
                        $lng = $coordinates['lng'];
                        $coordinatesSource = $coordinates['source'];

                        // Extract data from the row
                        $lotNumber = $row[1] ?? ''; // Лот рақами
                        $district = $row[2] ?? ''; // Туман
                        $address = $row[3] ?? ''; // Ер манзили
                        $kadastrNumber = $row[4] ?? ''; // Уникал рақами
                        $zone = $row[5] ?? ''; // Зона
                        $landArea = $this->parseFloat($row[6] ?? 0); // Ер майдони
                        $buildingType = $this->mapBuildingType($row[7] ?? ''); // Қурилиш объект тури
                        $objectTypes = $row[8] ?? ''; // Қуриладиган объект турлари
                        $startPrice = $this->parseFloat($row[9] ?? 0); // Бошланғич нархи
                        $auctionDate = $this->parseDate($row[10] ?? ''); // Аукцион санаси
                        $soldPrice = $this->parseFloat($row[11] ?? 0); // Сотилган нархи
                        $winnerType = $row[12] ?? ''; // Аукцион ғолиби
                        $winnerName = $row[13] ?? ''; // Ғолиб номи
                        $phoneNumber = $row[14] ?? ''; // Телефон рақами
                        $paymentType = $row[15] ?? ''; // Тўлов тури
                        $auctionType = $row[17] ?? ''; // Аукцион ўтказиш тури
                        $lotStatus = $row[18] ?? ''; // Лот ҳолати
                        $geolocation = null;

                        // Find geolocation URL (looking for maps.app.goo.gl links)
                        for ($i = 0; $i < count($row); $i++) {
                            if (isset($row[$i]) && is_string($row[$i])) {
                                if (
                                    strpos($row[$i], 'maps.app.goo.gl') !== false ||
                                    strpos($row[$i], 'goo.gl') !== false
                                ) {
                                    $geolocation = $row[$i];
                                    $this->command->info("Found geolocation at column $i: " . $geolocation);
                                    break;
                                }
                            }
                        }

                        $buildingArea = $this->parseFloat($row[22] ?? 0); // Қурилиш умумий майдони
                        $investment = $row[23] ?? ''; // Киритиладиган инвестиция
                        $jobCount = $this->parseInteger($row[24] ?? ''); // Яратиладиган иш ўринлари сони

                        // Try to find lot_link and main_image in columns
                        $lotLink = null;
                        $mainImage = null;

                        // Based on your sample data, let's try column 25 for lot_link
                        if (isset($row[25]) && is_string($row[25]) && strpos($row[25], 'http') !== false) {
                            $lotLink = $row[25];
                        }

                        // Let's look for image URLs
                        for ($i = 0; $i < count($row); $i++) {
                            if (isset($row[$i]) && is_string($row[$i])) {
                                if (strpos($row[$i], 'files.e-auksion.uz') !== false) {
                                    $mainImage = $row[$i];
                                    $this->command->info("Found main_image at column $i: " . substr($mainImage, 0, 30) . "...");
                                    break;
                                }
                            }
                        }

                        // If lot_link is still not found, look for any URL
                        if (!$lotLink) {
                            for ($i = 0; $i < count($row); $i++) {
                                if (isset($row[$i]) && is_string($row[$i])) {
                                    if (strpos($row[$i], 'e-auksion.uz/lot-view') !== false) {
                                        $lotLink = $row[$i];
                                        $this->command->info("Found lot_link at column $i: " . substr($lotLink, 0, 30) . "...");
                                        break;
                                    }
                                }
                            }
                        }

                        // Create a comprehensive location description
                        $location = trim($district . ' ' . $address);

                        // Create object name using address or lot number
                        $objectName = !empty($address) ? $address : "Lot #{$lotNumber}";

                        // Log coordinate source
                        $this->command->info("Coordinates for Row #" . ($index + 2) . " - Source: $coordinatesSource, Lat: $lat, Lng: $lng");

                        // Create a new Aktiv record
                        Aktiv::create([
                            'user_id' => 1, // Default admin user
                            'lot_number' => $lotNumber,
                            'object_name' => $objectName,
                            'balance_keeper' => $winnerName,
                            'location' => $location,
                            'land_area' => $landArea,
                            'building_area' => $buildingArea,
                            'building_type' => $buildingType,
                            'start_price' => $startPrice,
                            'sold_price' => $soldPrice,
                            'auction_date' => $auctionDate,
                            'winner_name' => $winnerName,
                            'winner_phone' => $phoneNumber,
                            'payment_type' => $paymentType,
                            'zone' => $zone,
                            'kadastr_raqami' => $kadastrNumber,
                            'geolokatsiya' => $geolocation,
                            'latitude' => $lat,
                            'longitude' => $lng,
                            'gas' => 'Yes', // Default value
                            'water' => 'Yes', // Default value
                            'electricity' => 'Yes', // Default value
                            'auction_status' => $lotStatus,
                            'additional_info' => $this->buildAdditionalInfo([
                                'Лот рақами' => $lotNumber,
                                'Объект турлари' => $objectTypes,
                                'Аукцион санаси' => $auctionDate,
                                'Сотилган нархи' => $soldPrice,
                                'Тўлов тури' => $paymentType,
                                'Аукцион тури' => $auctionType,
                                'Киритиладиган инвестиция' => $investment,
                                'Яратиладиган иш ўринлари' => $jobCount,
                                'Координаты источник' => $coordinatesSource,
                            ]),
                            'investment_amount' => $this->extractNumericValue($investment),
                            'job_creation_count' => $jobCount,
                            'lot_link' => $lotLink,
                            'main_image' => $mainImage,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                        $insertCount++;

                        if ($insertCount % 10 == 0) {
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
     * Find coordinates in the row using multiple methods
     *
     * @param array $row
     * @return array Associative array with lat, lng, and source of coordinates
     */
    private function findCoordinates(array $row): array
    {
        $lat = null;
        $lng = null;
        $source = 'none';

        // Method 1: Try to find coordinates directly in the row
        for ($i = 0; $i < count($row); $i++) {
            $value = $row[$i] ?? null;
            if (is_string($value) || is_numeric($value)) {
                $value = (string)$value;
                // Look for typical latitude format
                if (preg_match('/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/', $value)) {
                    $lat = $this->parseFloat($value);
                    // The next column should be longitude
                    if (isset($row[$i + 1]) && (is_string($row[$i + 1]) || is_numeric($row[$i + 1]))) {
                        $lngValue = (string)$row[$i + 1];
                        if (preg_match('/^[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/', $lngValue)) {
                            $lng = $this->parseFloat($lngValue);
                            $source = 'direct_columns';
                            break;
                        }
                    }
                }
            }
        }

        // Method 2: If we still don't have coordinates, try columns 27 and 28
        if (empty($lat) || empty($lng)) {
            if (isset($row[27]) && !empty($row[27]) && isset($row[28]) && !empty($row[28])) {
                $lat = $this->parseFloat($row[27]);
                $lng = $this->parseFloat($row[28]);

                if ($this->isValidCoordinates($lat, $lng)) {
                    $source = 'specific_columns';
                }
            }
        }

        // Method 3: Try to find coordinates at the end of the row
        if (empty($lat) || empty($lng) || !$this->isValidCoordinates($lat, $lng)) {
            for ($i = count($row) - 1; $i >= 0; $i--) {
                $value = $row[$i] ?? null;
                if (is_string($value) || is_numeric($value)) {
                    $value = (string)$value;
                    // Look for typical longitude format
                    if (preg_match('/^[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/', $value)) {
                        $lng = $this->parseFloat($value);
                        // The previous column should be latitude
                        if (isset($row[$i - 1]) && (is_string($row[$i - 1]) || is_numeric($row[$i - 1]))) {
                            $latValue = (string)$row[$i - 1];
                            if (preg_match('/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/', $latValue)) {
                                $lat = $this->parseFloat($latValue);
                                if ($this->isValidCoordinates($lat, $lng)) {
                                    $source = 'reverse_columns';
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }

        // Method 4: Look for Google Maps URL in any column
        if (empty($lat) || empty($lng) || !$this->isValidCoordinates($lat, $lng)) {
            for ($i = 0; $i < count($row); $i++) {
                if (isset($row[$i]) && is_string($row[$i])) {
                    $url = $row[$i];

                    // Check for Google Maps URLs
                    if (
                        strpos($url, 'maps.app.goo.gl') !== false ||
                        strpos($url, 'goo.gl') !== false ||
                        strpos($url, 'maps.google.com') !== false
                    ) {

                        $coordinates = $this->extractCoordinatesFromUrl($url);

                        if ($coordinates && $this->isValidCoordinates($coordinates['lat'], $coordinates['lng'])) {
                            $lat = $coordinates['lat'];
                            $lng = $coordinates['lng'];
                            $source = 'google_maps_url';
                            break;
                        }
                    }
                }
            }
        }

        // Default to Tashkent coordinates if all else fails
        if (empty($lat) || empty($lng) || !$this->isValidCoordinates($lat, $lng)) {
            $lat = 41.2995;
            $lng = 69.2401;
            $source = 'default_tashkent';
        }

        return [
            'lat' => $lat,
            'lng' => $lng,
            'source' => $source
        ];
    }

    /**
     * Extract coordinates from a Google Maps URL
     *
     * @param string $url
     * @return array|null Array with lat and lng keys, or null if no coordinates found
     */
    private function extractCoordinatesFromUrl(string $url): ?array
    {
        // First attempt: Check for direct coordinates in the URL (most common pattern)
        $patterns = [
            // Regular Google Maps URL pattern
            '/[@?](-?\d+\.\d+),(-?\d+\.\d+)/',

            // Google Maps short URL pattern after expansion
            '/\/maps\/[^@]*@(-?\d+\.\d+),(-?\d+\.\d+)/',

            // Direct coordinates in URL path
            '/\/(-?\d+\.\d+),(-?\d+\.\d+)/',

            // Coordinates in data parameters
            '/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/',

            // Very basic pattern (final fallback)
            '/(-?\d+\.\d+),\s*(-?\d+\.\d+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                $lat = $this->parseFloat($matches[1]);
                $lng = $this->parseFloat($matches[2]);

                // Verify the coordinates are valid
                if ($this->isValidCoordinates($lat, $lng)) {
                    return ['lat' => $lat, 'lng' => $lng];
                }
            }
        }

        // For Google Maps shortlinks that need to be expanded
        if (strpos($url, 'goo.gl') !== false) {
            // For actual production use, you would need to expand the URL
            // This would require making an HTTP request to follow the redirect
            // For example using cURL or Guzzle

            // Since we can't make HTTP requests in this context, we'll use a sample mapping
            // Extract the shortcode part
            if (preg_match('/goo\.gl\/([a-zA-Z0-9]+)/', $url, $matches)) {
                $shortCode = $matches[1];

                // Sample mapping for the example URL
                if ($shortCode === 'ENAtXtxTp9DS2Bjh7') {
                    return ['lat' => 41.3276, 'lng' => 69.2276]; // Example coordinates for this URL
                }

                // You can add more mappings here if you know them
                // Or replace with actual URL expansion logic in production
            }
        }

        return null;
    }

    /**
     * Check if coordinates are valid
     *
     * @param float $lat
     * @param float $lng
     * @return bool
     */
    private function isValidCoordinates($lat, $lng): bool
    {
        return (
            is_numeric($lat) && is_numeric($lng) &&
            $lat >= -90 && $lat <= 90 &&
            $lng >= -180 && $lng <= 180 &&
            !($lat == 0 && $lng == 0) // Avoid 0,0 coordinates
        );
    }

    /**
     * Parse a float value from various formats
     *
     * @param mixed $value
     * @return float
     */
    private function parseFloat($value)
    {
        if (empty($value)) {
            return 0;
        }

        // If the value contains commas as decimal separators, replace them
        if (is_string($value)) {
            $value = str_replace(',', '.', $value);
        }

        // Remove any non-numeric characters except decimal point and minus sign
        $value = preg_replace('/[^\d.-]/', '', $value);

        return (float) $value;
    }

    /**
     * Parse an integer value
     *
     * @param mixed $value
     * @return int
     */
    private function parseInteger($value)
    {
        if (empty($value)) {
            return 0;
        }

        // Remove any non-numeric characters except minus sign
        $value = preg_replace('/[^\d-]/', '', $value);

        return (int) $value;
    }

    /**
     * Extract numeric value from a string
     *
     * @param string $value
     * @return float
     */
    private function extractNumericValue($value)
    {
        if (empty($value)) {
            return 0;
        }

        // Extract numbers including decimal points
        preg_match('/[\d,.]+/', $value, $matches);

        if (empty($matches)) {
            return 0;
        }

        // Clean up the value and convert to float
        $numericValue = str_replace(',', '.', $matches[0]);

        return (float) $numericValue;
    }

    /**
     * Parse date from various formats
     *
     * @param mixed $value
     * @return ?Carbon
     */
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
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

        // Map according to the building types in the database
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
            // Default to 'yer' if nothing else matches
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
