@extends('layouts.backoffice')

@prepend('scripts')
    <script src="http://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        function  execDaumPostcode() {
            new daum.Postcode({
                oncomplete: function(data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var addr = ''; // 주소 변수
                    var extraAddr = ''; // 참고항목 변수

                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        addr = data.roadAddress;
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        addr = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                    if(data.userSelectedType === 'R'){
                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                        if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                            extraAddr += data.bname;
                        }
                        // 건물명이 있고, 공동주택일 경우 추가한다.
                        if(data.buildingName !== '' && data.apartment === 'Y'){
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                        if(extraAddr !== ''){
                            extraAddr = ' (' + extraAddr + ')';
                        }
                        // 조합된 참고항목을 해당 필드에 넣는다.
                        document.getElementById("extraAddress").value = extraAddr;

                    } else {
                        document.getElementById("extraAddress").value = '';
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('postcode').value = data.zonecode;
                    document.getElementById("address").value = addr;
                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById("detailAddress").focus();
                }
            }).open();
        }

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
                data.user_id = $(this).data("user_id");
                var jsonData = JSON.stringify(data);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('users.find.id') }}",
                    method: "POST",
                    dataType: "json",
                    data: {'data': jsonData},
                    success: function (data) {
                        var JSONArray = JSON.parse(JSON.stringify(data));

                        if (JSONArray['result'] == "success") {
                            $("input[name='id']").val(JSONArray['user_info']['id']);
                            $("input[name='user_id']").val(JSONArray['user_info']['user_id']);
                            $("input[name='name']").val(JSONArray['user_info']['name']);
                            $("input[name='company_name']").val(JSONArray['user_info']['company_name']);
                            $("input[name='phone']").val(JSONArray['user_info']['phone']);
                            $("input[name='email']").val(JSONArray['user_info']['email']);
                            $("select[name='approved']").val(JSONArray['user_info']['approved']).attr("selected", "selected");

                            if (JSONArray['user_info']['taxes'][0]) {
                                $("#taxes").css('display','block');
                                $("input[name='tax_company_number']").val(JSONArray['user_info']['taxes'][0]['tax_company_number']);
                                $("input[name='tax_company_name']").val(JSONArray['user_info']['taxes'][0]['tax_company_name']);
                                $("input[name='tax_name']").val(JSONArray['user_info']['taxes'][0]['tax_name']);
                                $("input[name='tax_zipcode']").val(JSONArray['user_info']['taxes'][0]['tax_zipcode']);
                                $("input[name='tax_addres_1']").val(JSONArray['user_info']['taxes'][0]['tax_addres_1']);
                                $("input[name='tax_addres_2']").val(JSONArray['user_info']['taxes'][0]['tax_addres_2']);

                                $("#file_url").text(JSONArray['user_info']['taxes'][0]['tax_img']);
                                $("#file_url").attr("href", "https://dmp9storage1.blob.core.windows.net/images/tax/"+JSONArray['user_info']['user_id']+"/"+JSONArray['user_info']['taxes'][0]['tax_img']);
                            } else {
                                $("#taxes").css('display','none');
                            }

                            //$("#modalForm").attr("action", "users/"+JSONArray['user_info']['id']);
                            $("form[name='frms']").attr("action", "users/"+JSONArray['user_info']['id']);

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


            $("select[name=state]").change(function() {
                var data = new Object();
                data.user_id = $(this).data("user_id");
                data.states = $(this).val();
                var jsonData = JSON.stringify(data);

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('users.state_change') }}",
                    method: "get",
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
                            <a href="/users" class="btn btn-sm btn-warning ">전체</a>
                            <a href="/NonCertification" class="btn btn-sm btn-secondary ">비인증</a>

                        <div class="card-body">

                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID</th>
                                    <th>이름</th>
                                    <th>회사명</th>
                                    <th>연락처</th>
                                    <th>Email</th>
                                    <th>가입구분</th>
                                    <th>승인여부</th>
                                    <th>가입일자</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                    <td>{{ $user->id }}</td>
                                    <td><strong>{{ $user->user_id }}</strong></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->company_name }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role == "personal")
                                            개인회원
                                        @elseif ( $user->role == "company")
                                            기업회원
                                        @endif
                                    </td>
                                    <td>
                                        <select name="state" data-user_id="{{ $user->id }}">
                                            <option value="0" {{ $user->approved == '0' ? 'selected' : '' }}>비인증</option>
                                            <option value="1" {{ $user->approved == '1' ? 'selected' : '' }}>인증</option>
                                        </select>
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}
                                    </td>
                                    <td style="width: 70px">
                                        <button class="btn btn-block btn-success btn-sm" type="button" name="btn" data-user_id="{{ $user->id }}"  >수정</button>
                                    </td>
                                    <td style="width: 70px">
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
                                                    <option value="user_id" {{ ($sch_key=="user_id") ? "selected" : ""  }}>ID</option>
                                                    <option value="name" {{ ($sch_key=="name") ? "selected" : ""  }}>이름</option>
                                                    <option value="company_name" {{ ($sch_key=="company_name") ? "selected" : ""  }}>회사명</option>
                                                    <option value="created_at" {{ ($sch_key=="created_at") ? "selected" : ""  }} >가입일자</option>
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

                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form method="POST" name="frms" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h4 class="modal-title">회원관리</h4>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                                <input type="hidden" name="id" value="">
                                <div class="form-group row">
                                    <div class="col">
                                        <label>ID</label>
                                        <input class="form-control" type="text" placeholder="Name" name="user_id" value="" disabled required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label>이름</label>
                                        <input class="form-control" type="text" placeholder="Name" name="name" value="" disabled required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label>회사명</label>
                                        <input class="form-control" type="text" placeholder="company_name" name="company_name" value="" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label>연락처</label>
                                        <input class="form-control" type="text" placeholder="Phone" name="phone" value="" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label>Email</label>
                                        <input class="form-control" type="text" placeholder="Email" name="email" value="" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label>승인여부</label>
                                        <select class="form-control" name="approved">
                                            <option value="0">비승인</option>
                                            <option value="1">승인</option>
                                        </select>
                                    </div>
                                </div>

                            <div id="taxes" style="display: none">

                                <div class="form-group row">
                                    <div class="col">
                                        <label>사업자등록번호</label>
                                        <input class="form-control" type="text" name="tax_company_number" placeholder="사업자등록번호를 입력해주세요" value=""  autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>업체명(법인명)</label>
                                        <input class="form-control" type="text" name="tax_company_name" placeholder="업체명을 입력해주세요" value=""  autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>대표자명</label>
                                        <input class="form-control" type="text" name="tax_name" placeholder="대표자명을 입력해주세요" value=""  autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>주소</label>

                                        <div class="address_box">
                                            <div class="form-inline mb-2">
                                                <input type="text" id="postcode" class="postcode form-control col-6" name="tax_zipcode" placeholder="우편번호를 입력해주세요">
                                                <button type="button" onclick=" execDaumPostcode()" style="top:33px; " class="ml-2 ">검색</button>
                                            </div>
                                            <input type="text" id="address" class=" form-control mb-2" name="tax_addres_1" placeholder="기본주소를 검색하세요">
                                            <input type="text" id="detailAddress" class=" form-control mb-2" name="tax_addres_2" placeholder="상세주소를 입력해주세요" autocomplete="off">
                                            <input type="text" id="extraAddress" class="extraAddress form-control" style="display: none" placeholder="참고항목">
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>사업자등록증</label>
                                        <div class="form-inline mb-2">
                                            <input id="file_name" type="file" name="tax_img" class="upload_name form-control"/>
                                        </div>
                                        <a id="file_url" target="_blank" href=""></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">닫기</button>
                            <button class="btn btn-success btn-sm" type="submit">저장</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
        </div>

@endsection
