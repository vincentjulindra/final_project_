<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Session;
use DB;  // Untuk raw queries

class AuthController extends Controller
{
    // Registrasi pengguna baru
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan user dengan password di-hash (bcrypt bawaan Laravel)
        $user = User::create([
            'name' => htmlspecialchars($request->name), // sanitasi XSS
            'email' => htmlspecialchars($request->email),
            'password' => Hash::make($request->password),
        ]);

        // HINDARI raw SQL. Gunakan Eloquent atau query builder:
        $existingUser = DB::table('users')
            ->where('email', htmlspecialchars($request->email))
            ->first();

        // JWT key HARUS kuat dan disimpan di .env
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (60 * 60), // expired in 1 hour
        ];

        $jwtSecret = env('JWT_SECRET', 'default-strong-secret');
        $token = JWT::encode($payload, $jwtSecret, 'HS256');

        // Simpan session jika perlu
        Session::put('user_id', $user->id);

        // Berikan response yang aman
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // Login pengguna
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cegah SQL Injection dengan query builder
        $user = DB::table('users')->where('email', $request->email)->first();

        // Jika user tidak ditemukan atau password tidak cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Gunakan kunci JWT yang aman dari .env, dan tambahkan `exp`
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (60 * 60), // token berlaku 1 jam
        ];

        $jwtSecret = env('JWT_SECRET', 'default_secure_secret_key');
        $token = JWT::encode($payload, $jwtSecret, 'HS256');

        // Simpan session user jika memang diperlukan
        Session::put('user_id', $user->id);

        // Kirim token JWT sebagai respon
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // Logout pengguna
    public function logout(Request $request)
    {   
        // Tidak perlu hapus token di server jika pakai JWT stateless
        // Tapi kamu bisa blacklist token (jika pakai JWT blacklist system)

        // Hapus semua data session pengguna
        Session::flush(); // Hapus semua data session, bukan hanya user_id

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
