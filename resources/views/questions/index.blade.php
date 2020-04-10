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

            $("button[name='btn']").click(function() {

                var data = new Object();
                data.question_id = $(this).data("question_id");
                var jsonData = JSON.stringify(data);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('question.find.id') }}",
                    method: "POST",
                    dataType: "json",
                    data: {'data': jsonData},
                    success: function (data) {
                        var JSONArray = JSON.parse(JSON.stringify(data));

                        if (JSONArray['result'] == "success") {
                            //console.log(JSONArray['question_info']['question_id']);
                            $("input[name='id']").val(JSONArray['question_info']['id']);
                            $("input[name='user_id']").val(JSONArray['question_info']['user_id']);
                            $("input[name='question_id']").val(JSONArray['question_info']['question_id']);
                            $("input[name='name']").val(JSONArray['question_info']['name']);
                            $("input[name='phone']").val(JSONArray['question_info']['phone']);
                            $("input[name='email']").val(JSONArray['question_info']['email']);

                            $("input[name='title']").val(JSONArray['question_info']['title']);
                            $("textarea[name='questions_content']").val(JSONArray['question_info']['content']);

                            if (typeof(JSONArray['question_info']['answers'][0]) != 'undefined') {
                                $("textarea[name='content']").val(JSONArray['question_info']['answers'][0]['content']);
                            } else {
                                $("textarea[name='content']").val();
                            }

                            $("form[name='frms']").attr("action", "questions/"+JSONArray['question_info']['question_id']);


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
                            <i class="fa fa-align-justify"></i>문의 및 답변
                        </div>
                        <div class="card-body">
                            <div class="float-right" >
                                &nbsp;
                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>제목</th>
                                    <th>작성자</th>
                                    <th>답변여부</th>
                                    <th>작성일</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>{{ $question->id }}</td>
                                        <td><strong>{{ $question->title }}</strong></td>
                                        <td>{{ $question->user->name }}</td>
                                        <td>
                                            @if (!$question->answers->isEmpty())
                                                답변완료
                                            @else
                                                답변대기
                                            @endif
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse($question->created_at)->format('Y-m-d') }}
                                        </td>
                                        <td style="width: 70px">
                                            <button class="btn btn-block btn-success btn-sm" type="button" name="btn" data-question_id="{{ $question->id }}"  >답변</button>
                                        </td>
                                        <td style="width: 70px">
                                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
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
                                                    <option value="title" {{ ($sch_key=="title") ? "selected" : ""  }}>제목</option>
                                                    <option value="content" {{ ($sch_key=="content") ? "selected" : ""  }}>내용</option>
                                                    <option value="created_at" {{ ($sch_key=="created_at") ? "selected" : ""  }} >작성일</option>
                                                </select>&nbsp;
                                                <input class="form-control" id="input" type="text" name="sch" value="{{ $sch }}" placeholder="검색어" autocomplete="sch" style="display: {{ ($sch_key=="created_at") ? "none;" : "block;"  }}"  >
                                                <input class="form-control sch1" id="input1-group1" type="text" name="sch1" value="{{ $sch1 }}" placeholder="검색어" autocomplete="sch" style="display: {{ ($sch_key=="created_at") ? "block;" : "none;"  }}" >
                                                &nbsp;<span id="input_span" style="display: {{ ($sch_key=="created_at") ? "block;" : "none;"  }}">~</span>&nbsp;
                                                <input class="form-control sch2" id="input2-group2" type="text" name="sch2" value="{{ $sch2 }}" placeholder="검색어" autocomplete="sch" style="display: {{ ($sch_key=="created_at") ? "block;" : "none;"  }}" >
                                                <span class="input-group-append">
                                                    <button class="btn btn-facebook" type="submit" style="z-index: 0;">검색</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{ $questions->links() }}
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
                    <input type="hidden" name="question_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">문의 및 답변</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">

                        <div class="form-group row">
                            <div class="col col-6">
                                <label>ID</label>
                                <input class="form-control" type="text" placeholder="id" name="id" value="" disabled required autofocus>
                            </div>
                            <div class="col col-6">
                                <label>이름</label>
                                <input class="form-control" type="text" placeholder="Name" name="name" value="" disabled required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col col-6">
                                <label>연락처</label>
                                <input class="form-control" type="text" placeholder="Phone" name="phone" value="" disabled required autofocus>
                            </div>
                            <div class="col col-6">
                                <label>Email</label>
                                <input class="form-control" type="text" placeholder="Email" name="email" value="" disabled required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>제목</label>
                                <input class="form-control" type="text" placeholder="title" name="title" value="" disabled required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>내용</label>
                                <textarea class="form-control" style="height: 150px" placeholder="content" name="questions_content" disabled required autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>답변</label>
                                <textarea class="form-control" style="height: 150px" placeholder="답변" name="content"  required autofocus></textarea>
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
