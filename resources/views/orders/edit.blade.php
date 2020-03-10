@extends('layouts.backoffice')

@prepend('scripts')
    $(function() {
        $("#expiration_date").datepicker({
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
            ,minDate: new Date() //최소 선택일자(-1D:하루전, -1M:한달전, -1Y:일년전)
        });
    });
@endprepend

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> No. {{ $order['order_id'] }}
                            <div class="card-body">
                                <h5>광고주:</h5>
                                <p> {{ $order['advertiser'] }}</p>
                                <h5>플랫폼 유형:</h5>
                                <p> {{ $order['data_types'] }}</p>
                                <h5>데이터명:</h5>
                                <p> {{ $order['data_name'] }}</p>
                                <h5>데이터항목:</h5>
                                <p> {{ $order['data_category'] }}</p>
                                <h5>설명:</h5>
                                <p> {!! $order['data_content'] !!} </p>
                                <form method="POST" action="{{ route('orders.update', $order['order_id']) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                        <div class="col">
                                            <label>상태</label>
                                            <select class="form-control" name="state">
                                                <option value="1" {{ $order['state'] == '1' ? 'selected' : '' }} >요청중</option>
                                                <option value="2" {{ $order['state'] == '2' ? 'selected' : '' }} >추출중</option>
                                                <option value="3" {{ $order['state'] == '3' ? 'selected' : '' }} >승인요청</option>
                                                <option value="5" {{ $order['state'] == '4' ? 'selected' : '' }} >결제완료</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col">
                                            <label>데이터 수</label>
                                            <input class="form-control" type="text" placeholder="data_count" name="data_count" value="{{ $order['data_count'] }}"  autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col">
                                            <label>데이터 가격</label>
                                            <input class="form-control" type="text" placeholder="buy_price" name="buy_price" value="{{ $order['buy_price'] }}"  autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label>유효기간</label>
                                            <input class="form-control" type="text" placeholder="expiration_date" id="expiration_date" name="expiration_date"  value="{{ $order['expiration_date'] }}"  autofocus>
                                        </div>
                                    </div>

                                    <button class="btn btn-block btn-success" type="submit">Save</button>
                                    <a href="{{ route('orders.index') }}" class="btn btn-block btn-primary">Return</a>
                                </form>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
