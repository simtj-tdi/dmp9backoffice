@extends('layouts.backoffice')

@prepend('scripts')
        $(function() {
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
        });

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
                                        <th>광고주</th>
                                        <th>데이터명</th>
                                        <th>데이터<br/>추출수</th>
                                        <th>구매가격</th>
                                        <th>구매일</th>
                                        <th>유효기간</th>
                                        <th>요청횟수</th>
                                        <th>상태</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($carts as $cart)
                                        <tr>
                                            <td>{{ $cart->goods->id }}</td>
                                            <td>{{ $cart->goods->advertiser }}</td>
                                            <td>{{ $cart->goods->data_name }}</td>
                                            <td>{{ $cart->goods->data_count }}</td>
                                            <td>{{ $cart->goods->buy_price }}</td>
                                            <td>{{ $cart->buy_date }}</td>
                                            <td>{{ $cart->goods->expiration_date }}</td>
                                            <td>{{ $cart->goods->data_request }}</td>
                                            <td>
                                                @if ($cart->state === 1)
                                                    결제대기중
                                                @elseif ($cart->state === 2)
                                                    결제완료
                                                @elseif ($cart->state === 3)
                                                    데이터추출중
                                                @elseif ($cart->state === 4)
                                                    데이터추출완료
                                                @endif
                                            </td>
                                            <th>
                                            <a href="{{ route('cart.edit', $cart->goods->id) }}" class="btn btn-block btn-primary">Edit</a>
                                            </th>
                                        </tr>
                                        @if (!$cart->options->isEmpty())
                                            <tr>
                                                <td colspan="11">
                                                    <table class="table table-responsive-sm table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>대상플랫폼</th>
                                                            <th>대상플랫폼 URL</th>
                                                            <th>아이디</th>
                                                            <th>비밀번호</th>
                                                            <th>상태</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($cart->options as $option)

                                                            <tr>
                                                                <td>{{$option->platform['name']}}</td>
                                                                <td>{{$option->platform['url']}}</td>
                                                                <td>{{$option->sns_id}}</td>
                                                                <td>{{$option->sns_password}}</td>
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
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="col-sm-4">
                                    <form class="form-horizontal" action="{{ route($route_name) }}" method="get" name="frm">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input class="form-control" id="input2-group2" type="text" name="sch" value="{{ $sch }}" placeholder="데이터명" autocomplete="sch"><span class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">검색</button></span>
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
@endsection
