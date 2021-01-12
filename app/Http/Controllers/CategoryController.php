<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductCategory;
use Exception;

class CategoryController extends Controller
{
	/**
     * Function to handle incomming request to show categories
     */
	public function index()
	{
		return Category::with('children')->paginate();
	}

	/**
     * Function to handle incomming request to create categories
     */
    public function store(Request $request)
    {
    	$validation_rules = [
            "name" => "required",
        ];

        if ($request->has('parent_id')) {
            $validation_rules['parent_id'] = "integer|exists:categories,id";
        }

        // validate request
        $data = [];
        try {
            $data = $this->validate($request, $validation_rules);
        } catch(Exception $e) {
            return response(["success" => false, "errors" => $e->errors()], 400);
        }

        // create category
        $product = Category::create($data);
        return $product->with('children')->find($product->id);
    }

    /**
     * Function to handle incomming request to edit product
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validation_rules = [];
        if ($request->has('name')) {
            $validation_rules['name'] = 'required';
        }

        if ($request->has('parent_id')) {
            $validation_rules['parent_id'] = "integer|exists:categories,id";
        }

        // validate request
        $data = [];
        try {
            $data = $this->validate($request, $validation_rules);
        } catch(Exception $e) {
            return response(["success" => false, "errors" => $e->errors()], 400);
        }

        $category->update($data);

        return $category->with('children')->find($category->id);
    }

    /**
     * Function to handle delete request
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // remove current category as parent from other category
        $category->children->map(function ($child_category) {
            $child_category->parent_id = null;
            $child_category->save();
        });

        // remove product_category
        ProductCategory::where('category_id', $category->id)->delete();

        // delete current category
        $category->delete();
        return ['success' => true, 'message' => 'Product deleted'];
    }

    /**
     * Function to show single category
     */
    public function show($id)
    {
        return Category::with('children')->findOrFail($id);
    }
}
