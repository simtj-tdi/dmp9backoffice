@extends('layouts.backoffice')

@prepend('scripts')
    <script>
        $(function() {
            $("button[name='btn']").click(function() {
                var data = new Object();
                data.contactsu_id = $(this).data("contactsu_id");
                var jsonData = JSON.stringify(data);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('contactsu.find.id') }}",
                    method: "POST",
                    dataType: "json",
                    data: {'data': jsonData},
                    success: function (data) {
                        var JSONArray = JSON.parse(JSON.stringify(data));

                        if (JSONArray['result'] == "success") {

                            $("input[name='name']").val(JSONArray['contactsus']['name']);
                            $("input[name='phone']").val(JSONArray['contactsus']['phone']);
                            $("input[name='email']").val(JSONArray['contactsus']['email']);
                            $("textarea[name='content']").val(JSONArray['contactsus']['content']);

                            $('#largeModal').modal('show');
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
                            Contacts Us
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                &nbsp;
                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>회사명/이름</th>
                                    <th>핸드폰 번호</th>
                                    <th>이메일 주소</th>
                                    <th>작성일</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contactsus as $contactsu)
                                    <tr>
                                        <td>{{ $contactsu->id }}</td>
                                        <td><strong>{{ $contactsu->name }}</strong></td>
                                        <td>{{ $contactsu->phone }}</td>
                                        <td>{{ $contactsu->email }}</td>
                                        <td>{{ Carbon\Carbon::parse($contactsu->created_at)->format('Y-m-d') }}</td>
                                        <td style="width: 70px">
                                            <button class="btn btn-block btn-success btn-sm" type="button" name="btn" data-contactsu_id="{{ $contactsu->id }}"  >보기</button>
                                        </td>
                                        <td style="width: 70px">
                                            <form action="{{ route('contactsus.destroy', $contactsu->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-block btn-danger btn-sm">삭제</button>
                                            </form>
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
                                                    <option value="name">회사명/이름</option>
                                                    <option value="phone">핸드폰번호</option>
                                                    <option value="email">이메일주소</option>
                                                </select>&nbsp;
                                                <input class="form-control" id="input2-group2" type="text" name="sch" value="{{ $sch }}" placeholder="검색어" autocomplete="sch"><span class="input-group-append">
                                                    <button class="btn btn-primary btn-sm" type="submit">검색</button></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{ $contactsus->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="modalForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h4 class="modal-title">Contacts Us</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">

                        <div class="form-group row">
                            <div class="col">
                                <label>회사명/이름</label>
                                <input class="form-control" type="text" placeholder="회사명/이름" name="name" value="" disabled required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>핸드폰 번호</label>
                                <input class="form-control" type="text" placeholder="핸드폰 번호" name="phone" value="" disabled required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>이메일 주소</label>
                                <input class="form-control" type="text" placeholder="이메일 주소" name="email" value="" disabled required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>문의사항</label>
                                <textarea class="form-control" style="height: 300px" placeholder="문의사항" name="content" disabled required autofocus></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">닫기</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
@endsection
