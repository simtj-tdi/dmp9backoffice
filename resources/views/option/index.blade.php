@extends('layouts.backoffice')

@prepend('scripts')
    <script>
        $(function() {
            $("select[name=state]").change(function() {

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
                                        <th>user_id</th>
                                        <th>데이터명</th>
                                        <th>플랫폼</th>
                                        <th>플랫폼 URL</th>
                                        <th>아이디</th>
                                        <th>패스워드</th>
                                        <th>진행상태</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($options as $option)
                                        <tr>
                                            <td>{{ $option['option_id'] }}</td>
                                            <td>{{ $option['user']->user_id }}</td>
                                            <td>
                                                {{ $option['cart']->data_name }}
                                            </td>
                                            <td>{{ $option['platform']->name }}</td>
                                            <td>{{ $option['platform']->url }}</td>
                                            <td>{{ $option['sns_id'] }}</td>
                                            <td>{{ $option['sns_password'] }}</td>
                                            <td>
                                                <select name="state" data-option_id="{{ $option['option_id'] }}">
                                                    <option value="1" {{ $option['state'] == '1' ? 'selected' : '' }}>요청중</option>
                                                    <option value="2" {{ $option['state'] == '2' ? 'selected' : '' }}>업로드중</option>
                                                    <option value="3" {{ $option['state'] == '3' ? 'selected' : '' }}>업로드완료</option>
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
