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
        
        $content['event']['date'] = $request->input('event_date', $content['event']['date'] ?? null);
        $content['event']['date_akad'] = $request->input('event_date_akad', $content['event']['date_akad'] ?? null);
        $content['event']['date_resepsi'] = $request->input('event_date_resepsi', $content['event']['date_resepsi'] ?? null);
        $content['event']['date_hijri'] = $request->input('event_date_hijri', $content['event']['date_hijri'] ?? null);
        
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

        // 1. Cover Image (Single)
        $content['cover_image'] = $request->input('cover_image', $content['cover_image'] ?? null);
        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('invitations/cover', 'public');
            $content['cover_image'] = asset('storage/' . $path);
        }

        // 2. Groom Photo (Single)
        $content['groom']['image'] = $request->input('groom_image', $content['groom']['image'] ?? null);
        if ($request->hasFile('groom_file')) {
            $path = $request->file('groom_file')->store('invitations/groom', 'public');
            $content['groom']['image'] = asset('storage/' . $path);
        }

        // 3. Bride Photo (Single)
        $content['bride']['image'] = $request->input('bride_image', $content['bride']['image'] ?? null);
        if ($request->hasFile('bride_file')) {
            $path = $request->file('bride_file')->store('invitations/bride', 'public');
            $content['bride']['image'] = asset('storage/' . $path);
        }

        // OG Image (Share Thumbnail)
        $content['og_image'] = $request->input('og_image', $content['og_image'] ?? null);
        if ($request->hasFile('og_file')) {
            $path = $request->file('og_file')->store('invitations/og', 'public');
            $content['og_image'] = asset('storage/' . $path);
        }

        // Section Backgrounds
        if ($request->hasFile('story_bg_file')) {
            $path = $request->file('story_bg_file')->store('invitations/bg', 'public');
            $content['story_bg'] = asset('storage/' . $path);
        }
        if ($request->hasFile('event_bg_file')) {
            $path = $request->file('event_bg_file')->store('invitations/bg', 'public');
            $content['event_bg'] = asset('storage/' . $path);
        }
        if ($request->hasFile('rsvp_bg_file')) {
            $path = $request->file('rsvp_bg_file')->store('invitations/bg', 'public');
            $content['rsvp_bg'] = asset('storage/' . $path);
        }

        // 4. Slideshow Images (Multiple Array)
        $current_slideshow = $request->input('slideshow_images', []);
        if ($request->hasFile('slideshow_files')) {
            foreach ($request->file('slideshow_files') as $file) {
                $path = $file->store('invitations/slideshow', 'public');
                $current_slideshow[] = asset('storage/' . $path);
            }
        }
        $content['hero_images'] = array_values(array_unique(array_filter($current_slideshow))); // Backwards compatible with existing hero slider

        // 5. Gallery Images (Multiple Array)
        $current_gallery = $request->input('gallery_images', []);
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('invitations/gallery', 'public');
                $current_gallery[] = asset('storage/' . $path);
            }
        }
        $content['gallery'] = array_values(array_unique(array_filter($current_gallery)));

        // Guest List
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
