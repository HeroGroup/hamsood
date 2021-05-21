<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="مدیریت همسود">
    <meta name="author" content="Navid Hero">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | {{$pageTitle}}</title>

    <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
    <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
    <link href="/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="/css/rtl/sb-admin-2.css" rel="stylesheet">
    <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/my.css" rel="stylesheet" type="text/css">
    <link href="/css/admin.css" rel="stylesheet" type="text/css">
    <link href="/css/jquery.timepicker.css" rel="stylesheet" type="text/css">
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">
    <link href="/css/jquery.dataTables.css" rel="stylesheet">

    <script src="/js/jquery-1.11.0.js" type="text/javascript"></script>

    <script src="/js/selectize.min.js"></script>
    <link rel="stylesheet" href="/css/selectize.bootstrap3.min.css" />

</head>
<body>

    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include('layouts.topBar')
            @include('layouts.sidebar')
        </nav>

        <div id="page-wrapper">

            <!-- Page Heading -->

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        {{$pageTitle}}
                        @if(isset($newButton) && $newButton)
                            <a class="pull-left btn btn-primary" href="{{$newButtonUrl}}">
                                <i class="fa fa-fw fa-plus"></i> {{$newButtonText}}
                            </a>
                        @endif
                    </h1>
                </div>
            </div>

            @if(\Illuminate\Support\Facades\Session::has('message'))
                @component('components.alert', [
                    'message' => \Illuminate\Support\Facades\Session::get('message'),
                    'type' => \Illuminate\Support\Facades\Session::get('type')])
                @endcomponent
            @endif

            @yield('content')

        </div>
    </div>

    <script src="/js/jquery.timepicker.js" type="text/javascript"></script>
    <script src="/js/datepair.js" type="text/javascript"></script>
    <script src="/js/popper.min.js" type="text/javascript"></script>
    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/metisMenu/metisMenu.min.js" type="text/javascript"></script>
    <script src="/js/sb-admin-2.js" type="text/javascript"></script>
    <script src="/js/sweetalert.min.js" type="text/javascript"></script>
    <script src="/js/persian-date.min.js"></script>
    <script src="/js/persian-datepicker.min.js"></script>
    <script src="/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.custom_date_picker').pDatepicker({
                initialValue: new persianDate(),
                format: 'YYYY/MM/DD',
                autoClose: true,
                // minDate: new persianDate()
            });

            $('.data-table').DataTable({
                pageLength: 25,
                language: {
                    "decimal":        "",
                    "emptyTable":     "رکوردی وجود ندارد.",
                    "info":           "نمایش  _START_ تا _END_ از _TOTAL_ ردیف",
                    "infoEmpty":      "نمایش 0 تا 0 از 0 رکورد",
                    "infoFiltered":   "(فیلتر شده از مجموع _MAX_ ردیف)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "نمایش _MENU_ ردیف",
                    "loadingRecords": "در حال بارگزاری...",
                    "processing":     "در حال پردازش...",
                    "search":         "جستجو: ",
                    "zeroRecords":    "هیچ رکوردی پیدا نشد.",
                    "paginate": {
                        "first":      "اولین",
                        "last":       "آخرین",
                        "next":       "بعدی",
                        "previous":   "قبلی"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
            });

            $('.current').css({"color":"black !important"});
        });

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function createPDF(table) {
            var sTable = document.getElementById(table).innerHTML;

            var style = "<style>";
            style = style + "table {width: 100%;}";
            style = style + "table, th, td {border: solid 1px #DDD;border-collapse:collapse;padding:2px 3px;text-align:center;direction:rtl;}";
            style = style + "</style>";

            // CREATE A WINDOW OBJECT.
            var win = window.open('', '', 'height=700,width=1100');

            win.document.write('<html><head>');
            win.document.write('<title>گزارش</title>');   // <title> FOR PDF HEADER.
            win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
            win.document.write('</head>');
            win.document.write('<body><table>');
            win.document.write(sTable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
            win.document.write('</table></body></html>');

            win.document.close(); 	// CLOSE THE CURRENT WINDOW.

            win.print();    // PRINT THE CONTENTS.
        }

        function openModal(id) {
            $(`#custom-modal-${id}`).css({"display": "block"});
        }

        $(".custom-close").on("click", function() {
            $(".custom-modal").css({"display": "none"});
        });

        $('select:not(select[name=DataTables_Table_0_length])').selectize({
            sortField: 'text'
        });
    </script>
</body>
</html>
