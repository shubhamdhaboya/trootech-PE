<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{
    use ValidatesRequests;

    /**
     * Function to handle incomming request to show products
     */
    public function index()
    {
        $products = Product::with('categories')->paginate();
        return response($products);
    }

    /**
     * Function to handle incomming request to create product
     */
    public function store(Request $request)
    {
        $validation_rules = [
            "name" => "required",
            "price" => "required|numeric"
        ];
        if ($request->has('categories')) {
            $validation_rules['categories'] = "array|exists:categories,id";
        }

        // validate request
        $data = [];
        try {
            $data = $this->validate($request, $validation_rules);
        } catch(Exception $e) {
            return response(["success" => false, "errors" => $e->errors()], 400);
        }

        // create product
        $product = Product::create($data);
        if ($request->has('categories')) {
            $product->addCategories($data['categories']);
        }

        return $product->with('categories')->find($product->id);
    }

    /**
     * Function to handle incomming request to edit product
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validation_rules = [];
        if ($request->has('name')) {
            $validation_rules['name'] = 'required';
        }

        if ($request->has('price')) {
            $validation_rules['price'] = 'required|numeric';
        }

        if ($request->has('add_categories')) {
            $validation_rules['add_categories'] = "array|exists:categories,id";
        }

        if ($request->has('remove_categories')) {
            $validation_rules['remove_categories'] = "array|exists:categories,id";
        }

        // validate request
        $data = [];
        try {
            $data = $this->validate($request, $validation_rules);
        } catch(Exception $e) {
            return response(["success" => false, "errors" => $e->errors()], 400);
        }

        $product->update($data);

        if ($request->has('add_categories')) {
            $product->addCategories($data['add_categories']);
        }

        if ($request->has('remove_categories')) {
            $product->removeCategories($data['remove_categories']);
        }

        return $product->with('categories')->find($product->id);
    }

    /**
     * Function to handle delete request
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->categories()->detach();
        $product->delete();
        return ['success' => true, 'message' => 'Product deleted'];
    }

    /**
     * Function to show single product
     */
    public function show($id)
    {
        $product = Product::with('categories')->findOrFail($id);
    }
}
