<?php
namespace App\Services\Firebase;

use Google\Auth\ApplicationDefaultCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FirestoreClient
{
    private string $projectId;
    private Client $http;
    private ?string $accessToken = null;

    public function __construct()
    {
        $this->projectId = (string) (env('FIREBASE_PROJECT_ID') ?? '');
        $this->http = new Client(['timeout' => 15]);
    }

    private function token(): string
    {
        if ($this->accessToken) return $this->accessToken;
        $scopes = ['https://www.googleapis.com/auth/datastore'];
        $creds = ApplicationDefaultCredentials::getCredentials($scopes);
        $info = $creds->fetchAuthToken();
        $this->accessToken = is_array($info) ? (string) ($info['access_token'] ?? '') : '';
        return $this->accessToken;
    }

    private function base(): string
    {
        return 'https://firestore.googleapis.com/v1/projects/' . $this->projectId . '/databases/(default)/documents';
    }

    public function list(string $collection, int $pageSize = 100): array
    {
        if ($this->projectId === '') return [];
        $url = $this->base() . '/' . $collection . '?pageSize=' . $pageSize;
        try {
            $res = $this->http->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token(),
                    'Accept' => 'application/json'
                ]
            ]);
            $json = json_decode((string) $res->getBody(), true);
            return is_array($json) ? $json : [];
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function get(string $collection, string $id): array
    {
        if ($this->projectId === '') return [];
        $url = $this->base() . '/' . $collection . '/' . rawurlencode($id);
        try {
            $res = $this->http->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token(),
                    'Accept' => 'application/json'
                ]
            ]);
            $json = json_decode((string) $res->getBody(), true);
            return is_array($json) ? $json : [];
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function create(string $collection, array $fields, ?string $documentId = null): array
    {
        if ($this->projectId === '') return [];
        $url = $this->base() . '/' . $collection;
        if ($documentId) $url .= '?documentId=' . rawurlencode($documentId);
        $body = json_encode(['fields' => $fields], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        try {
            $res = $this->http->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token(),
                    'Content-Type' => 'application/json'
                ],
                'body' => $body
            ]);
            $json = json_decode((string) $res->getBody(), true);
            return is_array($json) ? $json : [];
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function patch(string $collection, string $id, array $fields): bool
    {
        if ($this->projectId === '') return false;
        $url = $this->base() . '/' . $collection . '/' . rawurlencode($id);
        $body = json_encode(['fields' => $fields], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        try {
            $this->http->patch($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token(),
                    'Content-Type' => 'application/json'
                ],
                'body' => $body
            ]);
            return true;
        } catch (GuzzleException $e) {
            return false;
        }
    }
}

