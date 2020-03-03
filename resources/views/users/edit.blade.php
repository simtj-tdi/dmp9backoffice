@extends('layouts.backoffice')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Edit: {{ $users['user_id'] }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('users.update', $users['user_id']) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <div class="col">
                                        <label>Name</label>
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
                                        <label>Status</label>
                                        <select class="form-control" name="approved">
                                            <option value="0" {{ $users['approved'] == '0' ? 'selected' : '' }} >비승인</option>
                                            <option value="1" {{ $users['approved'] == '1' ? 'selected' : '' }} >승인</option>
                                        </select>
                                    </div>
                                </div>

                                <button class="btn btn-block btn-success" type="submit">Save</button>
                                <a href="{{ route('users.index') }}" class="btn btn-block btn-primary">Return</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
