<?php

namespace App\Http\Controllers;

use App\Support\FileJsonStore;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AdminSettingsController extends BaseController
{
    private function store(): FileJsonStore
    {
        return new FileJsonStore(base_path('storage/data/system-settings.json'), [
            'system_name' => 'HausTap',
            'contact_email' => 'support@example.com',
        ]);
    }

    public function get()
    {
        $data = $this->store()->read();
        if (!is_array($data)) { $data = []; }
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function save(Request $request)
    {
        // Accept both JSON and form-data
        $name = trim((string)$request->input('system_name', ''));
        $email = trim((string)$request->input('contact_email', ''));
        if ($name === '' || $email === '') {
            return response()->json(['success'=>false,'message'=>'system_name and contact_email required'], 422);
        }
        $this->store()->write(['system_name' => $name, 'contact_email' => $email]);
        return response()->json(['success' => true]);
    }
}