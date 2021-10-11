<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $person = [
            'name' => 'taro',
            'mail' => 'taro@yamada.jp',
            'age' => 32,
        ];
        DB::table('people')->insert($person);

        $person = [
            'name' => 'hanako',
            'mail' => 'hanako@yamada.jp',
            'age' => 24,
        ];
        DB::table('people')->insert($person);

        $person = [
            'name' => 'sachiko',
            'mail' => 'sachiko@happy.org',
            'age' => 47,
        ];
        DB::table('people')->insert($person);
    }
}
