<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    /**
     * Retrieve top Theater data.
     */
    public function topTheaters(Request $request): JsonResponse
    {
        \Log::info('top Theaters');

        \Log::info($request);
        try {
            $validated = $request->validate([
                'fromDate' => 'required|date_format:Y-m-d H:i:s',
                'toDate' => 'required|date_format:Y-m-d H:i:s',
                'queryLimit' => 'required|integer',
            ]);
    
            \Log::info($validated);

            $apiService = new ApiService();
            
            $topTheaters = $apiService->getTopTheaters($validated['fromDate'], $validated['toDate'], $validated['queryLimit']);
            
            \Log::info($topTheaters);
            return response()->json(['data' => $topTheaters], 200);     
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);  
        } catch(\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'An unexpected error occurred.', 'error' => $e->getMessage()], 500);     
        }
        
    }
}