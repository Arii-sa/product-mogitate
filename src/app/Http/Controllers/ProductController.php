<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Models\ProductSeason;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * 商品一覧
     */
    public function index(Request $request)
    {
        // 検索条件
        $query = Product::query()->with('seasons');

        // 商品名検索（部分一致）
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 並び替え（高い順・安い順）
        if ($request->filled('sort')) {
            if ($request->sort === 'high') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort === 'low') {
                $query->orderBy('price', 'asc');
            }
        }

        // ページネーション (6件ごと)
        $products = $query->paginate(6)->appends($request->all());

        return view('products.index', [
            'products' => $products,
            'keyword' => $request->keyword,
            'sort' => $request->sort,]);
    }

    /**
     * 商品詳細
     */
    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id);
        $seasons = Season::all(); // ← 追加
        return view('products.show', compact('product', 'seasons')); 
    }

    /**
     * 商品登録画面
     */

    public function create()
    {
        $seasons = Season::all();
        return view('products.create',compact('seasons'));
    }

    public function store(StoreProductRequest $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0|max:10000',
            'description' => 'required|max:120',
            'image' => 'required|mimes:png,jpeg',
            'seasons' => 'required|array',
        ]);

        // 画像保存
        $path = $request->file('image')->store('products', 'public');

        // 商品登録
        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $path,
        ]);

        $product->seasons()->sync($validated['seasons']);

        return redirect()->route('products.index');
    }

    /**
     * 商品編集画面
     */
    public function edit($id)
    {
        $product = Product::with('seasons')->findOrFail($id);
        $seasons = Season::all();
        return view('products.edit', compact('product', 'seasons'));
    }

    /**
     * 商品更新処理
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validated();

    // 画像更新
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
        ]);

        $product->seasons()->sync($validated['seasons']);

        return redirect()->route('products.index');
    }

    /**
     * 商品削除
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index');
    }


}
