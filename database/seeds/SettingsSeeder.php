<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('settings')->insert([
	    	'mainTitle' => 'Just one Laravel site',
	    	'subTitle' => 'Learning Laravel',
		    'meta_description' => 'lotta of words must be here',
		    'meta_keywords' => 'laravel, learning',
	    ]);
    }
}
