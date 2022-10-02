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

    public function create(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $breadcrumbs = [
            ['routeName'=>'welcome','name'=>'Главная страница'],
            ['name'=>'Создание нового товара']
        ];
        $request->session()->flashInput();
        return view('admin.product.createOrUpdate', compact('breadcrumbs'));
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
        $breadcrumbs = [
            ['routeName'=>'welcome','name'=>'Главная страница'],
            ['routeName'=>'admin.product.index','name'=>'Все продукты'],
            ['name'=>$product->name],
        ];
        return view('admin.product.show', compact('product'));
    }

    public function edit(Request $request, Product $product)
    {
        $breadcrumbs = [
            ['routeName'=>'welcome','name'=>'Главная страница'],
            ['routeName'=>'admin.product.index','name'=>'Все продукты'],
            ['routeName'=>'admin.product.show','params'=>['product'=>$product->id], 'name' => $product->name],
            ['name'=>$product->name . ' | Редактирование'],
        ];
        $request->session()->flashInput($product->toArray());
        return view('admin.product.createOrUpdate', compact('product', 'breadcrumbs'));
    }

    public function update(ProductUpdateValidation $request, Product $product)
    {
        $validate = $request->validated();
        unset($validate['photo_file']);
        if($request->hasFile('photo_file')){
        # public/gjkdhsjgks1851jfk.jpg
        $photo = $request->file('photo_file')->store('public');
        # Explode => / => public/gjkdhsjgks1851jfk.jpg => ['public', 'gjkdhsjgks1851jfk.jpg']
        $validate['photo'] = explode('/', $photo)[1];
        }
        $product->update($validate);
        return back()->with(['success' => true]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index');
    }

    public function indexMain()
    {
        $products = Product::simplePaginate(25);
        return view('user.product.main', compact('products'));
    }

    public function firstProduct(Product $product)
    {
        $breadcrumbs = [
            ['routeName'=>'welcome','name'=>'Главная страница'],
            ['name'=>$product->name]
        ];
        return view('user.product.first', compact('product', 'breadcrumbs'));
    }
}
