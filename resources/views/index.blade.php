@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Buscar actividad</div>
                    <div class="card-body">
                        <form method="post" name="search_activity" id="search_activity"
                              autocomplete="off"
                              action="{{route("activity.index")}}"
                              class="row g-3"
                        >
                            <div class="col-md-12">
                                <label for="search_date" class="form-label">{{__("common.date")}}</label>
                                <input type="text" id='search_date' name='search_date' maxlength='20'
                                       class="form-control datepicker"
                                       value=""
                                       placeholder="Fecha">
                            </div>
                            <div class="col-md-12">
                                <label for="number_people" class="form-label">{{__("common.number_people")}}</label>
                                <input type="text" class="form-control" id="number_people" name="number_people">
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary ml-auto"
                                        id="guardar">{{__("common.search")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8" id="resultd" style="display: none">
                <div class="card">
                    <div class="card-header">Result</div>
                    <div class="card-body">
                        <table class="table table-bordered table-responsive" id="ajax-crud-datatable">
                            <thead>
                            <tr>
                                <th>poularidad</th>
                                <th width="30%">{{__("common.title")}}</th>
                                <th width="40%">{{__("common.price_person")}}</th>
                                <th width="20%">{{__("common.detail")}}</th>
                                <th width="20%">{{__("common.action")}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" id="r_id" name="r_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Detalle actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="r_title" class="form-label">{{__("common.title")}}</label>
                        <div id="r_title"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_descrption" class="form-label">{{__("common.price_person")}}</label>
                        <div id="r_price_person"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_description" class="form-label">{{__("common.description")}}</label>
                        <div id="r_description"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_start_at" class="form-label">{{__("common.number_people")}}</label>
                        <div id="r_number_people"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_start_at" class="form-label">Precio</label>
                        <div id="r_price"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_start_at" class="form-label">Fecha inicio</label>
                        <div id="r_start_at"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_start_at" class="form-label">Actividades Relacionadas</label>
                        <table class="table table-bordered table-responsive" id="detalledatatable">
                            <thead>
                            <tr>
                                <th width="100%">{{__("common.title")}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save">Comprar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        var dataResultado;
        $(document).ready(function () {
            $('.datepicker').datepicker();
            $('#datepicker').datepicker();
            $("#resultd").hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var columns = [
                {"mData": 'popularity', searchable: false,},
                {"mData": 'title'},
                {"mData": "price_person"},
                {"mData": "detail", sortable: false, searchable: false,},
                {"mData": "contract", sortable: false, searchable: false,},
            ];

            dataResultado = $('#ajax-crud-datatable').DataTable({
                "aoColumns": columns,
                "autoWidth": true,
                responsive: true,
                "aaSorting": [[0, "desc"]],
                dom: dataTableDom,
                buttons: buttons,
                "oLanguage": oLanguage,
                columnDefs: [
                    {
                        target: 0,
                        visible: false,
                        searchable: false,
                    }
                ],
            });
            // validate the form when it is submitted
            var $orderForm = $("#search_activity").validate({
                rules: {
                    search_date: {
                        required: true,
                    },
                    number_people: {
                        required: true,
                    },
                },
                messages: {
                    search_date: {
                        required: "Favor de introducir una <b style=\"color:#780000;\">Fecha</b> correcto",
                    },
                    number_people: {
                        required: "Favor de introducir una <b style=\"color:#780000;\">Fecha</b> correcto",
                    },
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element.parent());
                },
                submitHandler: function (form) {

                }
            });
            $(document).delegate('.booker', 'click', function () {
                var id = $(this).data("id");
                var number_people = $("#number_people").val();
                save(id,number_people)
            });
            $(document).delegate('#save', 'click', function () {
                var id = $("#r_id").val();
                var number_people = $("#number_people").val();
                $('#staticBackdrop').modal('hide');
                save(id,number_people);
            });
            $(document).delegate('.detail', 'click', function () {
                var id = $(this).data("id");
                var url = "{{route('activity.show',0)}}";
                var urlPath = url.replace("/0", "/" + id);
                var request = $.ajax({
                    url: urlPath,
                    type: "GET",
                    dataType: "json",
                });
                request.done(function (res) {
                    var item = res.data;
                    $('#staticBackdrop').modal({show:true});
                    $("#r_title").html(item.title);
                    $("#r_description").html(item.description);
                    $("#r_price_person").html(item.price_person);
                    var number_people = $("#number_people").val();
                    $("#r_number_people").html(number_people);
                    $("#r_price").html(number_people*item.price_person);
                    $("#r_start_at").html(item.start_at);
                    $("#r_id").val(item.id);
                    var search_date = $("#search_date").val();
                    const inputDate = new Date(search_date);
                    let date, month, year;
                    date = inputDate.getDate();
                    month = inputDate.getMonth() + 1; // take care of the month's number here ⚠️
                    year = inputDate.getFullYear();
                    const html = item.activities.map(function(item) {


                        const inputDate1 = new Date(item.activity.start_at);
                        let date1, month1, year1;
                        date1 = inputDate1.getDate();
                        month1 = inputDate1.getMonth() + 1; // take care of the month's number here ⚠️
                        year1 = inputDate1.getFullYear();
                        console.log(year + "-" + month + "-" + date< item.activity.start_at);
                        console.log(year + "-" + month + "-" + date);
                        console.log( year1 + "-" + month1 + "-" + date1);
                        if(year + "-" + month + "-" + date< year1 + "-" + month1 + "-" + date1) {
                            return "<tr> <td>" + item.activity.title + "</td></tr>";
                        }
                    });
                    console.log(html);
                    $("#detalledatatable > tbody").html(html.join());
                });
                request.fail(function (res) {
                    console.log(res);
                    var message = res.message;
                    $.toast({
                        heading: 'Error',
                        text: message,
                        showHideTransition: 'fade',
                        icon: 'error'
                    })
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'message',
                    })
                });
            });
            $("#guardar").click(function () {
                console.log($("#search_activity").valid());
                if ($("#search_activity").valid()) {
                    dataResultado.clear()
                        .draw();
                    let urlAjax = $("#search_activity").attr("action");
                    console.log(urlAjax);
                    var search_date = $("#search_date").val();
                    const inputDate = new Date(search_date);
                    let date, month, year;

                    date = inputDate.getDate();
                    month = inputDate.getMonth() + 1; // take care of the month's number here ⚠️
                    year = inputDate.getFullYear();
                    var request = $.ajax({
                        url: urlAjax,
                        type: "POST",
                        dataType: "json",
                        data: {
                            search_date: year + "-" + month + "-" + date,
                        }
                    });
                    request.done(function (res) {
                        var data = res.data;
                        if (data.length > 0) {
                            $("#resultd").show();
                            $('#ajax-crud-datatable').css("width", "100%")
                            data.forEach(function (item) {
                                var rowNode = dataResultado.row.add({
                                    "popularity": item.popularity,
                                    "title": item.title,
                                    "price_person": item.price_person,
                                    "detail": "<button class='btn btn-info detail' data-id='" + item.id + "' >{{__("common.detail")}}</button>",
                                    "contract": "<button class='btn btn-success booker' data-id='" + item.id + "'data-date='" + item.start_at + "' >{{__("common.reservation")}}</button>",
                                }).draw()
                                    .node();

                            });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'No existe ningun registro',
                            })
                        }
                    });
                }
            });
            function save(id,number_people) {
                Swal.fire({
                    title: "{{__("common.add_activity")}}",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{__("common.accept")}}"
                }).then(function (result) {
                    if (result.value) {
                        var url = "{{route('activity_reservation.store',0)}}";
                        var urlPath = url.replace("/0/", "/" + id + "/");
                        var request = $.ajax({
                            url: urlPath,
                            type: "POST",
                            dataType: "json",
                            data: {
                                number_people: number_people,
                            }
                        });
                        request.done(function (res) {
                            var message = res.message;
                            Swal.fire({
                                icon: 'success',
                                title: message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        });
                        request.fail(function (res) {
                            console.log(res);
                            var message = res.message;
                            $.toast({
                                heading: 'Error',
                                text: message,
                                showHideTransition: 'fade',
                                icon: 'error'
                            })
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'message',
                            })
                        });
                    }
                });
            }
        });
    </script>
@endsection
