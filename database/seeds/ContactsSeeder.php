<?php

use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('contacts')->insert([
		    'id' => 1
	    ]);
    }
}
