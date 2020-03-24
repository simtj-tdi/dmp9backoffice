@extends('layouts.backoffice')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">

                        <div class="card-body">

                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>이름</th>
                                    <th>Email</th>
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
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ( $user->approved)
                                            <span class="badge badge-pill badge-warning">
                                              인증
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-secondary">
                                              비인증
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-block btn-primary">수정</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-block btn-danger">삭제</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
