<div id="myNav" class="overlay">
  <div class="overlay-content">
    @if(session('mobile'))
      <img src="/images/user_default_image.png" width="100" height="100" />
      <p style="color:#222;padding: 10px 0;">{{session('mobile')}}</p>
      <div style="padding:0 20px; text-align:right; margin-bottom:100px;">
        <hr style="color:darkgray" />
        <a href="{{route('customers.orders')}}" style="padding:0 20px;text-decoration: none;">
          <img src="/images/orders.png" width="30" height="30" />
          <span>سفارشات</span>
        </a>
        <hr style="color:darkgray" />
        <a href="{{route('customers.addresses')}}" style="padding:0 20px;text-decoration: none;">
          <img src="/images/addresses.png" width="30" height="30" />
          <span>آدرس ها</span>
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
  <span class="logo-title">همسود</span>
  <img src="/images/logo.png" width="45" height="45" style="float:left;" />
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
