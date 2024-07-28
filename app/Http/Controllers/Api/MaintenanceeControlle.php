<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenancee;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MaintenanceeResource;



class MaintenanceeControlle extends Controller
{
    //
    public function index()
    {
        $maintenancee = Maintenancee::all();
        return response()->json($maintenancee);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $maintenancee = Maintenancee::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Maintenance order request successfully',
            'maintenancee' => $maintenancee,
        ]);
    }


    public function MaintenanceOrderUser($userId)
    {
        $maintenancee = Maintenancee::where('user_id', $userId)->get();
        return response()->json($maintenancee);
    }

    
    public function destroy($id)
    {
        $maintenancee = Maintenancee::findOrFail($id);
        $maintenancee->delete();
        return response()->json([
            'status' => true,
            'message' => 'Maintenance order deleted successfully',
        ]);
    }
}
