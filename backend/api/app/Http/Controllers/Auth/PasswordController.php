<?php

namespace App\Http\Controllers\Auth;

use App\Support\FileJsonStore;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class PasswordController extends BaseController
{
    private function store(): FileJsonStore
    {
        $path = base_path('storage/data/users.json');
        return new FileJsonStore($path, ['users' => []]);
    }

    public function register(Request $request)
    {
        $name = trim((string) $request->input('name'));
        $email = trim((string) $request->input('email'));
        $password = (string) $request->input('password');
        $confirm = (string) $request->input('confirmPassword');

        $errors = [];
        if ($name === '') { $errors['name'] = ['Name is required']; }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = ['Valid email required']; }
        if ($password === '' || strlen($password) < 6) { $errors['password'] = ['Password must be at least 6 characters']; }
        if ($confirm === '' || $confirm !== $password) { $errors['confirmPassword'] = ['Passwords do not match']; }
        if (!empty($errors)) { return response()->json(['success' => false, 'errors' => $errors], 422); }

        $store = $this->store()->read();
        $users = is_array($store['users'] ?? null) ? $store['users'] : [];
        foreach ($users as $u) {
            if (strcasecmp((string)($u['email'] ?? ''), $email) === 0) {
                return response()->json(['success' => false, 'errors' => ['email' => ['Email already registered']]], 422);
            }
        }

        $users[] = [
            'name' => $name,
            'email' => $email,
            'password_hash' => Hash::make($password),
            'role' => 'client',
        ];
        $this->store()->write(['users' => $users]);

        return response()->json([
            'success' => true,
            'user' => [
                'name' => $name,
                'email' => $email,
                'role' => 'client',
            ],
        ], 201);
    }

    public function login(Request $request)
    {
        $email = trim((string) $request->input('email'));
        $password = (string) $request->input('password');

        if ($email === '' || $password === '') {
            return response()->json(['success' => false, 'errors' => ['message' => ['email and password required']]], 422);
        }

        $store = $this->store()->read();
        $users = is_array($store['users'] ?? null) ? $store['users'] : [];
        foreach ($users as $u) {
            if (strcasecmp((string)($u['email'] ?? ''), $email) === 0) {
                $hash = (string)($u['password_hash'] ?? '');
                if ($hash !== '' && Hash::check($password, $hash)) {
                    return response()->json([
                        'success' => true,
                        'token' => 'dev-token-' . md5($email . $hash),
                        'user' => [
                            'name' => (string) ($u['name'] ?? ''),
                            'email' => $email,
                            'role' => (string) ($u['role'] ?? 'client'),
                        ],
                    ]);
                }
                break;
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
    }

    /**
     * Reset password using a verified OTP code.
     * Request body: { email, code, password, confirmPassword }
     */
    public function reset(Request $request)
    {
        $email = trim((string) $request->input('email'));
        $code = trim((string) $request->input('code'));
        $password = (string) $request->input('password');
        $confirm = (string) $request->input('confirmPassword');

        $errors = [];
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = ['Valid email required']; }
        if ($code === '') { $errors['code'] = ['OTP code is required']; }
        if ($password === '' || strlen($password) < 6) { $errors['password'] = ['Password must be at least 6 characters']; }
        if ($confirm === '' || $confirm !== $password) { $errors['confirmPassword'] = ['Passwords do not match']; }
        if (!empty($errors)) { return response()->json(['success' => false, 'errors' => $errors], 422); }

        // Validate OTP code from storage
        $otpPath = base_path('storage/data/otp.json');
        $otpStore = new FileJsonStore($otpPath, ['records' => []]);
        $otpData = $otpStore->read();
        $records = is_array($otpData['records'] ?? null) ? $otpData['records'] : [];
        $now = round(microtime(true) * 1000);
        $valid = false;
        $newRecords = [];
        foreach ($records as $r) {
            $rEmail = (string)($r['email'] ?? '');
            $rCode = (string)($r['code'] ?? '');
            $rExpires = (int)($r['expires'] ?? 0);
            if ($rEmail === $email && $rCode === $code) {
                if ($rExpires < $now) { return response()->json(['success' => false, 'message' => 'code expired'], 400); }
                $valid = true; // consume this record
                continue; // drop consumed OTP
            }
            $newRecords[] = $r;
        }
        if (!$valid) { return response()->json(['success' => false, 'message' => 'invalid code'], 400); }
        // Persist remaining OTP records (consume used one)
        $otpStore->write(['records' => $newRecords]);

        // Update user's password
        $store = $this->store()->read();
        $users = is_array($store['users'] ?? null) ? $store['users'] : [];
        $found = false;
        foreach ($users as &$u) {
            if (strcasecmp((string)($u['email'] ?? ''), $email) === 0) {
                $u['password_hash'] = Hash::make($password);
                $found = true;
                break;
            }
        }
        unset($u);
        if (!$found) { return response()->json(['success' => false, 'message' => 'email not registered'], 404); }
        $this->store()->write(['users' => $users]);

        return response()->json(['success' => true, 'message' => 'password updated']);
    }
}