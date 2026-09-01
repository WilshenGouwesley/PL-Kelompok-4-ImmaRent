<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Admin: manage student & staff accounts
    public function index(Request $request)
    {
        $users = User::where('role', 'student')
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = $request->input('search');
                $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%"));
            })
            ->latest()
            ->paginate(7);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    // Update user data (name, email, class) from admin panel
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'class' => ['nullable', 'string', 'max:50'],
        ]);

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Data pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_if($user->role === 'admin', 403, 'Akun admin tidak dapat dihapus dari sini.');

        $user->delete();

        return back()->with('status', 'Pengguna dihapus.');
    }
}
