@extends('layouts.backoffice')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('users.update', $users['user_id']) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <div class="col">
                                        <label>이름</label>
                                        <input class="form-control" type="text" placeholder="Name" name="name" value="{{ $users['name'] }}" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>Email</label>
                                        <input class="form-control" type="text" placeholder="Email" name="email" value="{{ $users['email'] }}" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>승인여부</label>
                                        <select class="form-control" name="approved">
                                            <option value="0" {{ $users['approved'] == '0' ? 'selected' : '' }} >비승인</option>
                                            <option value="1" {{ $users['approved'] == '1' ? 'selected' : '' }} >승인</option>
                                        </select>
                                    </div>
                                </div>

                                <button class="btn btn-block btn-success" type="submit">저장</button>
                                <a href="{{ route('users.index') }}" class="btn btn-block btn-primary">뒤로가기</a>
                            </form>
                        </div>
                    </div>
                </div>

                @if (!$users['tax']->isEmpty())
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header"><strong>계산서정보</strong> <small></small></div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="company">사업자등록번호</label>
                                    <input class="form-control" value=""  type="text" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="vat">업체명(법인명)</label>
                                    <input class="form-control" value="{{$users['tax'][0]['tax_company_name']}}" type="text" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="street">대표자명</label>
                                    <input class="form-control"  value="{{$users['tax'][0]['tax_name']}}" type="text" placeholder="">
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <label for="city">주소</label>
                                        <input class="form-control" value="{{$users['tax'][0]['tax_addres_1']}}" type="text" placeholder="">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="postal-code">우편번호</label>
                                        <input class="form-control" value="{{$users['tax'][0]['tax_zipcode']}}" type="text" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" value="{{$users['tax'][0]['tax_addres_2']}}"  type="text" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="country">사업자등록증</label><br />
                                    {{ $users['tax'][0]['tax_img'] }}
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>



@endsection
