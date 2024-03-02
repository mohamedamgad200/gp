<?php

namespace Modules\Statistics\App\Http\Controllers;

use App\Models\Patient;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function statistics() 
    {
        $numberOfUsers = Patient::count();
        $numberOfUsersHasFillForm = Patient::where('result', '!=', NULL)->count();

        $numberOfUsersHasDisease = Patient::where('result', '=', '1')->count();
        $numberOfUsersHasNotDisease = $numberOfUsersHasFillForm - $numberOfUsersHasDisease;
        
        $data = [
            'All Patient' => $numberOfUsers,
            'All Patient Has Fill Form' => $numberOfUsersHasFillForm,
            'Patient With Depression' => $numberOfUsersHasDisease,
            'Patient Without Depression' => $numberOfUsersHasNotDisease
        ];
        return response()->json([
            'message' => 'some statistics for doctor about patients',
            'data' => $data,
            'status' => true,
            'code' => 200
        ], 200);
    }
}
