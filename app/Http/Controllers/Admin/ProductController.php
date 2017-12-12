<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Exceptions\CustomException;
use App\Product;
use App\ProductServiceImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected function products(Request $request) {
		$products = Product::with('category')->orderBy('created_at')->get();
		$categories = Category::where('status', 1)->get();

		return view('admin.index', [
			'title' => 'Product',
			'nav' => 'product',
			'admin_page' => 'product.all_products',
			'products' => $products,
			'categories' => $categories,
		]);
	}

	protected function addProduct(Request $request) {
		$validator = Validator::make($request->all(), [
			'category' => 'required|integer|min:1',
			'name' => 'required|min:1|max:255',
			'price' => 'nullable|integer|min:1',
			'description' => 'nullable|min:1',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$category_id = $request->input('category');
		$category = Category::find($category_id);
		if(!$category)
			throw new CustomException("Invalid Category");

		$name = $request->input('name');
		$slug = str_slug($name);
		$price = $request->has('price') ? $request->input('price') : 0;
		$description = $request->has('description') ? $request->input('description') : '';

		$product = new Product();
		$product->category_id = $category->id;
		$product->product_title = $name;
		$product->product_slug = $slug;
		$product->product_price = $price;
		$product->product_description = $description;
		$product->featured = $request->has('featured') ? 1 : 0;
		$product->status = 1;
		$product->save();

		$request->session()->flash('message', 'Product added successfully');
		return redirect()->back();
	}

	protected function editProduct(Request $request) {
		$validator = Validator::make($request->all(), [
			'pid' => 'required|integer|min:1',
			'category' => 'required|integer|min:1',
			'name' => 'required|min:1|max:255',
			'price' => 'nullable|integer|min:1',
			'description' => 'nullable|min:1',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$product_id = $request->input('pid');
		$product = Product::find($product_id);
		if(!$product)
			throw new CustomException("Invalid Product");

		$category_id = $request->input('category');
		$category = Category::find($category_id);
		if(!$category)
			throw new CustomException("Invalid Category");

		$name = $request->input('name');
		$slug = str_slug($name);
		$price = $request->has('price') ? $request->input('price') : 0;
		$description = $request->has('description') ? $request->input('description') : '';

		$product->category_id = $category->id;
		$product->product_title = $name;
		$product->product_slug = $slug;
		$product->product_price = $price;
		$product->product_description = $description;
		$product->featured = $request->has('featured') ? 1 : 0;
		$product->save();

		$request->session()->flash('message', 'Product updated successfully');
		return redirect()->back();
	}

	protected function deleteProduct(Request $request, $product_id) {
		$product = Product::find($product_id);
		if(!$product)
			throw new CustomException("Invalid Product");

		$product->delete();

		$request->session()->flash('message', 'Product deleted successfully.');
		return redirect()->back();
	}

	protected function productImages(Request $request, $product_id) {
        $product = Product::findOrFail($product_id);
        $productImages = ProductServiceImage::where([['parent_id', $product->id], ['parent_type', 'product']])->get();

        return view('admin.index', [
            'title' => $product->product_title . ' | Images',
            'nav' => 'product',
            'admin_page' => 'product.product_images',
            'product' => $product,
            'productImages' => $productImages
        ]);
    }

    protected function uploadProductImages(Request $request, $product_id) {
        $product = Product::find($product_id);
        if(!$product)
            throw new CustomException("Invalid product.");

        $rules = [];
        $msg = [];
        $photos = count($request->images);
        foreach(range(0, $photos) as $index) {
            $rules['images.' . $index] = 'image|mimes:jpg,jpeg,bmp,png|max:2000';
            $msg['images.' . $index . '.image'] = 'Please select valid image.';
            $msg['images.' . $index . '.mimes'] = 'Image format must be either of jpg, jpeg, bmp or png.';
            $msg['images' . $index . '.max'] = 'Image size must be max 2MB.';
        }

        $validator = Validator::make($request->all(), $rules, $msg);

        if($validator->fails())
            throw new CustomException(implode("<br>", $validator->errors()->all()));

        $arr = [];

        $photos = $request->images;
        foreach ($photos as $photo) {
            $file_name = $product->product_slug . '-' . rand(1, 10000) . '.' . $photo->getClientOriginalExtension();

            if(!\File::isDirectory(public_path('uploads/product/thumbnail/'))) {
                \File::makeDirectory(public_path('uploads/product/thumbnail/'), 0777, true, true);
            }

            $img = \Image::make($photo->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // upload thumbnail
            $img->save(public_path('uploads/product/thumbnail/' . $file_name));

            // upload image
            $path = $photo->move('uploads/product/original/', $file_name);

            $arr[] = [
                'parent_id' => $product->id,
                'parent_type' => 'product',
                'image' => $file_name,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        ProductServiceImage::insert($arr);

        return response()->json(['status' => 'ok']);
    }

    protected function deleteProductImage(Request $request, $image_id) {
        $product_image = ProductServiceImage::find($image_id);
        if(!$product_image)
            throw new CustomException("Invalid Image");

        $file = $product_image->image;

        $product_image->delete();

        if(\File::exists(public_path('uploads/product/thumbnail/' . $file)))
            \File::delete(public_path('uploads/product/thumbnail/' . $file));

        if(\File::exists(public_path('uploads/product/original/' . $file)))
            \File::delete(public_path('uploads/product/original/' . $file));

        $request->session()->flash('message', 'Image deleted successfully.');
        return redirect()->back();
    }
}
