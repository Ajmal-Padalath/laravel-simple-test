<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Response;

class ProductController extends Controller
{
    public function dashboard(Request $request) {
        $products = Products::paginate(5);
        return view('dashboard', compact('products'));
    }

    public function addProduct(Request $request) {
        $name = $request->name;
        $description = $request->description;
        $price = $request->price;
        if (!$name || !$description || !$price) {
            return Response::json(['status' => 2, 'message'=> 'Please fill all fields'], 200);
        }
        $product = new Products;
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->save();
        $status = 1;
        $message = 'New product added successfully';
        return Response::json(['status' => $status, 'message'=> $message], 200);
    }

    public function fetchProductData(Request $request) {
        $productData = Products::find($request->ProductId);
        return view('edit-product', compact('productData'));
    }

    public function updateProduct(Request $request) {
        $name = $request->name;
        $description = $request->description;
        $price = $request->price;
        $productId = $request->productId;

        if (!empty($productId)) {
            if (!$name || !$description || !$price) {
                return Response::json(['status' => 2, 'message'=> 'Please fill all fields'], 200);
            }
            $product = Products::find($productId);
            $product->name = $name;
            $product->description = $description;
            $product->price = $price;
            $product->save();
            $status = 2;
            $message = 'Product Updated successfully';
            return Response::json(['status' => $status, 'message'=> $message], 200); 
        }
    }

    public function deleteProduct(Request $request) {
        Products::where('id', $request->productId)->delete();
        $status = 3;
        $message = 'Product deleted successfully';
        return Response::json(['status' => $status, 'message'=> $message], 200);
    }
}
