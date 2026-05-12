<?php

namespace App\Support;

class Products
{
    public static function all(): array
    {
        return [
            [
                'slug' => 'cotton-fabric',
                'category' => 'Текстиль',
                'name' => 'Хлопковая ткань',
                'description' => 'Текстильная продукция для пошива, производства и оптовых поставок.',
                'price' => 85000,
                'image' => 'https://plus.unsplash.com/premium_photo-1674747087104-516a4d6d316c?q=80&w=987&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'slug' => 'home-textile',
                'category' => 'Текстиль',
                'name' => 'Домашний текстиль',
                'description' => 'Текстильные изделия для дома, гостиниц, торговых точек и корпоративных заказов.',
                'price' => 160000,
                'image' => 'https://images.unsplash.com/photo-1531877025030-f7696a50770f?q=80&w=2340&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'slug' => 'fresh-vegetables',
                'category' => 'Свежеплодоовощная продукция',
                'name' => 'Свежие овощи',
                'description' => 'Свежая овощная продукция для торговли, ресторанов и оптовых поставок.',
                'price' => 45000,
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=2340&auto=format&fit=crop',
            ],
            [
                'slug' => 'fresh-fruits',
                'category' => 'Свежеплодоовощная продукция',
                'name' => 'Свежие фрукты',
                'description' => 'Сезонные фрукты для розничных продаж, HoReCa и торговых организаций.',
                'price' => 65000,
                'image' => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?q=80&w=2340&auto=format&fit=crop',
            ],
            [
                'slug' => 'cement-m500',
                'category' => 'Стройматериалы',
                'name' => 'Цемент М500',
                'description' => 'Строительный цемент для объектов разного масштаба.',
                'price' => 68000,
                'image' => 'https://plus.unsplash.com/premium_photo-1683121530725-e9ddd6c74ef1?q=80&w=2340&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'slug' => 'metal-profile',
                'category' => 'Стройматериалы',
                'name' => 'Металлопрофиль',
                'description' => 'Профиль для кровли, фасадов и строительных конструкций.',
                'price' => 145000,
                'image' => 'https://plus.unsplash.com/premium_photo-1677172409352-44e6d642c320?q=80&w=2340&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'slug' => 'cnc-machine',
                'category' => 'Станки',
                'name' => 'CNC станок',
                'description' => 'Оборудование для обработки металла и промышленных задач.',
                'price' => 5000000,
                'image' => 'https://images.unsplash.com/photo-1666618090858-fbcee636bd3e?q=80&w=2340&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'slug' => 'cutting-machine',
                'category' => 'Станки',
                'name' => 'Отрезной станок',
                'description' => 'Промышленный станок для точной резки материалов.',
                'price' => 3500000,
                'image' => 'https://images.unsplash.com/photo-1515630771457-09367d0ae038?q=80&w=2340&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
        ];
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