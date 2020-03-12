@extends('layouts.backoffice')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>Notes
                            <div class="card-body">
                                <table class="table table-responsive-sm table-striped">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>광고주</th>
                                        <th>플랫폼 유형</th>
                                        <th>데이터명</th>
                                        <th>데이터 수</th>
                                        <th>이름</th>
                                        <th>데이터가격</th>
                                        <th>상태</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($goods as $good)
                                        <tr>
                                            <td>{{ $good->id }}</td>
                                            <td>{{ $good->advertiser }}</td>
                                            <td>{{ $good->data_types }}</td>
                                            <td>{{ $good->data_name }}</td>
                                            <td>{{ $good->data_count }}</td>
                                            <td>{{ $good->user->name }}</td>
                                            <td>{{ $good->mark_price }} 원</td>
                                            <td>
                                                @if ($good->cart->state === 1)
                                                    요청중
                                                @elseif ($good->cart->state === 2)
                                                    추출중
                                                @elseif ($good->cart->state === 3)
                                                    승인요청
                                                @elseif ($good->cart->state === 4)
                                                    결제완료
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('goods.edit', $good->id) }}" class="btn btn-block btn-primary">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $goods->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
