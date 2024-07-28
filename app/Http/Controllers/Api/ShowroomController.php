<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Showroom;
use App\Http\Resources\ShowroomResource;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ShowroomController extends Controller
{
    public function index()
    {
        $showrooms = Showroom::all();
        return ShowroomResource::collection($showrooms);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $showroom = Showroom::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Showroom created successfully',
            'showroom' => new ShowroomResource($showroom),
        ]);
    }

    public function show($id)
    {
        $showroom = Showroom::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => '',
            'showroom' => new ShowroomResource($showroom),
        ]);
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $showroom = Showroom::findOrFail($id);
        $showroom->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Showroom updated successfully',
            'showroom' => new ShowroomResource($showroom),
        ]);
    }

    public function destroy($id)
    {
        $showroom = Showroom::findOrFail($id);
        $showroom->delete();

        return response()->json(['message' => 'Showroom deleted successfully']);
    }


    public function restore($id)
    {
        $showroom = Showroom::withTrashed()->findOrFail($id);
        $showroom->restore();
        return response()->json([
            'status' => true,
            'message' => 'Showroom restored successfully',
        ]);
    }
}
