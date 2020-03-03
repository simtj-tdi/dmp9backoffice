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
                        <h4>Name:</h4>
                        <p> {{ $users['name'] }}</p>
                        <h4>Email:</h4>
                        <p> {{ $users['email'] }}</p>
                        <h4>Created:</h4>
                        <p> {{ $users['created_at'] }}</p>
                        <h4> Status: </h4>
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
                        <h4>Approved_at:</h4>
                        <p> {{ $users['approved_at'] }}</p>

                        <a href="{{ route('users.index') }}" class="btn btn-block btn-primary">Return</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
