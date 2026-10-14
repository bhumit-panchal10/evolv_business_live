<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthkeyWhatsAppService
{
    protected $authkey;
    protected $baseUrl;

    public function __construct()
    {
        $this->authkey = config('services.authkey.key');
        $this->baseUrl = config('services.authkey.url');
    }

    /**
     * Send Text Template
     */
    public function sendText($mobile, $wid)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->authkey,
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . 'requestjson.php', [
            "country_code" => "91",
            "mobile" => $mobile,
            "wid" => $wid,
            "type" => "text",
        ]);

        return $response->json();
    }
}
