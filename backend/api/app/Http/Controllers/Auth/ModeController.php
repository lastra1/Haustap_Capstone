<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Support\FileJsonStore;
use App\Repositories\Firebase\UsersRepository;
use App\Services\Firebase\FirestoreClient;

class ModeController extends Controller
{
    public function get(Request $request)
    {
        $email = trim((string) $request->query('email', $request->input('email', '')));
        if ($email === '') {
            return response()->json(['success' => false, 'message' => 'email required'], 400);
        }

        $rolesStore = new FileJsonStore(storage_path('data/user_roles.json'), []);
        $modesStore = new FileJsonStore(storage_path('data/user_modes.json'), []);

        $rolesMap = $rolesStore->read();
        $modeMap = $modesStore->read();

        $roles = $rolesMap[$email] ?? ['client'];
        if (!is_array($roles)) {
            $roles = ['client'];
        }
        $mode = $modeMap[$email] ?? 'client';

        return response()->json([
            'success' => true,
            'email' => $email,
            'roles' => array_values(array_unique($roles)),
            'mode' => $mode,
        ]);
    }

    public function save(Request $request)
    {
        $email = trim((string) $request->input('email', ''));
        $mode = trim((string) $request->input('mode', ''));
        if ($email === '' || $mode === '') {
            return response()->json(['success' => false, 'message' => 'email and mode required'], 400);
        }

        $allowed = ['client', 'provider'];
        if (!in_array($mode, $allowed, true)) {
            return response()->json(['success' => false, 'message' => 'mode must be client or provider'], 422);
        }

        $rolesStore = new FileJsonStore(storage_path('data/user_roles.json'), []);
        $modesStore = new FileJsonStore(storage_path('data/user_modes.json'), []);

        $rolesMap = $rolesStore->read();
        $modeMap = $modesStore->read();

        $roles = $rolesMap[$email] ?? ['client'];
        if (!is_array($roles)) {
            $roles = ['client'];
        }
        // Auto-upgrade: if they toggle to provider, add provider role
        if ($mode === 'provider' && !in_array('provider', $roles, true)) {
            $roles[] = 'provider';
        }

        $rolesMap[$email] = array_values(array_unique($roles));
        $modeMap[$email] = $mode;

        $rolesStore->write($rolesMap);
        $modesStore->write($modeMap);

        try {
            $fs = new FirestoreClient();
            $users = new UsersRepository($fs);
            $userId = preg_replace('/[^a-z0-9]+/i', '-', strtolower($email));
            $userId = trim((string)$userId ?: 'user-' . md5($email), '-');
            $primaryRole = in_array('admin', $roles, true) ? 'admin' : ($mode === 'provider' ? 'provider' : 'client');
            if (!$users->exists($userId)) {
                $users->create([
                    'email' => $email,
                    'name' => $email,
                    'roles' => $roles,
                    'role' => $primaryRole,
                    'mode' => $mode,
                ], $userId);
            } else {
                $users->setRoles($userId, $roles, $primaryRole);
                $fs->patch('users', $userId, [ 'mode' => ['stringValue' => $mode] ]);
            }
        } catch (\Throwable $e) {
            // ignore Firestore errors
        }

        return response()->json([
            'success' => true,
            'email' => $email,
            'roles' => $rolesMap[$email],
            'mode' => $modeMap[$email],
        ]);
    }
}
