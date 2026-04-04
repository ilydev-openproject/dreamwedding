<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        // For Dashboard index we only fetch a few metrics, here using the same object for simplicity
        $invitations = Invitation::latest()->get();
        return view('admin.index', compact('invitations'));
    }

    public function clients()
    {
        $invitations = Invitation::latest()->get();
        return view('admin.clients', compact('invitations'));
    }

    public function themes()
    {
        return view('admin.themes');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'slug' => 'required|string|unique:invitations,slug',
            'template_id' => 'required|string'
        ]);

        $invitation = Invitation::create([
            'customer_name' => $request->customer_name,
            'slug' => Str::slug($request->slug),
            'template_id' => $request->template_id,
            'access_token' => Str::random(40), // Secret token for magic link
            'content' => [
                'groom' => ['nickname' => '', 'name' => '', 'parents' => ''],
                'bride' => ['nickname' => '', 'name' => '', 'parents' => ''],
                'event' => ['date' => '', 'time' => '', 'location' => '', 'address' => '']
            ]
        ]);

        return redirect()->back()->with('success', 'Order berhasil! Bagikan tautan Dashboard Klien secara rahasia untuk membiarkan klien melengkapi informasinya: <br><strong class="mt-2 block bg-emerald-100 p-2 text-emerald-900 rounded select-all">' . url('/dashboard/' . $invitation->access_token) . '</strong>');
    }
    public function updateTheme(Request $request, $id)
    {
        $request->validate([
            'template_id' => 'required|string',
        ]);

        $invitation = Invitation::findOrFail($id);
        $invitation->template_id = $request->template_id;
        $invitation->save();

        return redirect()->back();
    }
}
