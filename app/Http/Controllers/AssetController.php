<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;

class AssetController extends Controller
{
    public function index()
    {
        $assetsCategories = Asset::join('categories', 'assets.category_id', '=', 'categories.id')
        ->select('assets.id', 'assets.quantity_added','assets.address', 'categories.name', 'assets.description',
            'assets.price')
        ->orderBy('assets.id', 'desc')->get();

        $data = [
            'assetsCategories' => $assetsCategories
        ];

        return view('admin.assets.index', $data);
    }

    public function create()
    {
        return view('admin.assets.create');
    }
}
