<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('admin123')
            ],
            [
                'name' => 'mahasiswa',
                'email' => 'mahasiswa@gmail.com',
                'role' => 'mahasiswa',
                'password' => bcrypt('mahasiswa123')
            ],
            [
                'name' => 'dosen',
                'email' => 'dosen@gmail.com',
                'role' => 'dosen',
                'password' => bcrypt('dosen123')
            ],
            [
                'name' => 'kaprodi',
                'email' => 'kaprodi@gmail.com',
                'role' => 'kaprodi',
                'password' => bcrypt('kaprodi123')
            ],
            [
                'name' => 'dekan',
                'email' => 'dekan@gmail.com',
                'role' => 'dekan',
                'password' => bcrypt('dekan123')
            ],
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
