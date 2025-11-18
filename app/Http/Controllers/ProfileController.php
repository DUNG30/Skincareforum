<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Hiển thị form chỉnh sửa profile
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Xử lý cập nhật profile
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'current_password' => 'nullable|required_with:password|string',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        // Cập nhật avatar nếu có file mới
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu tồn tại
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Lưu file mới
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Cập nhật tên và email
        $user->name = $request->name;
        $user->email = $request->email;

        // Cập nhật mật khẩu nếu có nhập
        if ($request->password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
