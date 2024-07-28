<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }
    
    public function getBodyKit()
    {
        return CategoryResource::collection(
            Category::where('name', 'like', '%body kit%')
                ->orWhere('name', 'like', '%Body Kit%')
                ->get()
        );
        
        
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'pd_name' => 'required|string|max:255',
            'images' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'speed' => 'required|integer',
            'type' => 'required|string|max:255',
        ], [
            'name.required' => 'Name is required',
            'pd_name.required' => 'Product name is required',
            'images.image' => 'The images must be an image file',
            'images.max' => 'The images must not be greater than 2048 kilobytes',
            'price.required' => 'Price is required',
            'speed.required' => 'Speed is required',
            'type.required' => 'Type is required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessage = [];

            foreach ([
                'name', 'pd_name', 'images', 'price', 'speed', 'type'
            ] as $field) {
                if ($errors->has($field)) {
                    $errorMessage[] = $errors->first($field);
                }
            }

            return response()->json([
                'status' => false,
                'message' => implode(' ', $errorMessage),
            ], 422);
        }

        $imagePath = null;
        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('categories', 'public');
        }

        $category = Category::create([
            'name' => $request->name,
            'pd_name' => $request->pd_name,
            'description' => $request->description,
            'price' => $request->price,
            'speed' => $request->speed,
            'type' => $request->type,
            'images' => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'category' => new CategoryResource($category),
        ]);
    }


    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => '',
            'category' => new CategoryResource($category),
        ]);
    }

    public function update(Request $request, $id)
    {

        //  dd($request->all(),$id);

       

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'pd_name' => 'required|string|max:255',
            'images' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'speed' => 'required|integer',
            'type' => 'required|string|max:255',
        ], [
            'name.required' => 'Name is required',
            'pd_name.required' => 'Product name is required',
            'images.image' => 'The images must be an image file',
            'images.max' => 'The images must not be greater than 2048 kilobytes',
            'price.required' => 'Price is required',
            'speed.required' => 'Speed is required',
            'type.required' => 'Type is required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessage = [];

            foreach (['name', 'pd_name', 'images', 'price', 'speed', 'type'] as $field) {
                if ($errors->has($field)) {
                    $errorMessage[] = $errors->first($field);
                }
            }

            return response()->json([
                'status' => false,
                'message' => implode(' ', $errorMessage),
            ], 422);
        }

        $categoryname = $request->input('name');

        // Check if the category name already exists for a different category
        $existingCategory = Category::where('name', $categoryname)
            ->where('id', '<>', $id)
            ->first();

        if ($existingCategory) {
            return response()->json([
                'status' => false,
                'message' => 'Category name already exists',
            ], 400);
        }

        $category = Category::findOrFail($id);

        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('categories', 'public');
            $category->images = $imagePath;
        }

        $category->name = $request->name;
        $category->pd_name = $request->pd_name;
        $category->description = $request->description;
        $category->price = $request->price;
        $category->speed = $request->speed;
        $category->type = $request->type;

        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => new CategoryResource($category)
        ], 200);
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'category deleted successfully',
        ]);
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return response()->json([
            'status' => true,
            'message' => 'Category restored successfully!',
        ], 200);
    }
}
