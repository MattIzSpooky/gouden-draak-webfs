<?php

use App\DishType;
use Illuminate\Database\Seeder;

class DishTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            "BAMI EN NASI GERECHTEN",
            "BUFFET",
            "CHINESE BAMI GERECHTEN",
            "COMBINATIE GERECHTEN (met witte rijst)",
            "DIVERSEN",
            "EIERGERECHTEN (met witte rijst)",
            "GARNALEN GERECHTEN (met witte rijst)",
            "GROENTEN GERECHTEN (met witte rijst)",
            "INDISCHE GERECHTEN",
            "KINDERMENUS",
            "KIP GERECHTEN (met witte rijst)",
            "MIHOEN GERECHTEN",
            "OSSENHAAS GERECHTEN (met witte rijst)",
            "PEKING EEND GERECHTEN (met witte rijst)",
            "RIJSTTAFELS",
            "SOEP",
            "TIEPAN SPECIALITEITEN (met witte rijst)",
            "VEGETARISCHE GERECHTEN (met witte rijst)",
            "VISSEN GERECHTEN (met witte rijst)",
            "VLEES GERECHTEN (met witte rijst)",
            "VOORGERECHT",
        ];


        foreach ($types as $type) {
            DishType::create(['type' => ucfirst(strtolower($type))]);
        }
    }
}
