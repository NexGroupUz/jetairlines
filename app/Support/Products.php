<?php

namespace App\Support;

class Products
{
    public static function all(): array
    {
        return [
            [
                'slug' => 'cnc-machine',
                'group' => 'sales',
                'category' => 'Станки',
                'name' => 'CNC станок',
                'description' => 'Промышленное оборудование для обработки металла и производственных задач.',
                'price_usd' => 4200,
                'image' => 'https://images.unsplash.com/photo-1666618090858-fbcee636bd3e?q=80&w=2340&auto=format&fit=crop',
            ],
            [
                'slug' => 'cutting-machine',
                'group' => 'sales',
                'category' => 'Станки',
                'name' => 'Отрезной станок',
                'description' => 'Оборудование для точной резки металла, профиля и других материалов.',
                'price_usd' => 2900,
                'image' => 'https://images.unsplash.com/photo-1515630771457-09367d0ae038?q=80&w=2340&auto=format&fit=crop',
            ],
            [
                'slug' => 'industrial-equipment',
                'group' => 'sales',
                'category' => 'Оборудование',
                'name' => 'Промышленное оборудование',
                'description' => 'Оборудование и технические решения для производственных объектов.',
                'price_usd' => 7500,
                'image' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?q=80&w=2340&auto=format&fit=crop',
            ],
            [
                'slug' => 'metal-profile',
                'group' => 'sales',
                'category' => 'Стройматериалы',
                'name' => 'Металлопрофиль',
                'description' => 'Профиль для кровли, фасадов и строительных конструкций.',
                'price_usd' => 120,
                'image' => 'https://plus.unsplash.com/premium_photo-1677172409352-44e6d642c320?q=80&w=2340&auto=format&fit=crop',
            ],
            [
                'slug' => 'air-cargo-transportation',
                'group' => 'aviation',
                'category' => 'Авиаперевозки',
                'name' => 'Авиаперевозка грузов',
                'description' => 'Организация грузовых авиаперевозок для срочных, коммерческих и крупногабаритных отправлений.',
                'price_usd' => 1500,
                'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=2340&auto=format&fit=crop',
            ],
            [
                'slug' => 'business-jet-charter',
                'group' => 'aviation',
                'category' => 'Аренда воздушных судов',
                'name' => 'Аренда бизнес-джета',
                'description' => 'Фрахт бизнес-джетов для деловых перелётов, частных рейсов и индивидуальных маршрутов.',
                'price_usd' => 12000,
                'image' => 'https://images.unsplash.com/photo-1540962351504-03099e0a754b?q=80&w=2340&auto=format&fit=crop',
            ],
            [
                'slug' => 'cargo-aircraft-charter',
                'group' => 'aviation',
                'category' => 'Фрахт грузовых самолётов',
                'name' => 'Аренда грузового самолёта',
                'description' => 'Фрахт грузовых воздушных судов для перевозки оборудования, коммерческих партий и нестандартных грузов.',
                'price_usd' => 25000,
                'image' => 'https://images.unsplash.com/photo-1570710891163-6d3b5c47248b?q=80&w=2340&auto=format&fit=crop',
            ],
        ];
    }

    public static function sales(): array
    {
        return array_values(array_filter(self::all(), fn ($product) => $product['group'] === 'sales'));
    }

    public static function aviation(): array
    {
        return array_values(array_filter(self::all(), fn ($product) => $product['group'] === 'aviation'));
    }

    public static function find(string $slug): ?array
    {
        foreach (self::all() as $product) {
            if ($product['slug'] === $slug) {
                return $product;
            }
        }

        return null;
    }
}