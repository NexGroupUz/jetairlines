<?php

namespace App\Support;

class Aircraft
{
    public static function cargo(): array
    {
        return [
            [
                'name' => 'АН-26',
                'image' => asset('images/aircraft/an-26.jpg'),
                'cargo_volume' => '39–45 м³',
                'cargo_dimensions' => '11.1 м × 2.2 м × 1.6 м',
                'door_size' => '2.3 м × 1.7 м',
                'payload' => '6–6.5 т',
                'manufacturer' => 'КБ Антонов / Украина',
            ],
            [
                'name' => 'АН-74',
                'image' => asset('images/aircraft/an-74.jpg'),
                'cargo_volume' => '45 м³',
                'cargo_dimensions' => '10 м × 2.15 м × 2.2 м',
                'door_size' => '2.2 м × 2.2 м',
                'payload' => '6.5–8 т',
                'manufacturer' => 'КБ Антонов / Украина',
            ],
            [
                'name' => 'АН-12',
                'image' => asset('images/aircraft/an-12.jpg'),
                'cargo_volume' => '90 м³',
                'cargo_dimensions' => '13.8 м × 3 м × 2.5 м',
                'door_size' => '3 м × 2.5 м',
                'payload' => '18 т',
                'manufacturer' => 'КБ Антонов / Россия',
            ],
            [
                'name' => 'АН-22',
                'image' => asset('images/aircraft/an-22.jpg'),
                'cargo_volume' => '650 м³',
                'cargo_dimensions' => '26.4 м × 4.4 м × 4.4 м',
                'door_size' => '4.4 м × 4.4 м',
                'payload' => '45–50 т',
                'manufacturer' => 'КБ Антонов / Узбекистан',
            ],
            [
                'name' => 'АН-124 "Руслан"',
                'image' => asset('images/aircraft/an-124.jpg'),
                'cargo_volume' => '800–1000 м³',
                'cargo_dimensions' => '36.5 м × 6.4 м × 4.4 м',
                'door_size' => '6.4 м × 4.4 м',
                'payload' => '120 т',
                'manufacturer' => 'КБ Антонов / Украина',
            ],
            [
                'name' => 'АН-225 "Мрия"',
                'image' => asset('images/aircraft/an-225.jpg'),
                'cargo_volume' => '1000 м³',
                'cargo_dimensions' => '43 м × 6.4 м × 4.4 м',
                'door_size' => '6.4 м × 4.4 м',
                'payload' => '250 т',
                'manufacturer' => 'КБ Антонов / Украина',
            ],
            [
                'name' => 'ИЛ-76',
                'image' => asset('images/aircraft/il-76.jpg'),
                'cargo_volume' => '180 м³',
                'cargo_dimensions' => '18.5 м × 3.45 м × 3.25 м',
                'door_size' => '3.4 м × 3.4 м',
                'payload' => '45 т',
                'manufacturer' => 'КБ Ильюшина / Россия',
            ],
            [
                'name' => 'Boeing 737',
                'image' => asset('images/aircraft/boeing-737.jpg'),
                'cargo_volume' => '80–105 м³',
                'cargo_dimensions' => '21 м × 3.1 м × 2.2 м',
                'door_size' => '3.4 м × 2.1 м',
                'payload' => '15–16 т',
                'manufacturer' => 'The Boeing Company / США',
            ],
            [
                'name' => 'Boeing 757',
                'image' => asset('images/aircraft/boeing-757.jpg'),
                'cargo_volume' => '185–187 м³',
                'cargo_dimensions' => '33 м × 3.5 м × 2.1 м',
                'door_size' => '3.4 м × 2.1 м',
                'payload' => '39 т',
                'manufacturer' => 'The Boeing Company / США',
            ],
            [
                'name' => 'Boeing 747',
                'image' => asset('images/aircraft/boeing-747.jpg'),
                'cargo_volume' => '600–750 м³',
                'cargo_dimensions' => '48–50 м × 3.17 м × 3 м',
                'door_size' => '3.4 м × 3 м',
                'payload' => '105–120 т',
                'manufacturer' => 'The Boeing Company / США',
            ],
            [
                'name' => 'Airbus A300',
                'image' => asset('images/aircraft/airbus-a300.jpg'),
                'cargo_volume' => '280 м³',
                'cargo_dimensions' => '39 м × 4.7 м × 2.2 м',
                'door_size' => '3.5 м × 2.5 м',
                'payload' => '43 т',
                'manufacturer' => 'Airbus / Европа',
            ],
            [
                'name' => 'ТУ-204',
                'image' => asset('images/aircraft/tu-204.jpg'),
                'cargo_volume' => '178 м³',
                'cargo_dimensions' => '29.5 м × 3.2 м × 2 м',
                'door_size' => '3.4 м × 2 м',
                'payload' => '28 т',
                'manufacturer' => 'КБ Туполева / Россия',
            ],
        ];
    }
}