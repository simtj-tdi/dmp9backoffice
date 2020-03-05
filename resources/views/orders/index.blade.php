@extends('layouts.backoffice')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>Notes</div>
                        <div class="card-body">

                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Ad_type</th>
                                    <th>data_name</th>
                                    <th>data_count</th>
                                    <th>name</th>
                                    <th>buy_price</th>
                                    <th>state</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->types }}</td>
                                        <td>{{ $order->data_count }}</td>
                                        <td>{{ $order->data_name }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->buy_price }}</td>
                                        <td>

                                            @if ($order->state === 1)
                                                결제 대기중
                                            @elseif ($order->state === 2)
                                                결제 대기중
                                            @elseif ($order->state === 3)
                                                결제 완료
                                            @elseif ($order->state === 4)
                                                유효 기간완료
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-block btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
