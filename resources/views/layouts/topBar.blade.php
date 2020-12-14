<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">{{env('APP_NAME')}}</a>
</div>

<!-- /.navbar-header -->
<ul class="nav navbar-top-links navbar-left">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span>{{auth()->user()->name}}</span> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li>
                <a href="{{route('users.changePassword', auth()->id())}}"><i class="fa fa-user fa-fw text-success"></i> پروفایل</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="#" onclick="logout()"><i class="fa fa-sign-out fa-fw text-danger"></i> خروج</a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->

<script>
    function logout() {
        event.preventDefault();

        swal({
            title: "آیا برای خروج اطمینان دارید؟",
            icon: "warning",
            buttons: ["انصراف", "خروج"],
            dangerMode: true,
        }).then((willExit) => {
            if (willExit)
                document.getElementById('logout-form').submit();
        });
    }
</script>
