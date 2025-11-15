<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Repositories\Firebase\UsersRepository;
use App\Services\Firebase\FirestoreClient;
use App\Support\FileJsonStore;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class PasswordController extends BaseController
{
    // Note: Registration and login now use the MySQL users table via Eloquent.

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
        // Ensure email is unique in the DB
        if (User::where('email', $email)->exists()) {
            return response()->json(['success' => false, 'errors' => ['email' => ['Email already registered']]], 422);
        }

        // Persist to MySQL users table with default role 'client'
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'client',
        ]);

        try {
            $fs = new FirestoreClient();
            $usersRepo = new UsersRepository($fs);
            $userId = preg_replace('/[^a-z0-9]+/i', '-', strtolower($email ?: $name));
            $userId = trim((string)$userId ?: 'client-' . md5($email), '-');
            $usersRepo->create([
                'email' => $email,
                'name' => $name,
                'roles' => ['client'],
                'role' => 'client'
            ], $userId);
        } catch (\Throwable $e) {
            // ignore Firestore errors for registration flow
        }

        return response()->json([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
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

        // Verify against DB users table
        $user = User::where('email', $email)->first();
        if ($user && $user->password && Hash::check($password, $user->password)) {
            $token = 'dev-token-' . md5($user->email . $user->password);
            // Persist token to remember_token for middleware auth
            $user->remember_token = $token;
            $user->save();

            // Ensure Firestore user doc exists and has role
            try {
                $fs = new FirestoreClient();
                $usersRepo = new UsersRepository($fs);
                $userId = preg_replace('/[^a-z0-9]+/i', '-', strtolower($user->email ?: $user->name));
                $userId = trim((string)$userId ?: 'client-' . md5($user->email), '-');
                $roleVal = $user->role ?: 'client';
                if (!$usersRepo->exists($userId)) {
                    $usersRepo->create([
                        'email' => $user->email,
                        'name' => $user->name,
                        'roles' => [$roleVal],
                        'role' => $roleVal
                    ], $userId);
                } else {
                    $usersRepo->setRoles($userId, [$roleVal], $roleVal);
                }
            } catch (\Throwable $e) {
                // ignore Firestore errors for login flow
            }

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role ?: 'client',
                ],
            ]);
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

        // Update user's password in DB
        $user = User::where('email', $email)->first();
        if (!$user) { return response()->json(['success' => false, 'message' => 'email not registered'], 404); }
        $user->password = Hash::make($password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'password updated']);
    }
}
