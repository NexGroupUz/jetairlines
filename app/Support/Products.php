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
                'image' => 'https://images.unsplash.com/photo-1600180758890-6b94519a8ba6?q=80&w=1200&auto=format&fit=crop',
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
                'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'slug' => 'metal-profile',
                'category' => 'Стройматериалы',
                'name' => 'Металлопрофиль',
                'description' => 'Профиль для кровли, фасадов и строительных конструкций.',
                'price' => 145000,
                'image' => 'https://images.unsplash.com/photo-1581092919535-7146ff1a590b?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'slug' => 'cnc-machine',
                'category' => 'Станки',
                'name' => 'CNC станок',
                'description' => 'Оборудование для обработки металла и промышленных задач.',
                'price' => 5000000,
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'slug' => 'cutting-machine',
                'category' => 'Станки',
                'name' => 'Отрезной станок',
                'description' => 'Промышленный станок для точной резки материалов.',
                'price' => 3500000,
                'image' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?q=80&w=1200&auto=format&fit=crop',
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