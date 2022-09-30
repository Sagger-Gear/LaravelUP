<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Product\ProductCreateValidation;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $products = Product::paginate(15);
        return view('admin.product.index', compact('products'));
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.product.createOrUpdate');
    }

    public function store(ProductCreateValidation $request): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validated();
        unset($validate['photo_file']);
        # public/gjkdhsjgks1851jfk.jpg
        $photo = $request->file('photo_file')->store('public');
        # Explode => / => public/gjkdhsjgks1851jfk.jpg => ['public', 'gjkdhsjgks1851jfk.jpg']
        $validate['photo'] = explode('/', $photo)[1];

        Product::create($validate);
        return back()->with(['success' => true]);
    }

    public function show(Product $product)
    {

    }

    public function edit(Product $product)
    {

    }

    public function update(Request $request, Product $product)
    {

    }

    public function destroy(Product $product)
    {

    }
}
