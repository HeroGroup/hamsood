@extends('layouts.admin', ['pageTitle' => 'ساعت و هزینه ارسال'])
@section('content')
    <style>
        .error {
            border:3px solid red;
            border-radius:3px;
        }
        .swal-text {
            text-align: initial;
        }
    </style>
    <div class="row" id="alarm-container" style="display: none;">
        <div class="col-lg-12">
            <div class="page-header alert alert-danger alert-dismissible show" role="alert" style="vertical-align: center">
                <span id="alert-message"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    <div class="container-fluid table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ساعت شروع</th>
                <th>ساعت پایان</th>
                <th>هزینه ارسال</th>
                <th>هزینه ارسال با تخفیف</th>
                <th>
                    <button type="button" class="btn btn-primary pull-left" onclick="add()"><i class="fa fa-plus"></i></button>
                </th>
            </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>
    <div class="col-sm-12 text-left">
        <button type="button" onclick="save()" class="btn btn-success"><i class="fa fa-fw fa-save"></i> ذخیره</button>
    </div>
    <script>

        var id=0;
        function add() {
            var row = `
                <tr id='${id}'>
                    <td>{!! Form::select('start_time_${id}', config('enums.hours'), null, array('class' => 'form-control', 'placeholder' => 'انتخاب کنید ...')) !!}</td>
                    <td>{!! Form::select('end_time_${id}', config('enums.hours'), null, array('class' => 'form-control', 'placeholder' => 'انتخاب کنید ...')) !!}</td>
                    <td><input type="text" name="delivery_fee_${id}" class="form-control" placeholder="هزینه ارسال" /></td>
                    <td><input type="text" name="delivery_fee_for_now_${id}" class="form-control" placeholder="هزینه ارسال با تخفیف" /></td>
                    <td><button type='button' class='btn btn-danger pull-left' onclick='document.getElementById(${id}).remove()'><i class='fa fa-remove'></i></button></td>
                </tr>`;

            $("#table-body").append(row);

            id++;
        }

        function save() {
            var error = false, errorMessage="";

            var result = [], count = 0;
            $("#table-body tr").each(function (index) {
                count++;
                $(this).removeClass('error');

                var id = $(this).attr("id"),
                    start = $(`select[name=start_time_${id}]`).val(),
                    end = $(`select[name=end_time_${id}]`).val(),
                    fee = $(`input[name=delivery_fee_${id}]`).val(),
                    feeNow = $(`input[name=delivery_fee_for_now_${id}]`).val();


                if (!start || !end || !fee) {
                    $(this).addClass('error');
                    error = true;
                    return;
                }

                result.push({start, end, fee, feeNow});
            });

            if (count > 0) {
                if (error) {
                    if (errorMessage.length > 0)
                        swal(errorMessage, "", "warning");

                    return;
                } else {
                    $.ajax('/admin/deliveries', {
                        method: 'post',
                        data: {
                            _token: "{{csrf_token()}}",
                            data: JSON.stringify(result)
                        },
                        success: function (response) {
                            if (response.status === 1) {
                                swal({
                                    title: "",
                                    text: response.message,
                                    type: "success"
                                }).then(function() {
                                    window.location.href = "{{route('deliveries.index')}}";
                                });
                            } else {
                                $("#alarm-container").css({"display":"flex"});
                                $(".row").css({"visibility":"visible"});
                                $(".alert-dismissible").removeClass('alert-success');
                                $(".alert-dismissible").addClass('alert-danger');
                                $("#alert-message").text(response.message);
                            }
                        }
                    });
                }
            } else {
                swal("هیچ ردیفی درج نشده است.", "", "warning");
            }
        }
    </script>
@endsection
