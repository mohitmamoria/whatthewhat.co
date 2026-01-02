<?php

namespace App\Http\Controllers\QR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelloAuthorsController extends Controller
{
    public function show(Request $request)
    {
        return inertia('QR/HelloAuthors', [
            'links' => [
                [
                    'name' => 'Nipun Jain',
                    'platform' => 'Instagram',
                    'label' => '@nipunnyy',
                    'imageUrl' => '/images/nipun-jain.png',
                    'href' => 'https://instagram.com/nipunnyy',
                ],
                [
                    'name' => 'Mohit Mamoria',
                    'platform' => 'Instagram',
                    'label' => '@mohitmamoria',
                    'imageUrl' => '/images/mohit-mamoria.png',
                    'href' => 'https://instagram.com/mohitmamoria',
                ],
                [
                    'name' => 'Nipun Jain',
                    'platform' => 'Twitter (or whatever it is called now)',
                    'label' => '@nipunnyy',
                    'imageUrl' => '/images/nipun-jain.png',
                    'href' => 'https://x.com/nipunnyy',
                ],
                [
                    'name' => 'Mohit Mamoria',
                    'platform' => 'Twitter (or whatever it is called now)',
                    'label' => '@mohitmamoria',
                    'imageUrl' => '/images/mohit-mamoria.png',
                    'href' => 'https://x.com/mohitmamoria',
                ],
            ],
        ]);
    }
}
