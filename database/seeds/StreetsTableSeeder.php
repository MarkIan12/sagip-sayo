<?php

use Illuminate\Database\Seeder;
use App\Street;
use App\Barangay;
class StreetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        $streets = [
            ['name' => 'Shaw Boulevard', 'barangay' => 'Wack-Wack Greenhills'],
            ['name' => 'EDSA', 'barangay' => 'Highway Hills'],
            ['name' => 'Boni Avenue', 'barangay' => 'Plainview'],
            ['name' => 'San Francisco Street', 'barangay' => 'Plainview'],
            ['name' => 'Pioneer Street', 'barangay' => 'Barangka Ilaya'],
            ['name' => 'Ortigas Avenue', 'barangay' => 'Wack-Wack Greenhills'],
            ['name' => 'Sierra Madre Street', 'barangay' => 'Highway Hills'],
            ['name' => 'A. Bonifacio Street', 'barangay' => 'Poblacion'],
            ['name' => 'P. Cruz Street', 'barangay' => 'Hulo'],
            ['name' => 'Kalentong Street', 'barangay' => 'Pag-Asa'],
            ['name' => 'Libertad Street', 'barangay' => 'Hulo'],
            ['name' => 'General Kalentong Street', 'barangay' => 'Pag-Asa'],
            ['name' => 'M. Vasquez Street', 'barangay' => 'Namayan'],
        ];

        foreach ($streets as $street) {
            $barangay = Barangay::where('name', $street['barangay'])->first();
            if ($barangay) {
                Street::firstOrCreate([
                    'name' => $street['name'],
                    'barangay_id' => $barangay->id
                ]);
            }
        }
    }
}
