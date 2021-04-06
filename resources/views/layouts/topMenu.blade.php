<div id="myNav" class="overlay">
  <div class="overlay-content">
    @if(session('mobile'))
      <img src="@if(isset($gender) && $gender=='male') /images/avatars/male.png @elseif(isset($gender) && $gender=='female') /images/avatars/male.png @else /images/user_default_image.png @endif" width="100" height="100" style="border-radius:50%;" />
      <p style="color:#222;padding: 10px 0;">{{session('mobile')}}</p>
      @if(!$profileCompleted)<a href="{{route('customers.profile')}}" class="btn btn-success">تکمیل مشخصات</a>@endif
      <div style="padding:0 20px; text-align:right; margin-bottom:30px;">
        <hr style="color:darkgray" />
        <a href="{{route('customers.orders.current')}}" style="padding:0 20px;text-decoration: none;">
          <img src="/images/orders.png" width="30" height="30" />
          <span>سفارشات</span>
        </a>
        <hr style="color:darkgray" />
        <a href="{{route('customers.addresses')}}" style="padding:0 20px;text-decoration: none;">
          <img src="/images/addresses.png" width="30" height="30" />
          <span>آدرس ها</span>
        </a>
        <hr style="color:darkgray" />
        <a href="{{route('customers.wallet')}}" style="padding:0 20px;text-decoration: none;">
          <img src="/images/wallet_icon.png" width="30" height="30" />
          <span>کیف پول</span>
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
  <a href="{{route('landing')}}" style="text-decoration:none;"><span class="logo-title">همسود</span></a>
  <a href="{{route('landing')}}" style="cursor:pointer;float:left;">
      <img src="/images/logo.png" width="40" height="40" />
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
