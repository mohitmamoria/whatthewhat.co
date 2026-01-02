<?php

namespace Database\Seeders;

use App\Models\Totem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TotemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totems = [
            ['name' => 'DESIPOOKIE', 'description' => 'You know India inside out', 'pages' => [5, 185, 51]],
            ['name' => 'PLANETEER', 'description' => 'You know everything about Earth', 'pages' => [9, 15, 165]],
            ['name' => 'ETYMOLOGIST', 'description' => 'You know where words come from', 'pages' => [149, 161, 95]],
            ['name' => 'CULTURATI', 'description' => 'You understand cultures of the world', 'pages' => [195, 37, 241]],
            ['name' => 'STARGAZER', 'description' => 'You know stars of sports and cinema', 'pages' => [131, 135, 223]],
            ['name' => 'PHILOSOPHER', 'description' => 'You know how the world works', 'pages' => [63, 99, 73]],
            ['name' => 'PEOPLEPEDIA', 'description' => 'You know who\'s who of the world', 'pages' => [65, 93, 217]],
            ['name' => 'TROLLVER', 'description' => 'You can solve the trickiest of problems', 'pages' => [143, 83, 111]],
            ['name' => 'POLYMATH', 'description' => 'You know everything about everything', 'pages' => [55, 171, 169]],
        ];

        foreach ($totems as $totem) {
            Totem::create($totem);
        }
    }
}
