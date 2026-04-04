<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;

class DashboardController extends Controller
{
    // Access via the secret magic link token
    public function show($token)
    {
        $invitation = Invitation::where('access_token', $token)->firstOrFail();
        return view('dashboard.show', compact('invitation'));
    }

    // Process form
    public function update(Request $request, $token)
    {
        $invitation = Invitation::where('access_token', $token)->firstOrFail();

        $content = $invitation->content ?? [];
        $content['groom']['nickname'] = $request->input('groom_nickname');
        $content['groom']['name'] = $request->input('groom_name');
        $content['groom']['parents'] = $request->input('groom_parents');
        
        $content['bride']['nickname'] = $request->input('bride_nickname');
        $content['bride']['name'] = $request->input('bride_name');
        $content['bride']['parents'] = $request->input('bride_parents');
        
        $content['event']['date'] = $request->input('event_date');
        $content['event']['date_hijri'] = $request->input('event_date_hijri');
        
        $content['event']['time_akad'] = $request->input('event_time_akad');
        $content['event']['location_akad_name'] = $request->input('event_location_akad_name');
        $content['event']['location_akad_detail'] = $request->input('event_location_akad_detail');
        $content['event']['location_akad_city'] = $request->input('event_location_akad_city');
        $content['event']['maps_akad'] = $request->input('event_maps_akad');

        $content['event']['time_resepsi'] = $request->input('event_time_resepsi');
        $content['event']['location_resepsi_name'] = $request->input('event_location_resepsi_name');
        $content['event']['location_resepsi_detail'] = $request->input('event_location_resepsi_detail');
        $content['event']['location_resepsi_city'] = $request->input('event_location_resepsi_city');
        $content['event']['maps_resepsi'] = $request->input('event_maps_resepsi');

        // Shipping Info (New Fields)
        if ($request->has('event')) {
            $eventInput = $request->input('event');
            $content['event']['recipient_name'] = $eventInput['recipient_name'] ?? '';
            $content['event']['recipient_phone'] = $eventInput['recipient_phone'] ?? '';
            $content['event']['recipient_address'] = $eventInput['recipient_address'] ?? '';
        }

        // Wedding Gifts (Repeater)
        if ($request->has('gifts')) {
            $content['gifts'] = $request->input('gifts');
        } elseif ($request->filled('gift_bank')) {
            // Fallback for old single field if needed
            $content['gifts'] = [
                [
                    'bank_name' => $request->input('gift_bank'),
                    'account_number' => $request->input('gift_number'),
                    'account_name' => $request->input('gift_name'),
                ]
            ];
        }

        // Stories (Repeater)
        if ($request->has('stories')) {
            $content['stories'] = $request->input('stories');
        } elseif ($request->filled('story_title')) {
            // Fallback for old single field
            $content['stories'] = [
                [
                    'title' => $request->input('story_title'),
                    'content' => $request->input('story_content'),
                ]
            ];
        }

        // Hero Images (Uploads + Management)
        $current_hero = $request->input('hero_images', []);
        if ($request->hasFile('hero_files')) {
            foreach ($request->file('hero_files') as $file) {
                $path = $file->store('invitations/hero', 'public');
                $current_hero[] = asset('storage/' . $path);
            }
        }
        $content['hero_images'] = array_values(array_unique(array_filter($current_hero)));

        // Gallery Images (Uploads + Management)
        $current_gallery = $request->input('gallery_images', []);
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('invitations/gallery', 'public');
                $current_gallery[] = asset('storage/' . $path);
            }
        }
        $content['gallery'] = array_values(array_unique(array_filter($current_gallery)));

        // Guest List (New)
        if ($request->has('guests')) {
            $content['guests'] = array_values(array_filter($request->input('guests'), function($guest) {
                return !empty($guest['name']);
            }));
        }

        $invitation->content = $content;
        $invitation->save();

        return redirect()->back()->with('success', 'Data undangan berhasil diperbarui!');
    }
}
