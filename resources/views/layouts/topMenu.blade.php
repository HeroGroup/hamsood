<style>
hr {
    color:darkgray;
    margin:10px 0;
}
</style>
<div id="myNav" class="overlay">
  <div class="overlay-content">
    @if(session('mobile'))
      <img src="@if(isset($gender) && $gender=='male') /images/avatars/male.png @elseif(isset($gender) && $gender=='female') /images/avatars/female.png @else /images/user_default_image.png @endif" width="100" height="100" style="border-radius:50%;" />
      <p style="color:#222;padding:0; padding-top:10px;margin-bottom:0;">{{session('mobile')}}</p>
      @if(isset($profileCompleted) && !$profileCompleted)
      <a href="{{route('customers.profile')}}" class="btn btn-success" style="margin-top:10px;">تکمیل مشخصات</a>
      @else
      <span style="color:#222;">{{isset($name) ? $name : ''}}</span>
      @endif
      <div style="padding:0 20px; text-align:right; margin-bottom:30px;">
        <hr />
        <a href="{{route('customers.orders.current')}}" style="padding:0 20px;text-decoration: none;">
          <img src="/images/orders.png" width="25" height="25" />
          <span>سفارشات</span>
        </a>
        <hr />
        <a href="{{route('customers.addresses')}}" style="padding:0 20px;text-decoration: none;">
          <img src="/images/addresses.png" width="25" height="25" />
          <span>آدرس ها</span>
        </a>
        <hr />
        <a href="{{route('customers.notifications')}}" style="padding:0 20px;text-decoration: none;">
          <img src="/images/bell_icon.png" width="25" height="25" />
          <span>پیام ها</span>
        </a>
        <hr />
        <a href="{{route('customers.wallet')}}" style="padding:0 20px;text-decoration: none;">
          <img src="/images/wallet_icon.png" width="25" height="25" />
          <span>کیف پول</span>
          <span style="color:#222;font-size:10px;padding:3px 6px;border:1px solid lightgray;border-radius:5px;float:left;">موجودی {{number_format($balance)}} تومان</span>
        </a>
        <hr style="color:darkgray" />
      </div>
      <a href="{{route('customers.logout')}}" style="padding:10px;border:1px solid red;border-radius:5px;text-decoration: none;">
        <img src="/images/exit_icon.png" width="20" height="25" />
        <span style="color:red;">خروج</span>
      </a>
    @else
    <img src="/images/not_entered.png" width="150" height="150" />
    <p style="color:#222;margin-top:80px;">شما هنوز وارد نشده اید</p>
    <div>
      <a class="btn btn-success" href="/verifyMobile" style="/*background-color:#008B44;*/width:150px;">ورود</a>
    </div>
    @endif
  </div>
</div>

<div class="top-navigation">
  <span id="toggleNavigation" onclick="openNav()">&#9776;</span>
  &nbsp;
  <a href="{{route('landing')}}" style="text-decoration:none;">
      <span class="logo-title">همسود</span>
  </a>
  <a href="{{route('landing')}}" style="cursor:pointer;float:left;">
      <img src="/images/logo.png" width="35" height="35" />
  </a>
  </div>
</div>

<script>
    document.addEventListener('click', function(e) {
       if(e.target != document.getElementById("toggleNavigation") && e.target != document.getElementById("myNav"))
          closeNav();
    })

    function openNav() {
      document.getElementById("myNav").style.width = "80%";
    }

    function closeNav() {
      document.getElementById("myNav").style.width = "0%";
    }
</script>
