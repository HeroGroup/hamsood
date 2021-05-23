<style>
hr {
    color:darkgray;
    margin:10px 0;
}
side-menu-item {
    padding:0 20px;
    text-decoration: none;
    color: #222;
}
    .new-message {
        border:1px solid #31AC6B;
        border-radius:5px;
        color:#31AC6B;
        padding:3px 6px;
        top:0;
        font-size:12px;
        float: left;
    }
.new-message:hover {
    background-color:#31AC6B;
    color:white;
}
</style>
<div id="myNav" class="overlay">
  <div class="overlay-content" style="margin-bottom:100px;">
    @if(session('mobile'))
      <img src="@if(isset($gender) && $gender=='male') /images/avatars/male.png @elseif(isset($gender) && $gender=='female') /images/avatars/female.png @else /images/user_default_image.png @endif" width="70" height="70" style="border-radius:50%;" />
      <p style="color:#222;padding:0; padding-top:10px;margin-bottom:0;">{{session('mobile')}}</p>
      @if(isset($profileCompleted) && !$profileCompleted)
      <a href="{{route('customers.profile')}}" class="btn btn-success" style="margin-top:10px;">تکمیل مشخصات</a>
      @else
      <span style="color:#222;">{{isset($name) ? $name : ''}}</span>
      @endif
      <div style="padding:0 20px; text-align:right; margin-bottom:30px;">
        <hr />
        <a href="{{route('customers.wallet')}}" class="side-menu-item">
          <img src="/images/wallet_icon.png" width="20" height="20" />
          <span>کیف پول</span>
          <span style="color:#222;font-size:12px;padding:3px 6px;border:1px solid lightgray;border-radius:5px;float:left;">موجودی {{number_format($balance)}} تومان</span>
        </a>
        <hr />
        <a href="{{route('customers.orders.current')}}" class="side-menu-item">
          <img src="/images/orders.png" width="20" height="20" />
          <span>سفارشات</span>
        </a>
        <hr />
        <a href="{{route('customers.addresses')}}" class="side-menu-item">
          <img src="/images/addresses.png" width="20" height="20" />
          <span>آدرس ها</span>
        </a>
        <hr />
        <a href="{{route('customers.notifications')}}" class="side-menu-item">
          <img src="/images/notifications_icon.png" width="15" height="15" />
          <span>پیام ها</span>
            @if(isset($newMessage) && $newMessage > 0)
                <span class="new-message">{{$newMessage}} پیام جدید</span>
            @endif
        </a>
        <hr />
        <a href="{{route('support')}}" class="side-menu-item">
          <img src="/images/support_icon.png" width="20" height="20" />
          <span>پشتیبانی</span>
        </a>
        <hr />
        <a href="{{route('about')}}" class="side-menu-item">
          <img src="/images/about_icon.png" width="20" height="20" />
          <span>درباره همسود</span>
        </a>
        <hr />
        <a href="{{route('customers.logout')}}" class="side-menu-item">
          <img src="/images/exit_icon.png" width="20" height="20" />
          <span>خروج</span>
        </a>
        <hr />
      </div>
    @else
    <img src="/images/not_entered.png" width="150" height="150" />
    <p style="color:#222;margin-top:80px;">شما هنوز وارد نشده اید</p>
    <div>
      <a class="btn btn-success" href="{{route('customers.login')}}" style="/*background-color:#008B44;*/width:150px;">ورود</a>
    </div>
    @endif
    <div style="margin-top:20px;">
        <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=211131&amp;Code=YKTlffSZfoa1xF2qvJQV">
            <img referrerpolicy="origin" id="YKTlffSZfoa1xF2qvJQV" src="https://Trustseal.eNamad.ir/logo.aspx?id=211131&amp;Code=YKTlffSZfoa1xF2qvJQV" alt="enamad" style="cursor:pointer">
        </a>
    </div>
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
