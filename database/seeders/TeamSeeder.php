<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents(base_path('teams.txt'));

        if ($data) {
            $list = explode(PHP_EOL, $data);

            foreach ($list as $name) {
                $name = trim($name);
                if ($name) {
                    Team::create([
                        'name' => trim($name),
                        'power' => round(rand(10, 100), -1),
                    ]);
                }
            }
        }
    }
}
