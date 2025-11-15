<?php
namespace App\Http\Controllers;

use App\Repositories\Firebase\CategoriesRepository;
use App\Repositories\Firebase\ProvidersRepository;
use App\Repositories\Firebase\BookingsRepository;
use App\Repositories\Firebase\ApplicantsRepository;
use App\Repositories\Firebase\UsersRepository;
use App\Repositories\Firebase\ServicesRepository;
use App\Services\Firebase\FirestoreClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirebaseController extends Controller
{
    private CategoriesRepository $cats;
    private ProvidersRepository $providers;
    private BookingsRepository $bookings;
    private ApplicantsRepository $applicants;
    private UsersRepository $users;
    private ServicesRepository $services;

    public function __construct()
    {
        $fs = new FirestoreClient();
        $this->cats = new CategoriesRepository($fs);
        $this->providers = new ProvidersRepository($fs);
        $this->bookings = new BookingsRepository($fs);
        $this->applicants = new ApplicantsRepository($fs);
        $this->users = new UsersRepository($fs);
        $this->services = new ServicesRepository($fs);
    }

    public function categories()
    {
        return response()->json(['success' => true, 'categories' => $this->cats->list()]);
    }

    public function firebaseConfig()
    {
        try {
            $cfg = [
                'apiKey' => (string)(env('FIREBASE_API_KEY') ?? ''),
                'authDomain' => (string)(env('FIREBASE_AUTH_DOMAIN') ?? ''),
                'projectId' => (string)(env('FIREBASE_PROJECT_ID') ?? ''),
                'appId' => (string)(env('FIREBASE_APP_ID') ?? ''),
                'storageBucket' => (string)(env('FIREBASE_STORAGE_BUCKET') ?? ''),
                'messagingSenderId' => (string)(env('FIREBASE_MESSAGING_SENDER_ID') ?? ''),
            ];
            $meas = env('FIREBASE_MEASUREMENT_ID');
            if (!empty($meas)) { $cfg['measurementId'] = (string)$meas; }
            return response()->json(['success' => true, 'config' => $cfg])
                ->withHeaders([
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods' => 'GET, OPTIONS',
                    'Access-Control-Allow-Headers' => 'Content-Type, Accept'
                ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function categoriesCreate(Request $req)
    {
        $data = $req->all();
        $v = Validator::make($data, [
            'slug' => ['required','string','regex:/^[a-z0-9-]+$/'],
            'name' => ['required','string','max:100'],
            'description' => ['nullable','string','max:500']
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        $id = $this->cats->create([
            'slug' => (string)$data['slug'],
            'name' => (string)$data['name'],
            'description' => (string)($data['description'] ?? '')
        ], (string)$data['slug']);
        return response()->json(['success' => true, 'data' => ['id' => $id]]);
    }

    public function categoriesSeed()
    {
        $preset = [
            ['slug' => 'cleaning', 'name' => 'Cleaning', 'description' => 'Home and AC cleaning services'],
            ['slug' => 'beauty', 'name' => 'Beauty', 'description' => 'Hair, makeup, nails'],
            ['slug' => 'wellness', 'name' => 'Wellness', 'description' => 'Massage, spa, therapy'],
            ['slug' => 'electrical', 'name' => 'Electrical', 'description' => 'Electrical services and repairs'],
            ['slug' => 'plumbing', 'name' => 'Plumbing', 'description' => 'Plumbing services and repairs'],
            ['slug' => 'handyman', 'name' => 'Handyman', 'description' => 'General handyman services'],
            ['slug' => 'pest-control', 'name' => 'Pest Control', 'description' => 'Indoor and outdoor pest control'],
            ['slug' => 'gardening', 'name' => 'Gardening', 'description' => 'Garden landscaping and maintenance'],
            ['slug' => 'tech', 'name' => 'Tech & Gadgets', 'description' => 'Computer, mobile, tablet services'],
            ['slug' => 'ac-cleaning', 'name' => 'AC Cleaning', 'description' => 'Air conditioner cleaning and deep clean'],
        ];
        $created = [];
        foreach ($preset as $c) {
            $id = $this->cats->create($c, (string)$c['slug']);
            if ($id) $created[] = $id;
        }
        return response()->json(['success' => true, 'created' => $created]);
    }

    public function categoryGet(string $slug)
    {
        return response()->json(['success' => true, 'data' => $this->cats->get($slug)]);
    }

    public function categorySetPrice(string $slug, Request $req)
    {
        $data = $req->all();
        $v = Validator::make($data, [
            'price' => ['required','numeric','min:0'],
            'unit' => ['nullable','string','max:50'],
            'variants' => ['array'],
            'variants.*.name' => ['required_with:variants','string','max:100'],
            'variants.*.price' => ['nullable','numeric','min:0'],
            'variants.*.unit' => ['nullable','string','max:50']
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        $price = (float)($data['price'] ?? 0);
        $unit = (string)($data['unit'] ?? '');
        $variants = (array)($data['variants'] ?? []);
        $ok = $this->cats->setPrice($slug, $price, $unit, $variants);
        return response()->json(['success' => $ok]);
    }

    public function categoriesSeedFromUIAcCleaning()
    {
        try {
            $path = base_path('..\\..\\Haustap_Capstone-Haustap_Connecting\\Haustap_Capstone-Haustap_Connecting\\mobile_app\\HausTap\\app\\client-side\\data\\cleaning.ts');
            $src = @file_get_contents($path);
            if ($src === false) return response()->json(['success' => false, 'error' => 'file_not_found'], 404);
            $variants = [];
            $pattern = '/title:\s*"([^"]+)",[\s\S]*?price:\s*"₱([0-9,]+)\/unit"/';
            if (preg_match_all($pattern, $src, $m, PREG_SET_ORDER)) {
                foreach ($m as $match) {
                    $variants[] = [
                        'name' => (string)$match[1],
                        'price' => (float)str_replace(',', '', (string)$match[2]),
                        'unit' => 'per unit'
                    ];
                }
            }
            $ok = $this->cats->setPrice('ac-cleaning', 0, 'per unit', $variants);
            return response()->json(['success' => $ok, 'count' => count($variants)]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function categoriesSeedFromUIBeauty()
    {
        try {
            $path = base_path('..\\..\\Haustap_Capstone-Haustap_Connecting\\Haustap_Capstone-Haustap_Connecting\\mobile_app\\HausTap\\app\\client-side\\data\\hair.ts');
            $src = @file_get_contents($path);
            if ($src === false) return response()->json(['success' => false, 'error' => 'file_not_found'], 404);
            $variants = [];
            $pattern = '/title:\s*"([^"]+)",[\s\S]*?price:\s*"([^\"]+)"/';
            if (preg_match_all($pattern, $src, $m, PREG_SET_ORDER)) {
                foreach ($m as $match) {
                    $title = (string)$match[1];
                    if (stripos($title, 'header') !== false) continue;
                    $priceText = (string)$match[2];
                    $n = null;
                    if (preg_match('/₱\s*([0-9,]+)/', $priceText, $pm)) { $n = (float)str_replace(',', '', $pm[1]); }
                    if ($n === null && preg_match('/Starts\s*with\s*₱\s*([0-9,]+)/i', $priceText, $pm2)) { $n = (float)str_replace(',', '', $pm2[1]); }
                    if ($n === null) { $n = 0; }
                    $variants[] = [
                        'name' => $title,
                        'price' => $n,
                        'unit' => 'per service'
                    ];
                }
            }
            $ok = $this->cats->setPrice('beauty', 0, 'per service', $variants);
            return response()->json(['success' => $ok, 'count' => count($variants)]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function categoriesAggregate()
    {
        $providers = $this->providers->list();
        $counts = [];
        foreach ($providers as $p) {
            $cats = [];
            $fs = new FirestoreClient();
            $doc = $fs->get('providers', (string)($p['id'] ?? ''));
            $fields = $doc['fields'] ?? [];
            $values = (array)($fields['service_categories']['arrayValue']['values'] ?? []);
            foreach ($values as $v) {
                $name = (string)($v['stringValue'] ?? '');
                if ($name === '') continue;
                $slug = trim(preg_replace('/[^a-z0-9]+/i', '-', strtolower($name)), '-');
                if ($slug === '') continue;
                $cats[] = $slug;
            }
            foreach ($cats as $slug) {
                $counts[$slug] = ($counts[$slug] ?? 0) + 1;
            }
        }
        $updated = [];
        foreach ($counts as $slug => $count) {
            if ($this->cats->setProviderCount($slug, $count)) $updated[] = $slug;
        }
        return response()->json(['success' => true, 'updated' => $updated, 'counts' => $counts]);
    }

    public function services()
    {
        return response()->json(['success' => true, 'services' => $this->services->list()]);
    }

    public function servicesCreate(Request $req)
    {
        $data = $req->all();
        $v = Validator::make($data, [
            'category_slug' => ['required','string','regex:/^[a-z0-9-]+$/'],
            'name' => ['required','string','max:120'],
            'price' => ['required','numeric','min:0'],
            'unit' => ['required','string','max:50'],
            'team_size' => ['nullable','integer','min:0'],
            'variants' => ['array'],
            'variants.*.name' => ['required_with:variants','string','max:120'],
            'variants.*.price' => ['nullable','numeric','min:0'],
            'variants.*.unit' => ['nullable','string','max:50'],
            'id' => ['nullable','string','regex:/^[A-Za-z0-9_-]+$/']
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        $id = $this->services->create($data, (string)($data['id'] ?? null));
        return response()->json(['success' => true, 'data' => ['id' => $id]]);
    }

    public function servicesSeed()
    {
        $preset = [
            [
                'category_slug' => 'cleaning',
                'name' => 'Home Cleaning - Studio',
                'price' => 500,
                'unit' => 'per job',
                'team_size' => 2,
                'variants' => [
                    ['name' => 'Basic', 'price' => 500, 'unit' => 'per job', 'team_size' => 2],
                    ['name' => 'Deep Clean', 'price' => 900, 'unit' => 'per job', 'team_size' => 3]
                ]
            ],
            [
                'category_slug' => 'ac-cleaning',
                'name' => 'AC Cleaning',
                'price' => 150,
                'unit' => 'per unit',
                'team_size' => 1,
                'variants' => [
                    ['name' => 'Basic', 'price' => 150, 'unit' => 'per unit', 'team_size' => 1],
                    ['name' => 'Deep Clean', 'price' => 350, 'unit' => 'per unit', 'team_size' => 1]
                ]
            ],
            [
                'category_slug' => 'beauty',
                'name' => 'Haircut',
                'price' => 20,
                'unit' => 'per service',
                'team_size' => 1,
                'variants' => [
                    ['name' => 'Standard', 'price' => 20, 'unit' => 'per service', 'team_size' => 1],
                    ['name' => 'Styling', 'price' => 35, 'unit' => 'per service', 'team_size' => 1]
                ]
            ],
            [
                'category_slug' => 'plumbing',
                'name' => 'Leak Repair',
                'price' => 75,
                'unit' => 'per job',
                'team_size' => 1,
                'variants' => []
            ]
        ];
        $created = [];
        foreach ($preset as $s) {
            $id = $this->services->create($s);
            if ($id) $created[] = $id;
        }
        return response()->json(['success' => true, 'created' => $created]);
    }

    public function servicesSeedFromUICleaning()
    {
        try {
            $path = base_path('..\\..\\Haustap_Capstone-Haustap_Connecting\\Haustap_Capstone-Haustap_Connecting\\mobile_app\\HausTap\\app\\client-side\\data\\cleaning.ts');
            $src = @file_get_contents($path);
            if ($src === false) return response()->json(['success' => false, 'error' => 'file_not_found'], 404);
            $created = [];
            $pattern = '/title:\s*"([^"]+)",[\s\S]*?price:\s*"₱([0-9,]+)\/unit"/';
            if (preg_match_all($pattern, $src, $m, PREG_SET_ORDER)) {
                foreach ($m as $match) {
                    $title = (string)$match[1];
                    $priceStr = (string)$match[2];
                    $price = (float)str_replace(',', '', $priceStr);
                    $id = $this->services->create([
                        'category_slug' => 'ac-cleaning',
                        'name' => $title,
                        'price' => $price,
                        'unit' => 'per unit',
                        'team_size' => 1,
                        'variants' => []
                    ]);
                    if ($id) $created[] = $id;
                }
            }
            return response()->json(['success' => true, 'created' => $created, 'count' => count($created)]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function servicesSeedFromUIBeauty()
    {
        try {
            $path = base_path('..\\..\\Haustap_Capstone-Haustap_Connecting\\Haustap_Capstone-Haustap_Connecting\\mobile_app\\HausTap\\app\\client-side\\data\\hair.ts');
            $src = @file_get_contents($path);
            if ($src === false) return response()->json(['success' => false, 'error' => 'file_not_found'], 404);
            $created = [];
            $pattern = '/title:\s*"([^"]+)",[\s\S]*?price:\s*"([^\"]+)"/';
            if (preg_match_all($pattern, $src, $m, PREG_SET_ORDER)) {
                foreach ($m as $match) {
                    $title = (string)$match[1];
                    $priceText = (string)$match[2];
                    if (stripos($title, 'header') !== false) continue;
                    $n = null;
                    if (preg_match('/₱\s*([0-9,]+)/', $priceText, $pm)) { $n = (float)str_replace(',', '', $pm[1]); }
                    if ($n === null && preg_match('/Starts\s*with\s*₱\s*([0-9,]+)/i', $priceText, $pm2)) { $n = (float)str_replace(',', '', $pm2[1]); }
                    if ($n === null) { $n = 0; }
                    $id = $this->services->create([
                        'category_slug' => 'beauty',
                        'name' => $title,
                        'price' => $n,
                        'unit' => 'per service',
                        'team_size' => 1,
                        'variants' => []
                    ]);
                    if ($id) $created[] = $id;
                }
            }
            return response()->json(['success' => true, 'created' => $created, 'count' => count($created)]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function providers()
    {
        $list = $this->providers->list();
        if (empty($list)) return response()->json(['success' => false], 200);
        return response()->json(['success' => true, 'providers' => $list]);
    }

    public function providersSearch(Request $req)
    {
        try {
            $fs = new FirestoreClient();
            $resp = $fs->list('providers', 200);
            $docs = is_array($resp['documents'] ?? null) ? $resp['documents'] : [];
            $want = trim(strtolower((string)$req->query('category', '')));
            $maxKm = (float)$req->query('maxKm', 0);
            $out = [];
            foreach ($docs as $d) {
                $f = (array)($d['fields'] ?? []);
                $namePath = (string)($d['name'] ?? '');
                $id = ($namePath && str_contains($namePath, '/documents/providers/'))
                    ? substr($namePath, strrpos($namePath, '/') + 1)
                    : null;
                $nm = (string)($f['name']['stringValue'] ?? ($id ?? ''));
                $rating = isset($f['rating']['doubleValue']) ? (float)$f['rating']['doubleValue']
                    : (isset($f['rating']['integerValue']) ? (float)$f['rating']['integerValue'] : 0);
                $distance = isset($f['distanceKm']['doubleValue']) ? (float)$f['distanceKm']['doubleValue']
                    : (isset($f['distanceKm']['integerValue']) ? (float)$f['distanceKm']['integerValue'] : 0);
                $vals = (array)($f['service_categories']['arrayValue']['values'] ?? []);
                $slugs = [];
                foreach ($vals as $v) {
                    $catName = (string)($v['stringValue'] ?? '');
                    if ($catName === '') continue;
                    $slug = trim(preg_replace('/[^a-z0-9]+/i', '-', strtolower($catName)), '-');
                    if ($slug !== '') $slugs[] = $slug;
                }
                if ($want !== '') {
                    if (!in_array($want, $slugs, true)) continue;
                }
                if ($maxKm > 0 && $distance > $maxKm) continue;
                $out[] = ['id' => $id, 'name' => $nm, 'rating' => $rating, 'distanceKm' => $distance, 'categories' => $slugs];
            }
            return response()->json(['success' => true, 'providers' => $out]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function bookingsList()
    {
        return response()->json(['success' => true, 'data' => $this->bookings->list()]);
    }

    public function bookingsCreate(Request $req)
    {
        $data = $req->all();
        $v = Validator::make($data, [
            'provider_id' => ['required','integer','min:1'],
            'service_name' => ['required','string','max:120'],
            'scheduled_date' => ['required','date'],
            'scheduled_time' => ['required','string','max:10'],
            'address' => ['nullable','string','max:300'],
            'price' => ['required','numeric','min:0'],
            'service_items' => ['array'],
            'service_items.*' => ['string','max:120'],
            'lat' => ['nullable','numeric'],
            'lng' => ['nullable','numeric']
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        $payload = $data;
        $user = $req->attributes->get('auth_user');
        if ($user) {
            $uid = preg_replace('/[^a-z0-9]+/i', '-', strtolower($user->email ?: $user->name));
            $uid = trim((string)$uid ?: 'user-' . md5((string)($user->email ?: $user->name)), '-');
            $role = strtolower((string)($user->role ?: 'client'));
            if ($role === 'client') {
                $payload['clientUid'] = $uid;
            } elseif ($role === 'provider') {
                $payload['providerUid'] = $uid;
            }
        }
        $id = $this->bookings->create($payload);
        return response()->json(['success' => true, 'data' => ['id' => $id]]);
    }

    public function bookingsGet(string $id)
    {
        $fs = new FirestoreClient();
        $doc = $fs->get('bookings', $id);
        $f = is_array($doc['fields'] ?? null) ? $doc['fields'] : [];
        $out = [
            'id' => $id,
            'provider_id' => (int)($f['provider_id']['integerValue'] ?? 0),
            'providerUid' => (string)($f['providerUid']['stringValue'] ?? ''),
            'clientUid' => (string)($f['clientUid']['stringValue'] ?? ''),
            'service_name' => (string)($f['service_name']['stringValue'] ?? ''),
            'scheduled_date' => (string)($f['scheduled_date']['stringValue'] ?? ''),
            'scheduled_time' => (string)($f['scheduled_time']['stringValue'] ?? ''),
            'address' => (string)($f['address']['stringValue'] ?? ''),
            'price' => isset($f['price']['doubleValue']) ? (float)$f['price']['doubleValue']
                : (isset($f['price']['integerValue']) ? (float)$f['price']['integerValue'] : 0),
            'status' => (string)($f['status']['stringValue'] ?? 'pending')
        ];
        return response()->json(['success' => true, 'data' => $out]);
    }

    public function bookingsStatus(string $id, Request $req)
    {
        $fs = new FirestoreClient();
        $doc = $fs->get('bookings', $id);
        $f = is_array($doc['fields'] ?? null) ? $doc['fields'] : [];
        $providerUid = (string)($f['providerUid']['stringValue'] ?? '');
        $user = $req->attributes->get('auth_user');
        $role = strtolower((string)($user->role ?? ''));
        $uid = preg_replace('/[^a-z0-9]+/i', '-', strtolower($user->email ?: $user->name));
        $uid = trim((string)$uid ?: 'user-' . md5((string)($user->email ?: $user->name)), '-');
        $status = (string)($req->input('status') ?? '');
        $v = Validator::make(['status'=>$status], ['status'=>['required','in:pending,ongoing,completed,cancelled']]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        if ($role === 'admin' || ($role === 'provider' && $providerUid !== '' && $providerUid === $uid)) {
            $ok = $this->bookings->setStatus($id, $status);
            return response()->json(['success' => $ok]);
        }
        return response()->json(['success' => false, 'message' => 'forbidden'], 403);
    }

    public function bookingsCancel(string $id, Request $req)
    {
        $fs = new FirestoreClient();
        $doc = $fs->get('bookings', $id);
        $f = is_array($doc['fields'] ?? null) ? $doc['fields'] : [];
        $clientUid = (string)($f['clientUid']['stringValue'] ?? '');
        $user = $req->attributes->get('auth_user');
        $role = strtolower((string)($user->role ?? ''));
        $uid = preg_replace('/[^a-z0-9]+/i', '-', strtolower($user->email ?: $user->name));
        $uid = trim((string)$uid ?: 'user-' . md5((string)($user->email ?: $user->name)), '-');
        $reason = (string)($req->input('reason') ?? '');
        $v = Validator::make(['reason'=>$reason], ['reason'=>['required','string','max:300']]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        if ($role === 'admin' || ($role === 'client' && $clientUid !== '' && $clientUid === $uid)) {
            $ok = $this->bookings->cancel($id, $reason);
            return response()->json(['success' => $ok]);
        }
        return response()->json(['success' => false, 'message' => 'forbidden'], 403);
    }

    public function bookingsRate(string $id, Request $req)
    {
        $fs = new FirestoreClient();
        $doc = $fs->get('bookings', $id);
        $f = is_array($doc['fields'] ?? null) ? $doc['fields'] : [];
        $clientUid = (string)($f['clientUid']['stringValue'] ?? '');
        $user = $req->attributes->get('auth_user');
        $role = strtolower((string)($user->role ?? ''));
        $uid = preg_replace('/[^a-z0-9]+/i', '-', strtolower($user->email ?: $user->name));
        $uid = trim((string)$uid ?: 'user-' . md5((string)($user->email ?: $user->name)), '-');
        $rating = (float)($req->input('rating') ?? 0);
        $v = Validator::make(['rating'=>$rating], ['rating'=>['required','numeric','min:1','max:5']]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        if ($role === 'admin' || ($role === 'client' && $clientUid !== '' && $clientUid === $uid)) {
            $ok = $this->bookings->rate($id, $rating);
            return response()->json(['success' => $ok]);
        }
        return response()->json(['success' => false, 'message' => 'forbidden'], 403);
    }

    public function bookingsReturn(string $id, Request $req)
    {
        try {
            $issues = (array)($req->input('issues') ?? []);
            $notes = (string)($req->input('notes') ?? '');
            $fs = new FirestoreClient();
            $fields = [
                'booking_id' => ['stringValue' => (string)$id],
                'issues' => ['arrayValue' => ['values' => array_map(fn($s) => ['stringValue' => (string)$s], $issues)]],
                'notes' => ['stringValue' => $notes],
                'ts' => ['integerValue' => (int)round(microtime(true) * 1000)],
            ];
            $doc = $fs->create('returns', $fields);
            $namePath = is_array($doc) ? (string)($doc['name'] ?? '') : '';
            $retId = ($namePath && str_contains($namePath, '/documents/returns/'))
                ? substr($namePath, strrpos($namePath, '/') + 1)
                : null;
            if ($retId) {
                $fs->patch('bookings', $id, ['last_return_id' => ['stringValue' => $retId]]);
            }
            return response()->json(['success' => true, 'data' => ['id' => $retId]]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function bookingsReturns()
    {
        try {
            $fs = new FirestoreClient();
            $resp = $fs->list('returns', 100);
            $docs = is_array($resp['documents'] ?? null) ? $resp['documents'] : [];
            $list = [];
            foreach ($docs as $d) {
                $fields = (array)($d['fields'] ?? []);
                $bid = (string)($fields['booking_id']['stringValue'] ?? '');
                $issuesVals = (array)($fields['issues']['arrayValue']['values'] ?? []);
                $issues = array_map(fn($v) => (string)($v['stringValue'] ?? ''), $issuesVals);
                $rec = [
                    'booking_id' => $bid,
                    'issues' => $issues,
                    'notes' => (string)($fields['notes']['stringValue'] ?? ''),
                    'ts' => (int)($fields['ts']['integerValue'] ?? 0),
                ];
                if ($bid !== '') {
                    $bdoc = $fs->get('bookings', $bid);
                    $bf = (array)($bdoc['fields'] ?? []);
                    $rec['booking'] = [
                        'id' => $bid,
                        'service_name' => (string)($bf['service_name']['stringValue'] ?? ''),
                        'scheduled_date' => (string)($bf['scheduled_date']['stringValue'] ?? ''),
                        'scheduled_time' => (string)($bf['scheduled_time']['stringValue'] ?? ''),
                        'address' => (string)($bf['address']['stringValue'] ?? ''),
                        'price' => isset($bf['price']['doubleValue']) ? (float)$bf['price']['doubleValue']
                            : (isset($bf['price']['integerValue']) ? (float)$bf['price']['integerValue'] : 0),
                    ];
                }
                $list[] = $rec;
            }
            return response()->json(['success' => true, 'data' => $list]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function vouchers(Request $req)
    {
        try {
            $email = (string)$req->query('email', '');
            $uid = trim(preg_replace('/[^a-z0-9]+/i', '-', strtolower($email)), '-');
            $list = $this->bookings->list();
            $completed = 0;
            foreach ($list as $b) {
                if (($b['clientUid'] ?? '') === $uid) {
                    $status = strtolower((string)($b['status'] ?? ''));
                    if ($status === 'completed' || $status === 'done') $completed++;
                }
            }
            $welcomeReward = 50;
            $loyaltyReward = 50;
            $loyaltyRequired = 10;
            $referralEarned = 0;
            $referralReward = 10;
            $data = [
                'welcome' => ['eligible' => ($completed === 0), 'reward_amount' => $welcomeReward],
                'loyalty' => ['completed' => $completed, 'required' => $loyaltyRequired, 'reward_amount' => $loyaltyReward],
                'referral' => ['earned' => $referralEarned, 'reward_amount' => $referralReward]
            ];
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function bookingsTestCreate()
    {
        $payload = [
            'provider_id' => 1,
            'clientUid' => 'dev-test-client',
            'service_name' => 'Dev Test Service',
            'scheduled_date' => date('Y-m-d'),
            'scheduled_time' => '10:00',
            'address' => 'Test Address',
            'price' => 99.99,
            'status' => 'pending'
        ];
        $id = $this->bookings->create($payload);
        return response()->json(['success' => true, 'data' => ['id' => $id]]);
    }

    public function applicants()
    {
        return response()->json(['success' => true, 'applicants' => $this->applicants->list()]);
    }

    public function applicantsCreate(Request $req)
    {
        $data = $req->all();
        $v = Validator::make($data, [
            'name' => ['required','string','max:120'],
            'email' => ['required','email'],
            'phone' => ['required','string','max:20'],
            'experience' => ['nullable','string','max:500'],
            'categories' => ['array'],
            'categories.*' => ['string','max:60'],
            'status' => ['nullable','in:pending,approved,rejected']
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        $id = $this->applicants->create($data);
        return response()->json(['success' => true, 'data' => ['id' => $id]]);
    }

    public function applicantsTestCreate()
    {
        $payload = [
            'name' => 'Dev Applicant',
            'email' => 'applicant@example.com',
            'phone' => '+10000000000',
            'experience' => '2 years cleaning services',
            'categories' => ['cleaning', 'ac-maintenance'],
            'status' => 'pending'
        ];
        $id = $this->applicants->create($payload);
        return response()->json(['success' => true, 'data' => ['id' => $id]]);
    }

    public function users()
    {
        return response()->json(['success' => true, 'users' => $this->users->list()]);
    }

    public function usersCreate(Request $req)
    {
        $data = $req->all();
        $v = Validator::make($data, [
            'id' => ['nullable','string','regex:/^[A-Za-z0-9_-]+$/'],
            'email' => ['required','email'],
            'name' => ['required','string','max:120'],
            'roles' => ['array'],
            'roles.*' => ['string','in:admin,client,provider'],
            'role' => ['nullable','in:admin,client,provider']
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        $id = $this->users->create($data, (string)($data['id'] ?? null));
        return response()->json(['success' => true, 'data' => ['id' => $id]]);
    }

    public function usersTestCreate()
    {
        $payload = [
            'id' => 'dev-admin',
            'email' => 'admin@haustap.local',
            'name' => 'Admin',
            'roles' => ['admin']
        ];
        $id = $this->users->create($payload, (string)$payload['id']);
        return response()->json(['success' => true, 'data' => ['id' => $id]]);
    }

    public function usersSeedBasic()
    {
        $created = [];
        $adminId = $this->users->create([
            'email' => 'admin@haustap.local',
            'name' => 'Admin',
            'roles' => ['admin'],
            'role' => 'admin'
        ], 'dev-admin');
        if ($adminId) $created[] = $adminId;
        $clientId = $this->users->create([
            'email' => 'client@haustap.local',
            'name' => 'Client',
            'roles' => ['client'],
            'role' => 'client'
        ], 'dev-client');
        if ($clientId) $created[] = $clientId;
        $providerId = $this->users->create([
            'email' => 'provider@haustap.local',
            'name' => 'Provider',
            'roles' => ['provider'],
            'role' => 'provider'
        ], 'dev-provider');
        if ($providerId) $created[] = $providerId;
        return response()->json(['success' => true, 'created' => $created]);
    }

    public function applicantsStatus(string $id, Request $req)
    {
        $status = (string)($req->input('status') ?? 'pending');
        $v = Validator::make(['status'=>$status], ['status'=>['required','in:pending,approved,rejected']]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()],422);
        $ok = $this->applicants->setStatus($id, $status);
        return response()->json(['success' => $ok]);
    }

    public function applicantsApprove(string $id)
    {
        $ok = $this->applicants->setStatus($id, 'approved');
        return response()->json(['success' => $ok]);
    }

    public function applicantsReject(string $id)
    {
        $ok = $this->applicants->setStatus($id, 'rejected');
        return response()->json(['success' => $ok]);
    }

    public function applicantsPromote(string $id)
    {
        try {
            $a = $this->applicants->get($id);
            if (($a['status'] ?? '') === 'rejected') {
                return response()->json(['success' => false, 'error' => 'rejected_applicant'], 400);
            }
            $name = (string)($a['name'] ?? '');
            $email = (string)($a['email'] ?? '');
            $cats = (array)($a['categories'] ?? []);
            $provId = $this->providers->create([
                'name' => $name,
                'rating' => 0,
                'distanceKm' => 0,
                'service_categories' => $cats
            ]);
            $userId = preg_replace('/[^a-z0-9]+/i', '-', strtolower($email ?: $name));
            $userId = trim((string)$userId ?: 'provider-' . ($provId ?? ''), '-');
            $uid = $this->users->create([
                'email' => $email ?: ($userId . '@provider.local'),
                'name' => $name ?: $userId,
                'roles' => ['provider']
            ], $userId);
            $this->applicants->setStatus($id, 'approved');
            return response()->json(['success' => true, 'data' => ['provider_id' => $provId, 'user_id' => $uid]]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function migrateProviders()
    {
        try {
            $rows = \DB::table('providers')->select('id', 'name', 'service_categories')->get();
            $fs = new FirestoreClient();
            $unique = [];
            $created = 0;
            foreach ($rows as $r) {
                $catsRaw = (string)($r->service_categories ?? '[]');
                $cats = json_decode($catsRaw, true);
                if (!is_array($cats)) $cats = [];
                $values = [];
                foreach ($cats as $c) {
                    $n = is_string($c) ? $c : (is_array($c) ? ($c['name'] ?? '') : '');
                    $n = trim((string)$n);
                    if ($n === '') continue;
                    $values[] = ['stringValue' => $n];
                    $slug = trim(preg_replace('/[^a-z0-9]+/i', '-', strtolower($n)), '-');
                    if ($slug !== '' && !isset($unique[$slug])) { $unique[$slug] = $n; }
                }
                $fields = [
                    'name' => ['stringValue' => (string)($r->name ?? '')],
                    'service_categories' => ['arrayValue' => ['values' => $values]]
                ];
                $fs->create('providers', $fields, (string)$r->id);
                $created++;
            }
            foreach ($unique as $slug => $name) {
                $fs->create('categories', [
                    'slug' => ['stringValue' => $slug],
                    'name' => ['stringValue' => $name]
                ], $slug);
            }
            return response()->json(['success' => true, 'providers_exported' => $created, 'categories_exported' => count($unique)]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => 'migration_failed'], 500);
        }
    }
}
