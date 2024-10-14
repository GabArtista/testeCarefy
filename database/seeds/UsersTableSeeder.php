<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@teste.com',
            'type' => 'admin',
            'password' => Hash::make('123456'),
            'api_token' => Str::random(80),
            'birth_date' => Carbon::createFromDate(1980, 1, 1), // Adicionando a data de nascimento
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Dra. Adriana Galvão',
            'email' => 'adrianagalvao@teste.com',
            'type' => 'doctor',
            'image' => '1.jpg',
            'password' => Hash::make('123456'),
            'birth_date' => Carbon::createFromDate(1985, 5, 20), // Adicionando a data de nascimento
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Dr. Manoel Corte Real',
            'email' => 'manoelcorte@teste.com',
            'type' => 'doctor',
            'image' => '2.jpg',
            'password' => Hash::make('123456'),
            'birth_date' => Carbon::createFromDate(1975, 3, 15), // Adicionando a data de nascimento
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Dra. Cecília Nascimento',
            'email' => 'cecilianascimento@teste.com',
            'type' => 'doctor',
            'image' => '3.jpg',
            'password' => Hash::make('123456'),
            'birth_date' => Carbon::createFromDate(1990, 8, 10), // Adicionando a data de nascimento
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Dr. Matheus Novaes',
            'email' => 'matheusnovaes@teste.com',
            'type' => 'doctor',
            'image' => '4.jpg',
            'password' => Hash::make('123456'),
            'birth_date' => Carbon::createFromDate(1988, 11, 30), // Adicionando a data de nascimento
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Dra. Maria Conceição',
            'email' => 'mariaconceicao@teste.com',
            'type' => 'doctor',
            'image' => '5.jpg',
            'password' => Hash::make('123456'),
            'birth_date' => Carbon::createFromDate(1992, 2, 25), // Adicionando a data de nascimento
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Dr. Francisco Benício Cardoso',
            'email' => 'franciscocardoso@teste.com',
            'type' => 'doctor',
            'image' => '6.jpg',
            'password' => Hash::make('123456'),
            'birth_date' => Carbon::createFromDate(1983, 12, 12), // Adicionando a data de nascimento
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Eduardo Nascimento',
            'email' => 'eduardonascimento@teste.com',
            'type' => 'patient',
            'image' => 'F6fMQY.jpeg',
            'password' => Hash::make('123456'),
            'birth_date' => Carbon::createFromDate(1995, 4, 5), // Adicionando a data de nascimento
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
