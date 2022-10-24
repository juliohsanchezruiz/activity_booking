@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("common.activity_finder")}}</div>
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
                                       placeholder="{{__("common.date")}}">
                            </div>
                            <div class="col-md-12">
                                <label for="number_people" class="form-label">{{__("common.number_people")}}</label>
                                <input type="text" class="form-control" id="number_people" name="number_people"
                                       placeholder="{{__("common.number_people")}}"
                                >
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
                    <div class="card-header">{{__("common.list_activity")}}</div>
                    <div class="card-body">
                        <table class="table table-bordered table-responsive" id="ajax-crud-datatable">
                            <thead>
                            <tr>
                                <th width="20%">{{__("common.title")}}</th>
                                <th width="20%">{{__("common.price_person")}}</th>
                                <th width="20%">{{__("common.popularity")}}</th>
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
                    <button type="button" class="btn-close close " data-dismiss="modal" aria-hidden="true"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="r_title" class="form-label"><b>{{__("common.title")}}:</b></label>
                        <div id="r_title"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_descrption" class="form-label"><b>{{__("common.price_person")}}:</b></label>
                        <div id="r_price_person"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_description" class="form-label"><b>{{__("common.description")}}:</b></label>
                        <div id="r_description"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_start_at" class="form-label"><b>{{__("common.number_people")}}:</b></label>
                        <div id="r_number_people"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_start_at" class="form-label"><b>Precio:</b></label>
                        <div id="r_price"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_start_at" class="form-label"><b>Fecha inicio:</b></label>
                        <div id="r_start_at"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="r_start_at" class="form-label"><b>Actividades Relacionadas:</b></label>
                        <table class="table table-bordered table-responsive" id="detalledatatable">
                            <thead>
                            <tr>
                                <th width="100%"><b>{{__("common.title")}}:</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
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
            $.validator.addMethod("dateFormat", function (value, element) {
                    const regex = /^\d{2}\/\d{2}\/\d{4}$/;
                    return value.match(regex);
                },
                "Please enter a date in the format dd-mm-yyyy.");
            $('.datepicker').datepicker({
                language: 'es',
                autoclose: true,
                format: 'dd/mm/yyyy',
                startDate: new Date(),
            });
            $('#datepicker').datepicker({
                language: 'es',
                autoclose: true,
                format: 'dd/mm/yyyy',
                startDate: new Date(),
            });
            $("#resultd").hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var columns = [
                {"mData": 'title'},
                {
                    "mData": "price_person", render: function (data, type, row, meta) {
                        if (row.price_person != '') {
                            return '$ ' + parseFloat(row.price_person).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        } else {
                            return '';
                        }
                    }
                },
                {"mData": 'popularity', searchable: false,},
                {"mData": "detail", sortable: false, searchable: false,},
                {"mData": "contract", sortable: false, searchable: false,},
            ];

            dataResultado = $('#ajax-crud-datatable').DataTable({
                "aoColumns": columns,
                "autoWidth": true,
                responsive: true,
                "aaSorting": [[2, "desc"]],
                dom: dataTableDom,
                buttons: buttons,
                "oLanguage": oLanguage,
            });
            // validate the form when it is submitted
            var $orderForm = $("#search_activity").validate({
                rules: {
                    search_date: {
                        required: true,
                        dateFormat: true
                    },
                    number_people: {
                        required: true,
                        number: true,
                        min: 1
                    },
                },
                messages: {
                    search_date: {
                        required: "Favor de introducir una <b style=\"color:#780000;\">{{__("common.date")}}</b> correcto",
                        dateFormat: "Favor de introducir una <b style=\"color:#780000;\">{{__("common.date")}} en formato dd/mm/yyyy</b>",
                    },
                    number_people: {
                        required: "Favor de introducir una <b style=\"color:#780000;\">{{__("common.number_people")}}</b> correcto",
                        number: "Favor de introducir un <b style=\"color:#780000;\">Numero</b>",
                        min: "Favor de introducir una <b style=\"color:#780000;\">número mayor a cero</b>",
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
                save(id, number_people)
            });
            $(document).delegate('#save', 'click', function () {
                var id = $("#r_id").val();
                var number_people = $("#number_people").val();
                $('#staticBackdrop').modal('hide');
                save(id, number_people);
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
                    $('#staticBackdrop').modal({show: true});
                    $("#r_title").html(item.title);
                    $("#r_description").html(item.description);
                    var price_person = '$ ' + parseFloat(item.price_person).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    $("#r_price_person").html(price_person);
                    var number_people = $("#number_people").val();
                    var r_price = '$ ' + parseFloat(number_people * item.price_person).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
                    $("#r_number_people").html(number_people);
                    $("#r_price").html(r_price);
                    $("#r_start_at").html(item.start_at);
                    $("#r_id").val(item.id);
                    var search_date = $("#search_date").val();
                    const inputDate = new Date(search_date);
                    let date, month, year;
                    date = inputDate.getDate();
                    month = inputDate.getMonth() + 1; // take care of the month's number here ⚠️
                    year = inputDate.getFullYear();
                    const html = item.activities.map(function (item) {
                        const inputDate1 = new Date(item.activity.start_at);
                        let date1, month1, year1;
                        date1 = inputDate1.getDate();
                        month1 = inputDate1.getMonth() + 1; // take care of the month's number here ⚠️
                        year1 = inputDate1.getFullYear();
                        if (year + "-" + month + "-" + date < year1 + "-" + month1 + "-" + date1) {
                            return "<tr> <td>" + item.activity.title + "</td></tr>";
                        }
                    });
                    if (html.length === 0) {
                        $("#detalledatatable > tbody").html("<tr> <td class='alert-warning table-warning'>No hay actividades relacionadas</td></tr>");
                    } else {
                        $("#detalledatatable > tbody").html(html.join());
                    }

                });
                request.fail(function (res) {
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
                if ($("#search_activity").valid()) {
                    dataResultado.clear()
                        .draw();
                    let urlAjax = $("#search_activity").attr("action");
                    var search_date = $("#search_date").val();
                    let newDate = search_date.split("/");
                    const inputDate = new Date(newDate[2] + "-" + newDate[1] + "-" + newDate[0]);
                    let date, month, year;

                    date = inputDate.getDate();
                    month = inputDate.getMonth() + 1; // take care of the month's number here ⚠️
                    year = inputDate.getFullYear();
                    console.log(year + "-" + month + "-" + date);
                    var request = $.ajax({
                        url: urlAjax,
                        type: "POST",
                        dataType: "json",
                        data: {
                            search_date: newDate[2] + "-" + newDate[1] + "-" + newDate[0],
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
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'No existe ningun registro',
                            })
                        }
                    });
                }
            });

            function save(id, number_people) {
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
