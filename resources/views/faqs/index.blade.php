@extends('layouts.backoffice')

@prepend('scripts')
    <script>
        $(function() {
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
                            $("form[name='frm']").attr("action", "faqs/"+JSONArray['faq_info']['faq_id']);

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
                            <i class="fa fa-align-justify"></i></div>
                        <div class="card-body">
                            <div class="float-right">
                                <a href="{{ route('faqs.create') }}" class="btn btn-primary m-2">작성</a>
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
                                    <td style="width: 100px">
{{--                                        <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-block btn-success">수정</a>--}}
                                        <button class="btn btn-block btn-success" type="button" name="btn" data-faq_id="{{ $faq->id }}"  >수정</button>
                                    </td>
                                    <td style="width: 100px">
                                        <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-block btn-danger">삭제</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
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
                <form method="POST" name="frm" action=" ">
                    @csrf
                    @method('PUT')
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
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">닫기</button>
                        <button class="btn btn-success" type="submit">수정</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
@endsection
