<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
         // Créer un administrateur
        $administrator = new Administrator();
        $administrator->email = 'eboun.dossou@gmail.com';
        $administrator->password = Hash::make('password');
        $administrator->save();
    }

}
