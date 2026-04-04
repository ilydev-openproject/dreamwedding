<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invitation;
use App\Models\Rsvp;

class RsvpController extends Controller
{
    public function store(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'message' => 'nullable|string',
        ]);

        Rsvp::create([
            'invitation_id' => $invitation->id,
            'name' => $request->name,
            'status' => $request->status,
            'message' => $request->message,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Konfirmasi kehadiran berhasil dikirim!']);
        }

        return redirect()->back()->with('success_rsvp', 'Konfirmasi kehadiran berhasil dikirim!');
    }

    public function updateReply(Request $request, $id)
    {
        $rsvp = Rsvp::findOrFail($id);
        $rsvp->update(['reply' => $request->reply]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Balasan berhasil disimpan!']);
        }

        return redirect()->back()->with('success', 'Balasan berhasil disimpan!');
    }

    public function destroy($id)
    {
        $rsvp = Rsvp::findOrFail($id);
        $rsvp->delete();

        return redirect()->back()->with('success', 'Pesan berhasil dihapus!');
    }
}
