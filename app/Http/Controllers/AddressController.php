<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerAddress;
use App\Neighbourhood;

class AddressController extends Controller
{
    public function neighbourhoodsList()
    {
        $neighbourhoods = Neighbourhood::orderBy('name')->get();
        return view('admin.neighbourhoods.index', compact('neighbourhoods'));
    }
    public function addresses()
    {
        $addresses = CustomerAddress::where('customer_id',\request()->customer->id)->get();
        $withConfirm = 0;
        session(['withConfirm' => $withConfirm]);
        return view('customers.addresses', compact('addresses', 'withConfirm'));
    }

    public function selectAddress()
    {
        $addresses = CustomerAddress::where('customer_id',\request()->customer->id)->get();
        $withConfirm = 1;
        $customerName = "hero";
        session(['withConfirm' => $withConfirm]);
        return view('customers.addresses', compact('addresses', 'withConfirm', 'customerName'));
    }

    public function selectNeighbourhood($redirect, $address=null)
    {
        session(['withConfirm' => $redirect]);
        $neighbourhood_id = 0;
        if ($address > 0) { // edit
            $cu = CustomerAddress::find($address);
            if ($cu) {
                $neighbourhood_id = $cu->neighbourhood_id;
                return view('customers.neighbourhood', compact('address', 'neighbourhood_id'));
            } else {
                return abort(404);
            }

        } else { // new
            return view('customers.neighbourhood', compact('neighbourhood_id'));
        }
    }

    public function getNeighbourhoods($city, $keyword=null)
    {
        $neighbourhoods = Neighbourhood::where('city_id',$city);
        if ($keyword)
            $neighbourhoods = $neighbourhoods->where('name','LIKE',"%$keyword%");

        $neighbourhoods = $neighbourhoods->select('id','name')->get();

        return response()->json($neighbourhoods);
    }

    public function postNeighbourhood($neighbourhood, $address=null)
    {
        $neighbourhood = Neighbourhood::find($neighbourhood);
        $cu = CustomerAddress::find($address);
        $details = $cu ? $cu->details : "";
        return view('customers.addressDetails', compact('neighbourhood', 'address', 'details'));
    }

    public function postAddressDetail(Request $request)
    {
        if ($request->has('id') && $request->id > 0) {
            $cu = CustomerAddress::find($request->id);
            $cu->update($request->all());
        } else {
            $customerAddresses = CustomerAddress::where('customer_id',$request->customer->id);
            if ($customerAddresses->count() > 0)
                $customerAddresses->update(['is_default' => 0]);

            CustomerAddress::create([
                'customer_id' => $request->customer->id,
                'neighbourhood_id' => $request->neighbourhood_id,
                'details' => $request->details
            ]);
        }

        return (session('withConfirm') == "1" ? redirect(route('customers.selectAddress')) : redirect(route('customers.addresses')));
    }

    public function makeDefaultAddress($addressId)
    {
        try {
            $customerAddresses = CustomerAddress::where('customer_id', \request()->customer->id);
            if ($customerAddresses->count() > 0)
                $customerAddresses->update(['is_default' => 0]);

            $customerAddress = CustomerAddress::find($addressId);
            $customerAddress->update(['is_default' => 1]);

            return $this->success('success');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function removeAddress($addressId)
    {
        try {
            $customerAddress = CustomerAddress::find($addressId);
            if ($customerAddress) {
                if($customerAddress->is_default) {
                    $defaultAddress = CustomerAddress::where('customer_id',$customerAddress->customer_id)->first();
                    if ($defaultAddress)
                        $defaultAddress->update(['is_default' => 1]);
                }
                $customerAddress->delete();
                return (session('withConfirm') == "1" ? redirect(route('customers.selectAddress')) : redirect(route('customers.addresses')));
            } else {
                return (session('withConfirm') == "1" ? redirect(route('customers.selectAddress')) : redirect(route('customers.addresses')));
            }
        } catch (\Exception $exception) {
            return (session('withConfirm') == "1" ? redirect(route('customers.selectAddress')) : redirect(route('customers.addresses')));
        }
    }
}
