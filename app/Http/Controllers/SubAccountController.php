<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\SubRequest;
use Illuminate\Support\Facades\Hash;
use App\Asset;
use App\Staff;
use App\AssignedAsset;
use DB;
use Illuminate\Http\Request;

class SubAccountController extends Controller
{
    /**
     * Display a listing of the subs
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $plan = getUserPlan();
        $limit = $plan['details']->sub_accounts;
        $model = Staff::query()
        ->join('users as u', 'u.id', '=', 'staffs.staff_id')
        ->join('assets as a', 'a.id', '=', 'staffs.asset_id')
        ->where('owner_id', getOwnerUserID())
        ->select('u.firstname', 'u.lastname', 'u.email', 'u.id', 'a.description')
        ->limit($limit);

        return view('new.admin.subs.index', ['users' => $model->get()]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        chekUserPlan('accounts');
        $assets = Asset::where('user_id', getOwnerUserID())->get();
        return view('new.admin.subs.create', compact('assets'));
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SubRequest $request, User $model)
    {
        chekUserPlan('accounts');

        $plan = getUserPlan();
        $subAccounts = $plan['details']->sub_accounts;

        if($subAccounts == 0) {
            return back()->with('error', 'Please upgrade your plan to add sub account');
        }
        
        $totalAccounts = Staff::query()
        ->join('users as u', 'u.id', '=', 'staffs.staff_id')
        ->join('assets as a', 'a.id', '=', 'staffs.asset_id')
        ->where('owner_id', getOwnerUserID())
        ->select('u.firstname', 'u.lastname', 'u.email', 'u.id', 'a.description')
        ->count();
        
        if($totalAccounts >= $subAccounts) {
            return back()->with('error', 'Please upgrade your plan to add more sub accounts');
        }


        DB::beginTransaction();
        try{
            $user = $model->create($request->merge([
                'password' => Hash::make($request->get('password')),
                'sub_account' => 1,
                'role' => 'agent' 
            ])->all());
        
            DB::table('staffs')->insert([
                'owner_id' => getOwnerUserID(),
                'staff_id' => $user->id,
                'asset_id' => $request['asset']
            ]);

            $aa = new AssignedAsset;
            $aa->asset_id = $request['asset'];
            $aa->user_id = $user->id;
            $aa->save();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            return back()->with('error', 'An error occured. Please try again');
        }

        return redirect()->route('subs.index')->withStatus(__('Sub account successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('subs.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        if(!isset($request['asset'])){
            return back()->with('error', 'Please select asset');
        }
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if(isset($request->sub)){
            $user = User::find($request->sub);
            $user->delete();
            $staff = Staff::where('staff_id', $request->sub)->first();
            $staff->delete();
        }
        return redirect()->route('subs.index')->withStatus(__('Sub Account successfully deleted.'));
    }
}
