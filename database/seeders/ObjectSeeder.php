<?php

namespace Database\Seeders;

use App\Models\SmartObject;
use App\Models\SmartObjectsPermissions;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 800; ++$i) {
            $object = SmartObject::create([
                'name' => Str::random(10),
                'ip' => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255),
                'port' => rand(1024, 32767),
                'username' => Str::random(10),
                'keypass' => Str::random(10),
            ]);
            SmartObjectsPermissions::create([
                'user_id' => User::all()->pluck('id')->random(),
                'object_id' => $object->id,
                'owner' => 1,
            ]);
        }
    }
}
