@extends('layouts.backoffice')

@prepend('scripts')
    <script>
        $(function() {
            $(".sch1, .sch2").datepicker({
                dateFormat: 'yy-mm-dd' //Input Display Format 변경
                ,showOtherMonths: true //빈 공간에 현재월의 앞뒤월의 날짜를 표시
                ,showMonthAfterYear:true //년도 먼저 나오고, 뒤에 월 표시
                ,changeYear: true //콤보박스에서 년 선택 가능
                ,changeMonth: true //콤보박스에서 월 선택 가능
                ,buttonImageOnly: true //기본 버튼의 회색 부분을 없애고, 이미지만 보이게 함
                ,buttonText: "선택" //버튼에 마우스 갖다 댔을 때 표시되는 텍스트
                ,yearSuffix: "년" //달력의 년도 부분 뒤에 붙는 텍스트
                ,monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'] //달력의 월 부분 텍스트
                ,monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] //달력의 월 부분 Tooltip 텍스트
                ,dayNamesMin: ['일','월','화','수','목','금','토'] //달력의 요일 부분 텍스트
                ,dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'] //달력의 요일 부분 Tooltip 텍스트
            });

            $("select[name=sch_key]").change(function() {
                console.log($(this).val());
                if ($(this).val() == "created_at") {
                    $("#input").css("display", "none");
                    $("#input1-group1").css("display", "block");
                    $("#input_span").css("display", "block");
                    $("#input2-group2").css("display", "block");
                } else {
                    $("#input").css("display", "block");
                    $("#input1-group1").css("display", "none");
                    $("#input_span").css("display", "none");
                    $("#input2-group2").css("display", "none");
                }
            });

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
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ number_format($order->total_price) }}</td>
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
                                <div class="col-sm-4 " style="margin: auto">
                                    <form class="form-horizontal" action="{{ route($route_name) }}" method="GET">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <select name="sch_key">
                                                        <option value="order_no" {{ ($sch_key=="order_no") ? "selected" : ""  }}  >주문번호</option>
                                                        <option value="order_name" {{ ($sch_key=="order_name") ? "selected" : ""  }} >구매내역</option>
                                                        <option value="created_at" {{ ($sch_key=="created_at") ? "selected" : ""  }} >구매날짜</option>
                                                    </select>&nbsp;
                                                    <input class="form-control" id="input" type="text" name="sch" value="{{ $sch }}" placeholder="검색어" autocomplete="sch" style="display: {{ ($sch_key=="created_at") ? "none;" : "block;"  }}"  >
                                                    <input class="form-control sch1" id="input1-group1" type="text" name="sch1" value="{{ $sch1 }}" placeholder="검색어" autocomplete="sch" style="display: {{ ($sch_key=="created_at") ? "block;" : "none;"  }}" >
                                                    &nbsp;<span id="input_span" style="display: {{ ($sch_key=="created_at") ? "block;" : "none;"  }}">~</span>&nbsp;
                                                    <input class="form-control sch2" id="input2-group2" type="text" name="sch2" value="{{ $sch2 }}" placeholder="검색어" autocomplete="sch" style="display: {{ ($sch_key=="created_at") ? "block;" : "none;"  }}" >
                                                    <span class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">검색</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
