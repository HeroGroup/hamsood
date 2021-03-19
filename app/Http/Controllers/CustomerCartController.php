<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerCartItem;
use App\AvailableProduct;
use App\AvailableProductDetail;

class CustomerCartController extends Controller
{
    public function getRemainingTime($day,$end)
    {
        $hour = $end - 1;
        $jalali = explode('/', $day);
        $date = strtotime(jalali_to_gregorian($jalali[0], $jalali[1], $jalali[2], '/') . " $hour:59:59");
        return $date - time();
    }

    public function getCustomerCart()
    {
        $cartItems = CustomerCartItem::where('customer_id', \request()->customer->id)->get();
        foreach ($cartItems as $cartItem) {
            $remaining = $this->getRemainingTime($cartItem->availableProduct->until_day, $cartItem->availableProduct->available_until_datetime);
            if($remaining <= 0)
                $cartItem->delete();
        }

        $cartItems = CustomerCartItem::where('customer_id', \request()->customer->id)->orderBy('id', 'DESC')->get();

        return view('customers.customerCart', compact('cartItems'));
    }

    public function itemExistInCart($product, $customer)
    {
        $availableProduct = AvailableProduct::where('product_id', $product)->where('is_active', 1)->first();
        $cartItem = CustomerCartItem::where('available_product_id',$availableProduct->id)->where('customer_id', $customer)->first();
        return $cartItem ? $cartItem->weight : 0;
    }

    public function addToCart($product)
    {
        if ($this->itemExistInCart($product, \request()->customer->id) == 0) {
            $availableProduct = AvailableProduct::where('product_id', $product)->where('is_active', 1)->first();
            $remaining = HomeController::getRemainingTime($availableProduct->until_day,$availableProduct->available_until_datetime);

            if ($remaining > 0) {
                $details = AvailableProductDetail::where('available_product_id', $availableProduct->id)->get();
                $peopleBought = $availableProduct->getOrdersCount();
                // $lastDiscount = $peopleBought > 1 ? $details[$peopleBought-2]->discount : $details->min('discount');
                $nextDiscount = $peopleBought > 1 ? $details[$peopleBought-1]->discount : $details->min('discount');

                // add 1 weight to cart
                CustomerCartItem::create([
                    'customer_id' => \request()->customer->id,
                    'available_product_id' => $availableProduct->id,
                    'weight' => 1,
                    'real_price' => $availableProduct->price,
                    'discount' => $availableProduct->price*($nextDiscount/100)
                ]);

                // session([
                //     'product' => $product,
                //     'available_product_id' => $availableProduct->id,
                //     'real_price' => $availableProduct->price,
                //     'discount' => $nextDiscount
                // ]);

                // $product = Product::find($product);
                // return view('customers.customerCart',compact('availableProduct', 'product', 'nextDiscount'));
                return redirect(route('customers.customerCart'));
            } else {
                return redirect(route('landing'));
            }
        } else {
            return redirect(route('customers.customerCart'));
        }
    }

    public function removeFromCart($product, $customer)
    {
        try {
            if ($this->itemExistInCart($product, $customer) > 0) {
                $availableProduct = AvailableProduct::where('product_id', $product)->where('is_active', 1)->first();
                $cartItem = CustomerCartItem::where('available_product_id', $availableProduct->id)->where('customer_id', \request()->customer->id)->first();
                $cartItem->delete();
            }
            return 0; // refresh page
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function increaseCartItem($product)
    {
        try {
            $availableProduct = AvailableProduct::find($product);
            if ($availableProduct) {
                $newWeight = $this->itemExistInCart($availableProduct->product_id, \request()->customer->id);

                if ($newWeight == 0) {
                    $this->addToCart($product);
                    $newWeight++;
                } else {
                    $cartItem = CustomerCartItem::where('available_product_id', $product)->where('customer_id', \request()->customer->id)->first();
                    if ($cartItem) {
                        if ($cartItem->weight < 4) {
                            $newWeight++;
                            $cartItem->update(['weight' => $newWeight]);
                        }
                    } else {
                        $this->addToCart($product);
                        $newWeight++;
                    }
                }

                return $this->success("increased cart item successfully", $newWeight);
            } else {
                return $this->fail("invalid product");
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getLine().": ".$exception->getMessage());
        }
    }

    public function decreaseCartItem($product)
    {
        try {
            $availableProduct = AvailableProduct::find($product);
            if ($availableProduct) {
                $newWeight = $this->itemExistInCart($availableProduct->product_id, \request()->customer->id);

                if ($newWeight > 0) {
                    $cartItem = CustomerCartItem::where('available_product_id', $product)->where('customer_id', \request()->customer->id)->first();
                    if ($cartItem && $cartItem->weight > 1) {
                        $newWeight--;
                        $cartItem->update(['weight' => $newWeight]);
                    } else {
                        return $this->success("cart removed successfully", $this->removeFromCart($availableProduct->product_id, \request()->customer->id));
                    }
                }
                return $this->success("decreased cart item successfully", $newWeight);
            } else {
                return $this->fail("invalid product");
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}
