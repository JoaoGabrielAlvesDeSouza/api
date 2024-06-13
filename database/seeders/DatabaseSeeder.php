<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        DB::table("users")->insert([
            "name"=>"Admin",
            "surname"=>"User",
            "email"=>"AdminEmailFromDataBase@mail.com",
            "password"=>Hash::make("1q2w3e4r"),
            "description"=>"Admin User from Database",
            "admin"=>true
        ]);
    }
}
