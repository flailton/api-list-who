<?php

namespace Database\Seeders;

use App\Models\LinkType;
use Illuminate\Database\Seeder;

class LinkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $linkTypeNames = [
            'Facebook',
            'LinkedIn'
        ];

        foreach($linkTypeNames as $name){
            $linkType = new LinkType();
            $linkType->name = $name;
            $linkType->save();
        }
    }
}
