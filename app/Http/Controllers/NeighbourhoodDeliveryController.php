<?php

namespace App\Http\Controllers;

use App\Neighbourhood;
use App\NeighbourhoodDeliveryTimeFee;
use Illuminate\Http\Request;

class NeighbourhoodDeliveryController extends Controller
{
    public function index(Neighbourhood $neighbourhood)
    {
        $list = NeighbourhoodDeliveryTimeFee::where('neighbourhood_id', $neighbourhood->id)->get();
        return view('admin.neighbourhoodDeliveries.index', compact('list', 'neighbourhood'));
    }

    public function create(Neighbourhood $neighbourhood)
    {
        return view('admin.neighbourhoodDeliveries.create', compact('neighbourhood'));
    }

    public function store(Request $request)
    {
        try {
            if ($request->neighbourhood > 0 && strlen($request->data) > 0) {
                $neighbourhood = $request->neighbourhood;
                $items = json_decode($request->data);
                NeighbourhoodDeliveryTimeFee::where('neighbourhood_id', $neighbourhood)->delete();
                foreach ($items as $item) {
                    NeighbourhoodDeliveryTimeFee::create([
                        'neighbourhood_id' => $neighbourhood,
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

    public function update(Request $request, $neighbourhoodDeliveryTimeFee)
    {
        $item = NeighbourhoodDeliveryTimeFee::find($neighbourhoodDeliveryTimeFee);
        $item->update($request->all());
        return redirect(route('neighbourhoodDeliveries.index', $item->neighbourhood_id));
    }

    public function destroy($neighbourhoodDeliveryTimeFee)
    {
        try {
            NeighbourhoodDeliveryTimeFee::find($neighbourhoodDeliveryTimeFee)->delete();
            return redirect()->back()->with('message', 'حذف با موفقیت انجام شد')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect()->back()->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }
}
