<?php

namespace App\Http\Controllers;

use App\DeliveryTimeFee;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        $list = DeliveryTimeFee::all();
        return view('admin.deliveries.index', compact('list'));
    }

    public function create()
    {
        return view('admin.deliveries.create');
    }

    public function store(Request $request)
    {
        try {
            if (strlen($request->data) > 0) {
                $items = json_decode($request->data);
                DeliveryTimeFee::where('id','>',0)->delete();
                foreach ($items as $item) {
                    DeliveryTimeFee::create([
                        'delivery_start_time' => $item->start,
                        'delivery_end_time' => $item->end,
                        'delivery_fee' => $item->fee,
                        'delivery_fee_for_now' => $item->feeNow >= 0 ? $item->feeNow : null,
                    ]);
                }

                return $this->success("ذخیره سازی با موفقیت انجم شد");
            } else {
                return $this->fail("اطلاعات ورودی نامعتبر می باشد");
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getLine().': '.$exception->getMessage());
        }
    }

    public function update(Request $request, $deliveryTimeFee)
    {
        $item = DeliveryTimeFee::find($deliveryTimeFee);
        $item->update($request->all());
        return redirect(route('deliveries.index'));
    }

    public function destroy(DeliveryTimeFee $deliveryTimeFee)
    {
        try {
            DeliveryTimeFee::find($deliveryTimeFee)->delete();
            return redirect()->back()->with('message', 'حذف با موفقیت انجام شد')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect()->back()->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }
}
