@extends('layouts.authBase')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>권한 오류</h1>
                            <p class="text-muted">지정된 관리자만 로그인 가능 합니다.</p>
                            <form method="POST" action="{{ route('logout') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-primary px-4" type="submit">홈으로</button>
                                    </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

@endsection
