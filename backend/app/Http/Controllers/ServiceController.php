<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->has('category_id')) {
            $query->where('service_category_id', $request->category_id);
        }

        $services = $query->get();

        return response()->json($services);
    }

}
