<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Province;
use App\Model\District;
use App\Model\Ward;
use App\Model\FeeShippingModel;

class FeeShippingController extends Controller
{
    public function fee_shipping()
    {
        $all_province = Province::orderby("Province_Name", 'ASC')->get();
        $all_district = District::all();
        $all_ward = Ward::all();
        $shipping = FeeShippingModel::all();
        return view('backend.shipping.manage-shipping')->with(compact('all_province', 'all_district', 'all_ward', 'shipping'));
    }
    public function save_fee_shipping(Request $request)
    {
        $data = $request->all();
        $shipping = new FeeShippingModel;
        $shipping->Fee_Province_ID = $data['fee_province_id'];
        $shipping->Fee_District_ID = $data['fee_district_id'];
        $shipping->Fee_Ward_ID = $data['fee_ward_id'];
        $shipping->Fee_Shipping = filter_var($data['fee_shipping'], FILTER_SANITIZE_NUMBER_INT);
        $shipping->save();

        return redirect()->back()->with(compact('shipping'));
    }
    public function update_fee_shipping(Request $request)
    {
        $data = $request->all();
        FeeShippingModel::where('Fee_Shipping_ID', $data['fee_shipping_id'])
            ->update(['Fee_Shipping' => $data['get_fee_shipping']]);
        $fee_shipping = FeeShippingModel::where('Fee_Shipping_ID', $data['fee_shipping_id'])->first();
        return response()->json($fee_shipping);
    }
}