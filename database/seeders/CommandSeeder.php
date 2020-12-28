<?php

namespace Database\Seeders;

use App\Models\SmartObject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 3000; ++$i) {
            DB::table('commands')->insert([
                'name' => $name = Str::random(10),
                'content' => "command #" . rand(1000, 9999) . " ",
                'description' => "The `$name` command makes " . Str::random(15),
                'input' => collect([true, false])->random(),
                'object_id' => SmartObject::all()->pluck('id')->random(),
            ]);
        }
    }
}
