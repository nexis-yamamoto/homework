<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Bookmark;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $b = new Bookmark;
            $b->message = 'Google';
            $b->url = 'https://www.google.co.jp/';
            $b->save();
        }
        {
            $b = new Bookmark;
            $b->message = 'Yahoo';
            $b->url = 'https://www.yahoo.co.jp/';
            $b->save();
        }
        {
            $b = new Bookmark;
            $b->message = 'MSN';
            $b->url = 'https://www.msn.com/';
            $b->save();
        }
    }
}
