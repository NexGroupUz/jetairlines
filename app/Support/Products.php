<?php

namespace App\Support;

class Products
{
    public static function all(): array
    {
        return [
            [
                'slug' => 'dried-apricots',
                'category' => 'Сухофрукты',
                'name' => 'Курага отборная',
                'description' => 'Натуральная курага для оптовых и розничных поставок.',
                'price' => 120000,
                'image' => 'https://images.unsplash.com/photo-1595412017587-b7f3117dff54?q=80&w=2346&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'slug' => 'raisins-premium',
                'category' => 'Сухофрукты',
                'name' => 'Изюм премиум',
                'description' => 'Сортированный изюм для торговли, HoReCa и производства.',
                'price' => 95000,
                'image' => 'https://plus.unsplash.com/premium_photo-1669205434519-a042ba09fbdd?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
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