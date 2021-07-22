<?php

namespace Database\Seeders;

use App\Models\PhoneType;
use Illuminate\Database\Seeder;

class PhoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phoneTypeNames = [
            'Residencial',
            'Comercial',
            'Celular'
        ];

        foreach($phoneTypeNames as $name){
            $phoneType = new PhoneType();
            $phoneType->name = $name;
            $phoneType->save();
        }
    }
}
