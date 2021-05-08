<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerCartItem;
use App\AvailableProduct;
use App\AvailableProductDetail;

class CustomerCartController extends Controller
{
    public function getCustomerCart()
    {
        $cartItems = CustomerCartItem::where('customer_id', \request()->customer->id)->get();
        foreach ($cartItems as $cartItem) {
            $remaining = HomeController::getRemainingTime($cartItem->availableProduct->until_day, $cartItem->availableProduct->available_until_datetime);
            if($remaining <= 0)
                $cartItem->delete();
        }

        $cartItems = CustomerCartItem::where('customer_id', \request()->customer->id)->orderBy('id', 'DESC')->get();
        $totals = $this->getCartTotals(\request()->customer->id);

        return view('customers.customerCart', compact('cartItems', 'totals'));
    }

    public function itemExistInCart($product, $customer)
    {
        $availableProduct = AvailableProduct::where('product_id', $product)->where('is_active', 1)->first();
        $cartItem = CustomerCartItem::where('available_product_id',$availableProduct->id)->where('customer_id', $customer)->first();
        return $cartItem ? $cartItem->weight : 0;
    }

    public function getCartTotals($customer)
    {
        $realTotalPrice = 0;
        $totalDiscount = 0;
        $yourTotalPrice = 0;
        $cart = CustomerCartItem::where('customer_id',$customer)->get();
        foreach ($cart as $item) {
            $realTotalPrice += $item->weight*$item->real_price;
            $totalDiscount += $item->weight*$item->discount;
        }
        $yourTotalPrice = $realTotalPrice - $totalDiscount;
        return ['real_total_price' => $realTotalPrice, 'your_total_price' => $yourTotalPrice];
    }

    public function addToCart($product,$return=null)
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

                return $return ? back() : redirect(route('customers.customerCart'));
            } else {
                return redirect(route('landing'))->with('message','زمان سفارش گیری به اتمام رسید')->with('type', 'danger');
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
            $customer = \request()->customer->id;
            if ($availableProduct) {
                $remaining = HomeController::getRemainingTime($availableProduct->until_day,$availableProduct->available_until_datetime);
                if($remaining > 0) {
                    $newWeight = $this->itemExistInCart($availableProduct->product_id, $customer);

                    if ($newWeight == 0) {
                        $this->addToCart($product);
                        $newWeight++;
                    } else {
                        $cartItem = CustomerCartItem::where('available_product_id', $product)->where('customer_id', $customer)->first();
                        if ($cartItem) {
                            if ($cartItem->weight < 4) {
                                $newWeight+=.5;
                                $cartItem->update(['weight' => $newWeight]);
                            }
                        } else {
                            $this->addToCart($product);
                            $newWeight++;
                        }
                    }

                    return $this->success("increased cart item successfully", $this->getCartTotals($customer));
                } else {
                    if($this->removeFromCart($product,$customer)==0)
                        return redirect(route('landing'))->with('message','زمان سفارش گیری به اتمام رسید')->with('type', 'danger');
                }

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
            $customer = \request()->customer->id;
            $availableProduct = AvailableProduct::find($product);
            if ($availableProduct) {
                $newWeight = $this->itemExistInCart($availableProduct->product_id, $customer);

                if ($newWeight > 0) {
                    $cartItem = CustomerCartItem::where('available_product_id', $product)->where('customer_id', $customer)->first();
                    if ($cartItem && $cartItem->weight > 1) {
                        $newWeight-=.5;
                        $cartItem->update(['weight' => $newWeight]);
                    } else {
                        return $this->success("cart removed successfully", $this->removeFromCart($availableProduct->product_id, $customer));
                    }
                }
                return $this->success("decreased cart item successfully", $this->getCartTotals($customer));
            } else {
                return $this->fail("invalid product");
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}
