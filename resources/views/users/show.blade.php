@extends('layouts.backoffice')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> No. {{ $users['user_id'] }} </div>
                            <div class="card-body">
                                <h5>이름:</h5>
                                <p> {{ $users['name'] }}</p>
                                <h5>Email:</h5>
                                <p> {{ $users['email'] }}</p>
                                <h5>가입일자:</h5>
                                <p> {{ $users['created_at'] }}</p>
                                <h5> 승인여부: </h5>
                                <p>
                                    @if ( $users['approved'])
                                        <span class="badge badge-pill badge-warning">
                                          인증
                                        </span>
                                    @else
                                        <span class="badge badge-pill badge-secondary">
                                          비인증
                                        </span>
                                    @endif
                                </p>
                                <h5>Approved_at:</h5>
                                <p> {{ $users['approved_at'] }}</p>

                                <a href="{{ route('users.index') }}" class="btn btn-block btn-primary">Return</a>
                            </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
