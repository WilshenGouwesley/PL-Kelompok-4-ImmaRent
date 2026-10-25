<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Admin: manage student & staff accounts
    public function index(Request $request)
    {
        $users = User::query()
            ->students()
            ->search($request->input('search'))
            ->latest()
            ->paginate(7)
            ->withQueryString();

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
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Data pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_if($user->isAdmin(), 403, 'Akun admin tidak dapat dihapus dari sini.');

        $user->delete();

        // redirect eksplisit: back() akan mengarah ke halaman edit user yang baru dihapus (404)
        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Pengguna dihapus.');
    }
}
