<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Support\FileJsonStore;

class ProviderController extends Controller
{
    private function rolesStore() { return new FileJsonStore(storage_path('data/user_roles.json'), []); }
    private function modesStore() { return new FileJsonStore(storage_path('data/user_modes.json'), []); }
    private function statusStore() { return new FileJsonStore(storage_path('data/provider_status.json'), []); }
    private function applicationsStore() { return new FileJsonStore(storage_path('data/provider_applications.json'), []); }

    public function status(Request $request)
    {
        $email = trim((string) $request->query('email', $request->input('email', '')));
        if ($email === '') {
            return response()->json(['success' => false, 'message' => 'email required'], 400);
        }
        $rolesMap = $this->rolesStore()->read();
        $modeMap = $this->modesStore()->read();
        $statusMap = $this->statusStore()->read();

        $roles = $rolesMap[$email] ?? ['client'];
        if (!is_array($roles)) { $roles = ['client']; }
        $mode = $modeMap[$email] ?? 'client';
        $status = (string) ($statusMap[$email]['status'] ?? 'none');

        return response()->json([
            'success' => true,
            'email' => $email,
            'roles' => array_values(array_unique($roles)),
            'mode' => $mode,
            'status' => $status,
        ]);
    }

    public function apply(Request $request)
    {
        $email = trim((string) $request->input('email', ''));
        if ($email === '') {
            return response()->json(['success' => false, 'message' => 'email required'], 400);
        }

        $name = trim((string) ($request->input('name', $request->input('full_name', ''))));
        $phone = trim((string) $request->input('phone', ''));
        $experience = trim((string) $request->input('experience', ''));
        $services = $request->input('services', []);
        if (is_string($services)) {
            $services = array_filter(array_map('trim', explode(',', $services)));
        }
        if (!is_array($services)) { $services = []; }

        $apps = $this->applicationsStore()->read();
        $apps[$email] = [
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'experience' => $experience,
            'services' => $services,
            'status' => 'pending',
            'submitted_at' => date('c'),
        ];
        $this->applicationsStore()->write($apps);

        $statusMap = $this->statusStore()->read();
        $statusMap[$email] = [ 'status' => 'pending', 'updated_at' => date('c') ];
        $this->statusStore()->write($statusMap);

        $rolesMap = $this->rolesStore()->read();
        $roles = $rolesMap[$email] ?? ['client'];
        if (!in_array('provider', $roles, true)) { $roles[] = 'provider'; }
        $rolesMap[$email] = array_values(array_unique($roles));
        $this->rolesStore()->write($rolesMap);

        return response()->json(['success' => true, 'status' => 'pending']);
    }

    public function approve(Request $request)
    {
        $email = trim((string) $request->input('email', ''));
        if ($email === '') {
            return response()->json(['success' => false, 'message' => 'email required'], 400);
        }
        $statusMap = $this->statusStore()->read();
        $statusMap[$email] = [ 'status' => 'approved', 'updated_at' => date('c') ];
        $this->statusStore()->write($statusMap);

        $rolesMap = $this->rolesStore()->read();
        $roles = $rolesMap[$email] ?? ['client'];
        if (!in_array('provider', $roles, true)) { $roles[] = 'provider'; }
        $rolesMap[$email] = array_values(array_unique($roles));
        $this->rolesStore()->write($rolesMap);

        return response()->json(['success' => true, 'status' => 'approved']);
    }

    public function revoke(Request $request)
    {
        $email = trim((string) $request->input('email', ''));
        if ($email === '') {
            return response()->json(['success' => false, 'message' => 'email required'], 400);
        }
        $statusMap = $this->statusStore()->read();
        $statusMap[$email] = [ 'status' => 'none', 'updated_at' => date('c') ];
        $this->statusStore()->write($statusMap);

        // Keep provider role optional: admin revoke removes role entirely
        $removeRole = (bool) ($request->input('remove_role', false));
        if ($removeRole) {
            $rolesMap = $this->rolesStore()->read();
            $roles = $rolesMap[$email] ?? ['client'];
            $roles = array_values(array_filter($roles, fn($r) => $r !== 'provider'));
            $rolesMap[$email] = count($roles) ? $roles : ['client'];
            $this->rolesStore()->write($rolesMap);
        }

        return response()->json(['success' => true, 'status' => 'none']);
    }
}