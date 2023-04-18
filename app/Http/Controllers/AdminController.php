<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function adminDash(Request $request)
    {

        $vendor = Vendor::join('canteens','canteen_id','=','canteens.id')
                    ->select('vendors.*','canteens.name as canteen_name')
                    ->orderBy('canteen_id','ASC')
                    // ->get();
                    ->paginate(10);
        // dd($vendor);
        return view('adminDash', ['vendors' => $vendor]); 
    }

    public function getVendorDetails(Request $request){
        $vendor =  Vendor::where('id',$request->vendorid)
                    ->with('canteen')
                    ->first();

        $approved_by = Admin::where('id',$vendor->approved_by)
                        ->first();
        return view('adminVendorDetails',['vendor' => $vendor, 'approved_by' =>$approved_by]);
    }

    public function rejectVendor(Request $request){
        $vendor=  Vendor::where('id',$request->vendorid)
                    ->with('canteen')
                    ->first();
        
        $vendor->rejection_reason = $request->rejection_reason;
        $vendor->upcoming_deletion_date = Carbon::now()->addDays(2);
        $vendor->save();
        
        return redirect('/admin-dash');
    }

    public function acceptVendor(Request $request){
        
        $vendor=  Vendor::where('id',$request->vendorid)
                    ->with('canteen')
                    ->first();
        $vendor->approved_by = auth()->guard('admin')->user()->id;
        $vendor->save();
        return redirect('/admin-dash');
    }
}
