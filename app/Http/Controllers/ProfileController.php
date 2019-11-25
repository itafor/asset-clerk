<?php

namespace App\Http\Controllers;

use App\CompanyDetail;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('new.profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    public function createCompanyDetail(){
         return view('new.profile.create_company_detail');
    }
    public function storeCompanyDetail(Request $request) {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required',
            'company_address' => 'required',
            'company_logo' => 'required|image'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        DB::beginTransaction();
        try {
            CompanyDetail::createNew($request->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
         return redirect()->route('companydetail.view')->with('success', 'Company detail added successfully');
    }

    public function viewCompanyDetail(){
        $details = CompanyDetail::where('user_id',auth()->user()->id)->first();

         return view('new.profile.view_company_detail',compact('details'));
    }

    public function editCompanyDetail($uuid){
        $details = CompanyDetail::where('uuid',$uuid)->first();
       
         return view('new.profile.edit_company_detail',compact('details'));
    }

    public function updateCompanyDetail(Request $request){
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required',
            'company_address' => 'required',
            'company_logo' => 'image'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        DB::beginTransaction();
        try {
            CompanyDetail::updateCompanyDetail($request->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
         return redirect()->route('companydetail.view')->with('success', 'Company detail updated successfully');
    }
}
