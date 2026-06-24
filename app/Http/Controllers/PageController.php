<?php

namespace App\Http\Controllers;

use App\Support\Products;
use App\Support\Aircraft;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'salesProducts' => Products::sales(),
            'aviationProducts' => Products::aviation(),
            'products' => Products::all(),
        ]);
    }

    public function sales(): View
    {
        return view('pages.sales', [
            'products' => Products::sales(),
        ]);
    }

    public function aviation(): View
    {
        return view('pages.aviation', [
            'products' => Products::aviation(),
        ]);
    }

    public function cargo(): View
    {
        return view('pages.cargo', [
            'aircraft' => Aircraft::cargo(),
        ]);
    }

    public function policy(): View
    {
        return view('pages.policy');
    }

    public function agreement(): View
    {
        return view('pages.agreement');
    }

    public function offer(): View
    {
        return view('pages.offer');
    }

    public function equipment(): View
    {
        $documents = [
            [
                'title' => 'Спецификация №1 от 23.11.23',
                'description' => 'Технический документ или спецификация оборудования.',
                'file' => asset('files/equipment/document-1.xlsx'),
                'type' => 'XLSX',
            ],
            [
                'title' => 'Свод запчастей до кроссировки',
                'description' => 'Дополнительная информация по оборудованию.',
                'file' => asset('files/equipment/document-2.xlsx'),
                'type' => 'XLSX',
            ],
            [
                'title' => 'Фальшпол',
                'description' => 'Дополнительная информация по оборудованию.',
                'file' => asset('files/equipment/document-3.xlsx'),
                'type' => 'XLSX',
            ],
            [
                'title' => 'Насосы',
                'description' => 'Дополнительная информация по оборудованию.',
                'file' => asset('files/equipment/document-4.xlsx'),
                'type' => 'XLSX',
            ],
            [
                'title' => '2_5235689451652419015',
                'description' => 'Дополнительная информация по оборудованию.',
                'file' => asset('files/equipment/document-5.xlsx'),
                'type' => 'XLSX',
            ],
            [
                'title' => 'KRASIVOE_DELO_LLC__Russia__25_March_2026__6_Servo_VFFS_Quote',
                'description' => 'Коммерческое предложение и техническая информация.',
                'file' => asset('files/equipment/document-6.pdf'),
                'type' => 'PDF',
            ],
            [
                'title' => 'Техн.свет+Китай+Польша',
                'description' => 'Дополнительные технические материалы.',
                'file' => asset('files/equipment/document-7.pdf'),
                'type' => 'PDF',
            ],
        ];

        $certificates = [
            [
                'title' => 'Сертификат соответствия',
                'description' => 'Сертификационный документ по оборудованию.',
                'file' => asset('files/equipment/certificate-1.pdf'),
                'type' => 'PDF',
            ],
        ];

        $photos = [
            asset('images/equipment/photo-1.jpg'),
            asset('images/equipment/photo-2.jpg'),
        ];

        return view('pages.equipment', [
            'documents' => $documents,
            'certificates' => $certificates,
            'photos' => $photos,
        ]);
    }
}