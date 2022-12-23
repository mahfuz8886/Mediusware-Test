<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //$variants = Variant::pluck('id');
        //$variants = Variant::with('variants')->get();
        $variants = Variant::get();
        //return $variants->variants_name(1);
        foreach($variants as $variant) {
            //echo $variant->variants_name();
        }
        //return $variants->variants_2();
        // $variants = $variants->whereHas('variants', function ($v) {
        //     $v->distinct('variant');
        // });
        //$product_variants = ProductVariant::pluck('variant');
        //return $product_variants->groupBy('variant');
        $product_variants = ProductVariant::select('variant_id', 'variant')->distinct()->get();
        //return $product_variants;
        //return $product_variants->pluck('variant');

        $products = Product::with('product_variant_prices');
        //return $products->get();
        if($request->title != NULL) {
            $products = $products->where('title', 'like', '%' . $request->title . '%');
        }
        if($request->variant != NULL) {
            $products = $products->WhereHas('product_variant_prices.color', function ($p) use ($request) {
                $p->where('variant', $request->variant);
            })
            ->orWhereHas('product_variant_prices.size', function ($q) use ($request) {
                $q->where('variant', $request->variant);
            })
            ->orWhereHas('product_variant_prices.style', function ($q) use ($request) {
                $q->where('variant', $request->variant);
            });
        }
        if($request->price_from != NULL) {
            $products = $products->WhereHas('product_variant_prices', function ($p) use ($request) {
                $p->where('price', '>=', $request->price_from);
            });
        }
        if($request->price_to != NULL) {
            $products = $products->WhereHas('product_variant_prices', function ($p) use ($request) {
                $p->where('price', '<=', $request->price_to);
            });
        }
        if($request->date != NULL) {
            $start = date('Y-m-d', strtotime($request->date)).' 00:00:00';
            $end = date('Y-m-d', strtotime($request->date)).' 23:59:59';
            $products = $products->where('created_at', '>=', $start)->where('created_at','<=', $end);
        }
        //$products = $products->get();
        $products = $products->paginate(5);
        return view('products.index', compact('products', 'variants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
