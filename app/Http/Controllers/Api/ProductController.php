<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //get all products
    public function index()
    {
        return ProductResource::collection(Product::where('id_category', '<>', 4)->inRandomOrder()->get());
        //علي حسب ال body kit category كام
    }

    

    //get products for each category
    public function getProductsByCategory($id_category)
    {
        return ProductResource::collection(Product::where('id_category', $id_category)->get());
    }

    
    //get products for each showroom
    public function getProductsByShowroom($id_showroom)
    {
        return ProductResource::collection(Product::where('id_showroom', $id_showroom)->get());
    }


    //create a new product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_category' => 'required|exists:categories,id',
            'id_showroom' => 'required|integer',
            'name' => 'required|string|max:255',
            'images' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'speed' => 'required|integer',
            'type' => 'required|string',
            'cylinder' => 'required|string',
            'color' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'offer' => 'nullable|numeric',
            'stock' => 'required|numeric',
        ], [
            'id_category.required' => 'Category is required',
            'id_showroom.required' => 'Showroom is required',
            'name.required' => 'Name is required',
            'images.image' => 'The images must be an image file',
            'images.max' => 'The images must not be greater than 2048 kilobytes',
            'price.required' => 'Price is required',
            'speed.required' => 'Speed is required',
            'type.required' => 'Type is required',
            'cylinder.required' => 'Cylinder is required',
            'color.required' => 'Color is required',
            'brand.required' => 'Brand is required',
            'model.required' => 'Model is required',
            'stock.required' => 'Stock is required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessage = [];

            foreach ([
                'id_category', 'id_showroom', 'name', 'images', 'price', 'speed',
                'type', 'cylinder', 'color', 'brand', 'model', 'stock'

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

        // $product = new Product();
        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('products', 'public');
            // $product->images = $imagePath;
        }

       $product= Product::create([
            'id_category' => $request->id_category,
            'id_showroom' => $request->id_showroom,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'speed' => $request->speed,
            'type' => $request->type,
            'cylinder' => $request->cylinder,
            'color' => $request->color,
            'brand' => $request->brand,
            'model' => $request->model,
            'offer' => $request->offer,
            'images' => $imagePath

        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'product' => new ProductResource($product),
        ]);
    }

   //get a single product
    public function show($product_id)
    {
        $product = Product::findOrFail($product_id);
        return response()->json([
            'status' => true,
            'message' => '',
            'product' => new ProductResource($product),
        ]);
    }


    
    // public function updateProduct(Request $request, $id)
    // {
    //     // Find the product by ID
    //     $product = Product::findOrFail($id);

    //     // Handle file upload
    //     if ($request->hasFile('images')) {
    //         $imagePath = $request->file('images')->store('products', 'public');
    //         $product->images = $imagePath;
    //     }

    //     // Update product attributes
    //     $product->id_category = $request->id_category;
    //     $product->id_showroom = $request->id_showroom;
    //     $product->name = $request->name;
    //     $product->description = $request->description;
    //     $product->price = $request->price;
    //     $product->speed = $request->speed;
    //     $product->type = $request->type;
    //     $product->cylinder = $request->cylinder;
    //     $product->color = $request->color;
    //     $product->brand = $request->brand;
    //     $product->model = $request->model;
    //     $product->offer = $request->offer;

    //     // Save the updated product to the database
    //     $product->save();

    //     // Return the updated product
    //     return new ProductResource($product);
    // }


    public function update(Request $request, $id )
    {


        $validator = Validator::make($request->all(), [
            'id_category' => 'required|exists:categories,id',
            'id_showroom' => 'required|integer',
            'name' => 'required|string|max:255',
            'images' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'speed' => 'required|integer',
            'type' => 'required|string',
            'cylinder' => 'required|string',
            'color' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'offer' => 'nullable|numeric',
             'stock' => 'required|numeric',
            ],
            [
                'id_category.required' => 'Category is required',
                'id_showroom.required' => 'Showroom is required',
                'name.required' => 'Name is required',
                'images.image' => 'The images must be an image file',
                'images.max' => 'The images must not be greater than 2048 kilobytes',
                'price.required' => 'Price is required',
                'speed.required' => 'Speed is required',
                'type.required' => 'Type is required',
                'cylinder.required' => 'Cylinder is required',
                'color.required' => 'Color is required',
                'brand.required' => 'Brand is required',
                'model.required' => 'Model is required',
                'stock.required' => 'Stock is required',
            ] );

            if ($validator->fails()) {
                $errors = $validator->errors();
                $errorMessage = [];
    
                foreach ([
                    'id_category', 'id_showroom', 'name', 'images', 'price', 'speed',
                    'type', 'cylinder', 'color', 'brand', 'model',
                    'stock'
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




        $product = Product::findOrFail($id);

        $product->id_category = $request->id_category;
        $product->id_showroom = $request->id_showroom;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->speed = $request->speed;
        $product->type = $request->type;
        $product->cylinder = $request->cylinder;
        $product->color = $request->color;
        $product->brand = $request->brand;
        $product->model = $request->model;
        $product->offer = $request->offer;
        $product->stock = $request->stock;

        if ($request->hasFile('images')) {
            // Delete the old image from storage
            if ($product->images) {
                Storage::delete('public/' . $product->images);
            }
            $imagePath = $request->file('images')->store('products', 'public');
            $product->images = $imagePath;
        }

        // Save the updated post to the database
        $product->save();
        


        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'product' => new ProductResource($product),
        ]);
    }




    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully!',
        ], 200);

        
    }



    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return response()->json([
            'status' => true,
            'message' => 'Product restored successfully!',
        ], 200);
    }
}
