@extends('layouts.backoffice')

@prepend('scripts')
    <script>
        $(function() {
            $("select[name=tax_state]").change(function() {

                var data = new Object();
                data.order_id = $(this).data("order_id");
                data.tax_state = $(this).val();
                var jsonData = JSON.stringify(data);

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('orders_taxstateChange') }}",
                    method: "POST",
                    dataType: "json",
                    data: {'data': jsonData},
                    success: function (data) {
                        var JSONArray = JSON.parse(JSON.stringify(data));

                        if (JSONArray['result'] == "success") {
                            alert('수정 되었습니다.');
                            location.reload();
                        } else if (JSONArray['result'] == "error") {
                            alert(JSONArray['error_message']);
                        };
                    },
                    error: function () {
                        alert("Error while getting results");
                    }
                });
            });
        });
    </script>
@endprepend

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-striped">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>주문번호</th>
                                        <th>구매내역</th>
                                        <th>구매날짜</th>
                                        <th>구매가격</th>
                                        <th>결제방식</th>
                                        <th>계산서 발행여부</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->order_no }}</td>
                                            <td>{{ $order->order_name }}</td>
                                            <td>{{ $order->updated_at }}</td>
                                            <td>{{ $order->total_price }}</td>
                                            <td>신용카드</td>
                                            <td>
                                                <select name="tax_state" data-order_id="{{ $order->id }}">
                                                    <option value="1" {{ $order->tax_state == '1' ? 'selected' : '' }}>계산서신청하기</option>
                                                    <option value="2" {{ $order->tax_state == '2' ? 'selected' : '' }}>확인중</option>
                                                    <option value="3" {{ $order->tax_state == '3' ? 'selected' : '' }}>계산서발급완료</option>
                                                </select>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
