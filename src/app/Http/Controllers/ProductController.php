<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use App\Models\Season;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        $keyword = $request->get('keyword');
        $currentSort = $request->get('sort');

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $currentSort = $request->get('sort');

        if ($currentSort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($currentSort === 'price_asc') {
            $query->orderBy('price', 'asc');
        }

        $products = $query->paginate(6);

        $headerTitle = $this->getHeaderTitle($keyword);

        $sortData = $this->getSortDisplayData($request, $currentSort);

        return view('products', [
            'products' => $products,
            'sortData' => $sortData,
            'headerTitle' => $this->getHeaderTitle($keyword),
        ]);
    }

    private function getSortDisplayData(Request $request, ?string $currentSort): array
    {
        $sortText = '';

        if ($currentSort === 'price_desc') {
            $sortText = '価格の高い順';
        } elseif ($currentSort === 'price_asc') {
            $sortText = '価格の低い順';
        }

        $resetQuery = http_build_query($request->except(['sort', 'page']));

        $resetUrl = '/products' . (empty($resetQuery) ? '' : '?' . $resetQuery);

        return [
            'currentSort' => $currentSort,
            'sortText' => $sortText,
            'resetUrl' => $resetUrl,
        ];
    }

    private function getHeaderTitle(?string $keyword): string
    {
        if (!empty($keyword)) {
            return "{$keyword}の商品一覧";
        }
        return '商品一覧';
    }

    public function show(string $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $seasons = \App\Models\Season::all();

        return view('product_detail', [
            'product' => $product,
            'seasons' => $seasons, // 季節データをビューに渡す
        ]);
    }

    public function create()
    {
        $seasons = Season::all();

        return view('product_create', [
            'seasons' => $seasons,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0', 'max:10000'],
            'seasons' => ['required', 'array', 'min:1'],
            'seasons.*' => ['string', 'in:春,夏,秋,冬'],
            'description' => ['required', 'string', 'max:120'],
            'image_path' => ['required', 'image', 'mimes:jpeg,png'],
        ], [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0~10000円以内で入力してください',
            'price.max' => '0~10000円以内で入力してください',
            'seasons.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image_path.required' => '商品画像を登録してください',
            'image_path.required' => '「.png」または「.jpeg」形式でアップロードしてください',
        ]);

        $imagePath = $validatedData('image_path')->store('products', 'public');

        $seasonsString = implode(', ', $validatedData['seasons']);

        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'image_path' => $imagePath,
            'seasons' => $seasonsString,
        ]);

        return redirect()->route('products.index')->with('success', '新しい商品を登録しました。');
    }
}


