@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{__("common.reservation_list")}}</div>
                    <div class="card-body">
                        <table class="table table-bordered table-responsive" id="datatable_tabletools">
                            <thead>
                            <tr>
                                <th >{{__("common.relationship_date")}}</th>
                                <th >{{__("common.title")}}</th>
                                <th >{{__("common.price_person")}}</th>
                                <th >{{__("common.popularity")}}</th>
                                <th >{{__("common.number_people")}}</th>
                                <th >{{__("common.total_price")}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        var otable;
        $(document).ready(function () {
            var urlAjax = "{{route("ativity_reservation.index")}}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            otable = $('#datatable_tabletools').DataTable({
                "aoColumns": [
                    {"mData": 'relationship_date', render: function (data, type, row, meta) {
                            if (row.price_person != '') {
                                const inputDate = new Date(row.relationship_date);
                                let date, month, year;
                                date = inputDate.getDate();
                                month = inputDate.getMonth() + 1; // take care of the month's number here ⚠️
                                year = inputDate.getFullYear();
                                return year + "-" + month + "-" + date;
                            } else {
                                return '';
                            }
                        }},
                    {"mData": 'activity.title'},
                    {"mData": 'activity.price_person', render: function (data, type, row, meta) {
                            if (row.activity.price_person != '') {
                                return '$ ' + parseFloat(row.activity.price_person).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                            } else {
                                return '';
                            }
                        }},
                    {"mData": 'activity.popularity'},
                    {"mData": 'number_people'},
                    {"mData": 'total_price', render: function (data, type, row, meta) {
                            if (row.total_price != '') {
                                return '$ ' + parseFloat(row.total_price).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                            } else {
                                return '';
                            }
                        }},
                ],
                "iDisplayLength": 10,
                "sAjaxSource": urlAjax,
                "sServerMethod": "POST",
                "sPaginationType": "full_numbers",
                "aaSorting": [[0, "desc"]],
                "autoWidth": true,
                responsive: true,
                dom: dataTableDom,
                "oLanguage": oLanguage,
            });
        });
    </script>
@endsection
