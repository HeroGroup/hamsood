<td>
    @if(isset($routeChangeStatus))
        <a href="{{ $routeChangeStatus }}" class="btn btn-xs btn-success" data-toggle="tooltip" title="تغییر وضعیت">
            تغییر وضعیت
        </a>
        &nbsp;
    @endif
    @if(isset($routeEdit))
        <a href="{{ $routeEdit }}" class="btn btn-xs btn-info" data-toggle="tooltip" title="ویرایش">
            <i class="fa fa-pencil"></i> ویرایش
        </a>
        &nbsp;
    @endif
    @if(isset($routeHistory))
        <a href="{{ $routeHistory }}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="تاریخچه">
            <i class="fa fa-history"></i> تاریخچه
        </a>
        &nbsp;
    @endif
    @if(isset($routeDevices))
        <a href="{{ $routeDevices }}" class="btn btn-xs btn-success" data-toggle="tooltip" title="دستگاه ها">
            <i class="fa fa-laptop"></i> دستگاه ها
        </a>
        &nbsp;
    @endif
    @if(isset($routePatterns))
        <a href="{{ $routePatterns }}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="الگوی مصرف">
            <i class="fa fa-clock-o"></i> الگوی مصرف
        </a>
        &nbsp;
    @endif
    @if(isset($routeDetails))
        <a href="{{ $routeDetails }}" class="btn btn-xs btn-info" data-toggle="tooltip" title="نمایش جزئیات">
             نمایش جزئیات
        </a>
        &nbsp;
    @endif
    @if(isset($routeDelete))
        <form id="destroy-form-{{$itemId}}" method="post" action="{{$routeDelete}}" style="display:none">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        </form>
        <button onclick='destroy({{$itemId}});' class="btn btn-xs btn-danger" data-toggle="tooltip" title="حذف">
            <i class="fa fa-trash-o"></i> حذف
        </button>
        &nbsp;
    @endif
</td>

<script>
    function destroy(itemId) {
        event.preventDefault();

        swal({
            title: "آیا این ردیف حذف شود؟",
            text: "توجه داشته باشید که عملیات حذف غیر قابل بازگشت می باشد.",
            icon: "warning",
            buttons: ["انصراف", "حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('destroy-form-'+itemId).submit();
            }
        });
    }
</script>
