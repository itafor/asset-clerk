<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\AssetPhoto;
use App\AssignedAsset;
use Validator;
use DB;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::query()->join('categories', 'assets.category_id', '=', 'categories.id')
        ->select('assets.uuid','assets.id', 'assets.quantity_added','assets.address', 'categories.name', 'assets.description',
            'assets.price')
        ->where('assets.user_id', auth()->id());

        if($request->has('search') && $request['search']){
            $search = $request['search'];
            $query->where('assets.description', 'like', "%{$search}%")
            ->orWhere('assets.address', 'like', "%{$search}%")
            ->orWhere('categories.name', 'like', "%{$search}%");
        }

        $data = [
            'assetsCategories' => $query->orderBy('assets.id', 'desc')->paginate(10),
            'term' => ''
        ];

        return view('admin.assets.index', $data);
    }

    public function create()
    {
        return view('admin.assets.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'category' => 'required',
            'quantity' => 'required',
            'standard_price' => 'required',
            'landlord' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'detailed_information' => 'required',
            'building_age' => 'required',
            'bedrooms' => 'required',
            'bathrooms' => 'required',
            'features.*' => 'required',
            'photos.*' => 'required|image'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        DB::beginTransaction();
        try{
            Asset::createNew($request->all());
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            return back()->withInput()->with('error', 'An error occured. Please try again');
        }
        return redirect()->route('asset.index')->with('success', 'Asset added successfully');
    }

    public function edit($uuid)
    {
        $asset = Asset::where('uuid', $uuid)->first();
        if($asset){
            return view('admin.assets.edit', compact('asset'));
        }
        else{
            return back()->with('error', 'Whoops! Could not find asset');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'category' => 'required',
            'quantity' => 'required',
            'standard_price' => 'required',
            'landlord' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'detailed_information' => 'required',
            'building_age' => 'required',
            'bedrooms' => 'required',
            'bathrooms' => 'required',
            'features.*' => 'required',
            'uuid' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        DB::beginTransaction();

        try{
            Asset::updateAsset($request->all());
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            return back()->withInput()->with('error', 'An error occured. Please try again');
        }

        return redirect()->route('asset.index')->with('success', 'Asset updated successfully');
    }

    public function delete($uuid)
    {
        $asset = Asset::where('uuid', $uuid)->first();
        if($asset){
            $asset->delete();
            return back()->with('success', 'Asset deleted successfully');
        }
        else{
            return back()->with('error', 'Whoops! Could not find asset');
        }
    }

    public function deleteImage($id)
    {
        $photo = AssetPhoto::find($id);
        if($photo){
            $photo->delete();
            return back()->with('success', 'Photo deleted successfully');
        }
        else{
            return back()->with('error', 'Photo not found. Please try again');
        }
    }

    public function assign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asset' => 'required',
            'user' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please select a user');
        }

        $exists = AssignedAsset::where([
            ['asset_id', $request['asset']],
            ['user_id', $request['user']],
        ])->first();

        if($exists){
            return back()->with('error', 'Asset has already been assigned to this user');
        }
        else{
            $aa = new AssignedAsset;
            $aa->asset_id = $request['asset'];
            $aa->user_id = $request['user'];
            $aa->save();
        }
        return back()->with('success', 'Asset has been assigned to user successfully');
    }

    public function myAssets(Request $request)
    {
        $query = AssignedAsset::query()->join('assets', 'assets.id', '=', 'assigned_assets.asset_id')
        ->join('categories', 'assets.category_id', '=', 'categories.id')
        ->select('assets.uuid','assets.id', 'assets.quantity_added','assets.address', 'categories.name', 'assets.description',
            'assets.price')
        ->where('assigned_assets.user_id', auth()->id());

        if($request->has('search') && $request['search']){
            $search = $request['search'];
            $query->where('assets.description', 'like', "%{$search}%")
            ->orWhere('assets.address', 'like', "%{$search}%")
            ->orWhere('categories.name', 'like', "%{$search}%");
        }

        $data = [
            'assetsCategories' => $query->orderBy('assets.id', 'desc')->paginate(10),
            'term' => ''
        ];
        return view('admin.assets.my', $data);
    }
}
