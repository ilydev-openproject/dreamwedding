<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;

class InvitationController extends Controller
{
    // Public view via /invite/{slug}
    public function show($slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();
        
        // Pass data to the specific template view based on template_id
        // We will store templates in resources/views/templates/
        return view('templates.' . $invitation->template_id, [
            'invitation' => $invitation,
            'data' => $invitation->content,
            'is_preview' => false
        ]);
    }

    public function demo($template_id)
    {
        // Mock data structure directly matching what the AR-019 template expects from `data` array
        $mockData = [
            'groom' => [
                'nickname' => 'Romeo',
                'name' => 'Romeo Anargya, S.T.',
                'parents' => 'Putra dari Bapak Fulan & Ibu Fulanah'
            ],
            'bride' => [
                'nickname' => 'Juliet',
                'name' => 'Juliet Kirana, S.E.',
                'parents' => 'Putri dari Bapak Polan & Ibu Polanah'
            ],
            'event' => [
                'date' => 'Minggu, 20 Desember 2026',
                'time' => '09.00 WIB - Selesai',
                'location' => 'Grand Hotel Ballroom',
                'address' => 'Jl. Sudirman No 45, Jakarta Pusat'
            ]
        ];

        return view('templates.' . $template_id, [
            'data' => $mockData,
            'is_preview' => true
        ]);
    }
}
