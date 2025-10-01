<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class PetstoreApiService
{
    protected string $baseUrl = 'https://petstore.swagger.io/v2/pet';

    public function getPet(int $petId): array {

        $response = Http::get("{$this->baseUrl}/{$petId}");

        return $this->handleResponse($response);
    }

    public function addPet(array $petData): array {

        $response = Http::post($this->baseUrl, $petData);

        return $this->handleResponse($response);
    }

    public function deletePet(int $petId): bool {
        $response = Http::delete("{$this->baseUrl}/{$petId}");

        if ($response->successful()) {
            return true;
        }

        throw new RequestException($response);

    }

    public function updatePet(array $petData): array
    {
        $response = Http::withOptions(['verify' => false])->put($this->baseUrl, $petData);
    
        if ($response->successful()) {
            return $response->json();
        }
    
        throw new RequestException($response);
    }
    

    protected function handleResponse($response): array {

        if ($response->successful()) {
            return $response->json();
        }

        throw new RequestException($response);
    }

}