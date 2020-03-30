@extends('layouts.backoffice')

@prepend('scripts')
    <script>
        $(function() {
            $("button[name='btn_create']").click(function() {
                $("input[name='id']").val("{{ auth::user()->name }}");

                $("[name='submit']").removeClass("btn-success");
                $("[name='submit']").addClass("btn-primary");

                $("[name='submit']").text("작성");
                $("input[name='_method']").val("POST");
                $("form[name='frm']").attr("action", "{{ route('faqs.store') }}" );

                $('#largeModal').modal('show');
            });

            $("button[name='btn']").click(function() {
                var data = new Object();
                data.faq_id = $(this).data("faq_id");
                var jsonData = JSON.stringify(data);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('faqs.find.id') }}",
                    method: "POST",
                    dataType: "json",
                    data: {'data': jsonData},
                    success: function (data) {
                        var JSONArray = JSON.parse(JSON.stringify(data));

                        if (JSONArray['result'] == "success") {
                            //console.log(JSONArray['user_info']);
                            $("input[name='id']").val(JSONArray['faq_info']['name']);
                            $("input[name='title']").val(JSONArray['faq_info']['title']);
                            $("textarea[name='content']").val(JSONArray['faq_info']['content']);

                            //$("#modelForm").attr("action", "faqs/"+JSONArray['faq_info']['faq_id']);
                            $("form[name='frms']").attr("action", "faqs/"+JSONArray['faq_info']['faq_id']);

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
                            자주 묻는 질문
                        </div>
                        <div class="card-body">
                            <div class="float-right">
{{--                                <a href="{{ route('faqs.create') }}" class="btn btn-primary m-2" name="">작성</a>--}}
                                    <button class="btn btn-primary m-2 btn-sm" type="button" name="btn_create" >작성</button>
                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>제목</th>
                                    <th>ID</th>
                                    <th>작성일</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($faqs as $faq)
                                    <tr>
                                    <td>{{ $faq->id }}</td>
                                    <td><strong>{{ $faq->title }}</strong></td>
                                    <td>{{ $faq->user->name }}</td>
                                    <td>
                                        {{ Carbon\Carbon::parse($faq->created_at)->format('Y-m-d') }}
                                    </td>
                                    <td style="width: 70px">
{{--                                        <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-block btn-success">수정</a>--}}
                                        <button class="btn btn-block btn-success btn-sm" type="button" name="btn" data-faq_id="{{ $faq->id }}"  >수정</button>
                                    </td>
                                    <td style="width: 70px">
                                        <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST">
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
                                                    <option value="title">제목</option>
                                                    <option value="content">내용</option>
                                                </select>&nbsp;
                                                <input class="form-control" id="input2-group2" type="text" name="sch" value="{{ $sch }}" placeholder="검색어" autocomplete="sch"><span class="input-group-append">
                                                    <button class="btn btn-primary btn-sm" type="submit">검색</button></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{ $faqs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" name="frms" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h4 class="modal-title">자주 묻는 질문</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">

                        <div class="form-group row">
                            <div class="col">
                                <label>ID</label>
                                <input class="form-control" type="text" placeholder="id" name="id" value="" disabled required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>제목</label>
                                <input class="form-control" type="text" placeholder="title" name="title" value="" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>내용</label>
                                <textarea class="form-control" style="height: 300px" placeholder="content" name="content"  required autofocus></textarea>
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
