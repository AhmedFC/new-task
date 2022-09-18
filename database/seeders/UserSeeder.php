<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

           // Insert some stuff
            DB::table('users')->insert(
                array(
                    [
                    'id' => 1,
                    'name' => 'ahmed',
                    'email' => 'admin@example.com',
                    'password' => '$2y$10$IFj6SwqC0Sxrsiv4YkCt.OJv1UV4mZrWuyLoRG7qt47mseP9mJ58u',
                    ],

                )
            );

    }
}
