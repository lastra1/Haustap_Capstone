<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationPin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'latitude',
        'longitude',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'type',
        'is_active',
        'is_public',
        'metadata'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'metadata' => 'array'
    ];

    protected $with = ['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeNearby($query, $latitude, $longitude, $radiusKm = 10)
    {
        // Using Haversine formula for distance calculation
        $lat = deg2rad($latitude);
        $lng = deg2rad($longitude);
        $radius = $radiusKm * 1000; // Convert km to meters

        return $query->whereRaw("
            (6371000 * acos(
                cos(?) * cos(radians(latitude)) * 
                cos(radians(longitude) - ?) + 
                sin(?) * sin(radians(latitude))
            )) <= ?
        ", [$lat, $lng, $lat, $radius]);
    }

    public function scopeWithinBounds($query, $northEastLat, $northEastLng, $southWestLat, $southWestLng)
    {
        return $query->whereBetween('latitude', [$southWestLat, $northEastLat])
                    ->whereBetween('longitude', [$southWestLng, $northEastLng]);
    }

    public function getDistanceAttribute($value)
    {
        return $value;
    }

    public function calculateDistance($latitude, $longitude)
    {
        $earthRadius = 6371; // km

        $latDelta = deg2rad($latitude - $this->latitude);
        $lngDelta = deg2rad($longitude - $this->longitude);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($this->latitude)) * cos(deg2rad($latitude)) *
             sin($lngDelta / 2) * sin($lngDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function getCoordinatesAttribute()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }

    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->country,
            $this->postal_code
        ]);

        return implode(', ', $parts);
    }
}