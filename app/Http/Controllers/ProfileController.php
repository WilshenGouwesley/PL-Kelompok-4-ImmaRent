<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $validated = $request->safe()->except(['avatar', 'remove_avatar']);

        $oldAvatar = $user->avatar;
        $avatarChanged = false;

        if ($request->hasFile('avatar')) {
            // foto baru (menang atas centang "remove"); nama file diacak otomatis oleh store()
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
            $avatarChanged = true;
        } elseif ($request->boolean('remove_avatar')) {
            $validated['avatar'] = null;
            $avatarChanged = true;
        }

        $user->update($validated);

        // File lama dihapus SETELAH database berhasil diperbarui, jadi tidak ada file yatim.
        if ($avatarChanged && $oldAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }

        return back()->with('status', 'Profil berhasil diperbarui.');
    }
}
