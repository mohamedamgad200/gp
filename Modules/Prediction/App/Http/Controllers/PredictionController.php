<?php

namespace Modules\Prediction\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Modules\Prediction\App\Http\Requests\PredictionRequest;

class PredictionController extends Controller
{
    public function predict(PredictionRequest $request)
    {
        $data = $request->validated();
        $response = Http::post('https://e979-197-37-207-143.ngrok-free.app/api/submit', $data);
        if ($response->successful()) {
            $responseData = json_decode($response->body(), true);
            $result = $responseData['result'] ?? null;
            return response()->json(['result' => $result]);
        } else {
            return response()->json(['error' => 'Failed to fetch data from Flask API'], 500);
        }
    }
}
