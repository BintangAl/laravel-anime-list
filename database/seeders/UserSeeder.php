<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Munsuta',
            'email' => 'munsutastore@gmail.com',
            'avatar' => 'image/1nfgzYmjVWGenSKNObyavqfUB2IFpLcEd9UJNvPA.jpg',
            'banner' => 'image/LXOmkA0ct3ms11FTiNrq435iek8I6EIWP6s8Nnjn.jpg',
            'password' => '$2y$10$Ifcs9qChL0iD2v7UHqYINOvE46zoKzXkc5SSthbGdmRPzZ9gpCqTu',
            'remember_token' => '166AjypWAWEWnbIoT5w7Hly5diepBpWkOxSg6emU4C79FP3qKyhQsuC6FiqM',
            'created_at' => '2022-08-11 13:17:35',
            'updated_at' => '2022-08-11 13:17:35'
        ]);
    }
}
