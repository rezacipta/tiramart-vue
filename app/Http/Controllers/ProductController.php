<?php

namespace App\Http\Controllers;

use App\Http\Resources\BannerResource;
use App\Http\Resources\ProductResource;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function index()
    {
        $product = Product::isActive()->paginate(20);
        $resource = ProductResource::collection($product);

        return $this->respondWithSuccess($resource);
    }

    public function banner()
    {
        $banner = Banner::isActive()->get();
        $resource = BannerResource::collection($banner);

        return $this->respondWithSuccess($resource);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
