<div id="myNav" class="overlay">
  <div class="overlay-content">
    @if(session('mobile'))
    <p>name</p>
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
