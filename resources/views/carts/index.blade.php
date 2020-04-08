@extends('layouts.backoffice')

@prepend('scripts')
    <script src="{{ asset('/js/tooltips.js') }}"></script>
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
                if ($(this).val() == "buy_date") {
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

            $("button[name='btn']").click(function() {

                var data = new Object();
                data.cart_id = $(this).data("cart_id");
                var jsonData = JSON.stringify(data);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('cart.find.id') }}",
                    method: "POST",
                    dataType: "json",
                    data: {'data': jsonData},
                    success: function (data) {
                        var JSONArray = JSON.parse(JSON.stringify(data));

                        if (JSONArray['result'] == "success") {
                            console.log(JSONArray['casrt_info']);
                            $("input[name='advertiser']").val(JSONArray['casrt_info'][0]['goods_id']['advertiser']);
                            $("input[name='data_name']").val(JSONArray['casrt_info'][0]['goods_id']['data_name']);
                            $("input[name='data_request']").val(JSONArray['casrt_info'][0]['goods_id']['data_request']);
                            // $("input[name='data_category']").val(JSONArray['casrt_info'][0]['goods_id']['data_category']);
                            $("[name='data_content']").val(JSONArray['casrt_info'][0]['goods_id']['data_content']);
                            $("select[name='state']").val(JSONArray['casrt_info'][0]['state']).attr("selected", "selected");
                            $("input[name='data_count']").val(JSONArray['casrt_info'][0]['goods_id']['data_count']);
                            $("input[name='buy_price']").val(JSONArray['casrt_info'][0]['goods_id']['buy_price']);
                            $("input[name='expiration_date']").val(JSONArray['casrt_info'][0]['goods_id']['expiration_date']);
                            $("[name='memo']").val(JSONArray['casrt_info'][0]['memo']);

                            if (JSONArray['casrt_info'][0]['state'] == "4") {
                                $("#file_row").css("display", "block");
                            }
                            if (JSONArray['casrt_info'][0]['goods_id']['data_files']) {
                                $("#file_name_row").css("display", "block");
                                $("#file_name").text(JSONArray['casrt_info'][0]['goods_id']['org_files']);
                            } else {
                                $("#file_name_row").css("display", "none");
                            }

                            //$("#modelForm").attr("action", "cart/"+JSONArray['casrt_info'][0]['goods_id']['id']);
                            $("form[name='frm']").attr("action", "cart/"+JSONArray['casrt_info'][0]['goods_id']['id']);
                            $('#largeModal').modal('show');
                        } else if (JSONArray['result'] == "error") {
                            alert(JSONArray['error_message']);
                        };
                    },
                    error: function () {
                        alert("Error while getting results");
                    }
                });
                //$('#largeModal').modal('show')
            });

            $("select[name=cart_state]").change(function() {
                var data = new Object();
                data.cart_id = $(this).data("cart_id");
                data.states = $(this).val();
                var jsonData = JSON.stringify(data);

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('carts_statechange') }}",
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

            $("select[name=option_state]").change(function() {
                var data = new Object();
                data.option_id = $(this).data("option_id");
                data.states = $(this).val();
                var jsonData = JSON.stringify(data);

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('options_statechange') }}",
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
                            @if (Route::current()->getActionMethod() === "index")
                                전체
                            @elseif (Route::current()->getActionMethod() === "cart_state_1")
                                결제대기중
                            @elseif (Route::current()->getActionMethod() === "cart_state_2")
                                결제완료
                            @elseif (Route::current()->getActionMethod() === "cart_state_3")
                                데이터추출중
                            @elseif (Route::current()->getActionMethod() === "cart_state_4")
                                데이터추출완료
                            @elseif (Route::current()->getActionMethod() === "option_state_1")
                                업로드대기
                            @elseif (Route::current()->getActionMethod() === "option_state_2")
                                업로드요청
                            @elseif (Route::current()->getActionMethod() === "option_state_3")
                                업로드완료
                            @endif
                        </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm ">
                                    <colgroup>
                                        <col width="20px">
                                        <col width="">
                                        <col width="">
                                        <col width="80px">
                                        <col width="80px">
                                        <col width="120px">
                                        <col width="120px">
                                        <col width="90px">
                                        <col width="90px">
                                        <col width="90px">
                                        <col width="40px">
                                        <col width="70px">
                                    </colgroup>

                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>광고주</th>
                                        <th>데이터명</th>
                                        <th>데이터<br/>추출수</th>
                                        <th>구매가격</th>
                                        <th>구매일</th>
                                        <th>유효기간</th>
                                        <th>요청횟수</th>
                                        <th>업로드<br/>파일</th>
                                        <th>메모</th>
                                        <th>상태</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($carts as $cart)
                                        <tr style="background:rgba(0, 0, 21, 0.05)">
                                            <td>{{ $cart->goods->id }}</td>
                                            <td>{{ $cart->goods->advertiser }}</td>
                                            <td>{{ $cart->goods->data_name }}</td>
                                            <td>{{ number_format($cart->goods->data_count) }}</td>
                                            <td>{{ number_format($cart->goods->buy_price) }}</td>
                                            <td>{{ $cart->buy_date }}</td>
                                            <td>{{ $cart->goods->expiration_date }}</td>
                                            <td>{{ $cart->goods->data_request }}</td>
                                            <td>
                                                @if ($cart->goods->org_files)
                                                    <a class="btn btn-secondary btn-sm" href="{{ route('file_download', [$cart->goods->data_files,$cart->goods->org_files]) }}">다운로드</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($cart->memo)
                                                    <button class="btn btn-secondary btn-sm" type="button" data-placement="bottom" data-toggle="tooltip" data-html="true" title="" data-original-title="{{ $cart->memo }}">메모보기</button>
                                                @endif
                                            </td>
                                            <td>
                                                <select name="cart_state" data-cart_id="{{ $cart->goods->id }}">
                                                    <option value="1" {{ $cart->state == '1' ? 'selected' : '' }}>확인중</option>
                                                    <option value="2" {{ $cart->state == '2' ? 'selected' : '' }}>결제대기중</option>
                                                    <option value="3" {{ $cart->state == '3' ? 'selected' : '' }}>결제완료</option>
                                                    <option value="4" {{ $cart->state == '4' ? 'selected' : '' }}>데이터추출중</option>
                                                    <option value="5" {{ $cart->state == '5' ? 'selected' : '' }}>데이터추출완료</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button class="btn btn-block btn-success btn-sm" type="button" name="btn" data-cart_id="{{ $cart->goods->id }}"  >수정</button>
                                            </td>
                                        </tr>
                                        @if (!$cart->options->isEmpty())
                                            <tr>
                                                <td colspan="12" style="padding: 0">
                                                    <table class="table table-responsive-sm ">
                                                        <colgroup>
                                                            <col width="50px">
                                                            <col width="">
                                                            <col width="">
                                                            <col width="230px">
                                                            <col width="300px">
                                                            <col width="138px">
                                                            <col width="70px">
                                                        </colgroup>
{{--                                                        <thead>--}}
{{--                                                        <tr>--}}
{{--                                                            <th></th>--}}
{{--                                                            <th>대상플랫폼</th>--}}
{{--                                                            <th>대상플랫폼 URL</th>--}}
{{--                                                            <th>아이디</th>--}}
{{--                                                            <th>비밀번호</th>--}}
{{--                                                            <th>상태</th>--}}
{{--                                                            <th></th>--}}
{{--                                                        </tr>--}}
{{--                                                        </thead>--}}
                                                        <tbody>
                                                            @foreach($cart->options as $option)
                                                            <tr>
                                                                <td></td>
                                                                <td>{{$option->platform['name']}}</td>
                                                                <td>{{$option->platform['url']}}</td>
                                                                <td>ID : {{$option->sns_id}}</td>
                                                                <td>PASSWORD : {{$option->sns_password}}</td>
                                                                <td>
                                                                    <select name="option_state" data-option_id="{{ $option->id }}">
                                                                        <option value="1" {{ $option->state == '1' ? 'selected' : '' }}>대기</option>
                                                                        <option value="2" {{ $option->state == '2' ? 'selected' : '' }}>업로드요청</option>
                                                                        <option value="3" {{ $option->state == '3' ? 'selected' : '' }}>업로드완료</option>
                                                                    </select>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                       <tr>
                                           <td class="text-center" colspan="11">등록 데이터가 없습니다.</td>
                                       </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                                <div class="col-sm-4 " style="margin: auto">
                                    <form class="form-horizontal" action="{{ route($route_name) }}" method="GET">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <select name="sch_key">
                                                        <option value="advertiser" {{ ($sch_key=="advertiser") ? "selected" : ""  }} >광고주</option>
                                                        <option value="data_name" {{ ($sch_key=="data_name") ? "selected" : ""  }} >데이터명</option>
                                                        <option value="buy_date" {{ ($sch_key=="buy_date") ? "selected" : ""  }} >구매일</option>
                                                    </select>&nbsp;
                                                    <input class="form-control" id="input" type="text" name="sch" value="{{ $sch }}" placeholder="검색어" autocomplete="sch" style="display: {{ ($sch_key=="buy_date") ? "none;" : "block;"  }}"  >
                                                    <input class="form-control sch1" id="input1-group1" type="text" name="sch1" value="{{ $sch1 }}" placeholder="검색어" autocomplete="sch" style="display: {{ ($sch_key=="buy_date") ? "block;" : "none;"  }}" >
                                                    &nbsp;<span id="input_span" style="display: {{ ($sch_key=="buy_date") ? "block;" : "none;"  }}">~</span>&nbsp;
                                                    <input class="form-control sch2" id="input2-group2" type="text" name="sch2" value="{{ $sch2 }}" placeholder="검색어" autocomplete="sch" style="display: {{ ($sch_key=="buy_date") ? "block;" : "none;"  }}" >
                                                    <span class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">검색</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                {{ $carts->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                    <form method="POST" name="frm" action="" enctype="multipart/form-data">
                        <input type="hidden" name="route_name" value="{{ $route_name }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h4 class="modal-title">전체</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col">
                                <label>광고주</label>
                                <input class="form-control" type="text" placeholder="광고주" name="advertiser" value="" disabled required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>데이터명</label>
                                <input class="form-control" type="text" placeholder="데이터명" name="data_name" value="" disabled required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>요청횟수</label>
                                <input class="form-control" type="text" placeholder="요청횟수" name="data_request" value="" disabled required autofocus>
                            </div>
                        </div>

{{--                        <div class="form-group row">--}}
{{--                            <div class="col">--}}
{{--                                <label>데이터항목</label>--}}
{{--                                <input class="form-control" type="text" placeholder="데이터항목" name="data_category" value="" disabled required autofocus>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group row">
                            <div class="col">
                                <label>설명</label>
                                <textarea class="form-control" style="height: 150px" placeholder="설명" name="data_content" disabled required autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>상태</label>
                                <select class="form-control" name="state">
                                    <option value="1"  >확인중</option>
                                    <option value="2"  >결제대기중</option>
                                    <option value="3"  >결제완료</option>
                                    <option value="4"  >데이터추출중</option>
                                    <option value="5"  >데이터추출완료</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>데이터 수</label>
                                <input class="form-control" type="number" placeholder="데이터 수" name="data_count" value=""  required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>데이터 가격</label>
                                <input class="form-control" type="number" placeholder="데이터 가격" name="buy_price" value=""  required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>유효기간</label>
                                <input class="form-control" type="text" placeholder="expiration_date" id="expiration_date" name="expiration_date"  value=""  autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>메모</label>
                                <textarea class="form-control" style="height: 150px" placeholder="설명" name="memo"   autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row" id="file_row" style="display: none;">
                            <div class="col">
                                <label>파일 업로드</label>
                                <input class="form-control" type="file"  id="data_files" name="data_files"  value=""  autofocus>
                            </div>
                        </div>

                        <div class="form-group row" id="file_name_row" style="display: none;">
                            <div class="col">
                                <label>업로드 파일 : </label>
                                <span id="file_name"></span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">닫기</button>
                        <button class="btn btn-success btn-sm" type="submit" name="submit" >저장</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>

@endsection
