@extends('layouts.customer', ['pageTitle' => 'آدرس محل دریافت کالا', 'withNavigation' => true])
@section('content')
    <style>
        .address-card {
            width:100%;;text-align: right;border-radius:5px;padding:5px 10px;cursor:pointer;margin-bottom: 15px;
        }
        .checked {
            float:left;
        }
        .not-selected {
            border:1px dashed #222
        }
        .selected {
            border:2px solid #31AC6B;
        }
    </style>
    <div style="text-align:center;margin-top:80px;color:#222;padding:15px;">
    @if(count($addresses) > 0)
        @foreach($addresses as $address)
            <div id="address-card-{{$address->id}}" class="address-card @if($address->is_default) selected @else not-selected @endif" onclick="makeDefault({{$address->id}})" >
                @if($address->is_default)
                    <!--<img src='/images/checked_icon.png' width='20' height='20' class='checked' />-->
                @endif
                <div style="float: left">
                    <a href="/selectNeighbourhood/{{$withConfirm}}/{{$address->id}}">
                        <img src="/images/edit_icon.png" height="20" width="20" />
                    </a>&nbsp;
                    <a href="/removeAddress/{{$address->id}}">
                        <img src="/images/delete_icon.png" height="20" width="20" />
                    </a>&nbsp;
                </div>
                <p>{{$address->neighbourhood->name}}</p>
                <p>{{$address->details}}</p>
            </div>
        @endforeach
        @if(isset($withConfirm) && $withConfirm == 1)
            <div style="position:fixed;bottom:0;left:0;width:100%;">
                <button class="btn confirm-button">
                    تائید آدرس
                </button>
            </div>
        @endif
    @else
        <div>
            <img src="/images/new_address.png" width="120" height="120" />
            <div style="margin-top:50px;">
                <p>آدرس محل تحویل کالا را با کلیک بر روی</p>
                <p>دکمه <b>ثبت آدرس جدید</b> ثبت کنید</p>
            </div>
        </div>
        @if(isset($withConfirm) && $withConfirm == 1)
            <div style="position:fixed;bottom:0;left:0;width:100%;">
                <button class="btn confirm-button" disabled style="background-color:lightgray;color:darkgray;">
                    تائید آدرس
                </button>
            </div>
        @endif
    @endif
        <div class="dashed-button-container">
            <a href="selectNeighbourhood/{{$withConfirm}}" class="dashed-button">ثبت آدرس جدید</a>
        </div>
    </div>

<script>
    var defaultAddressId = 0;
    $(document).ready(function() {

    });
    function makeDefault(addressId) {
        if (defaultAddressId === addressId) {
            //
        } else {
            defaultAddressId = addressId;
            // $('.checked').remove();
            $(".address-card").removeClass("selected").addClass("not-selected");
            $(`#address-card-${addressId}`).removeClass("not-selected").addClass("selected");
            // $(`#address-card-${addressId}`).prepend(`<img src='/images/checked_icon.png' width='20' height='20' class='checked' />`);

            $.ajax(`addresses/makeDefault/${addressId}`, {
                type:"get",
                success: function() {
                    //
                }
            })
        }
    }
</script>
@endsection
