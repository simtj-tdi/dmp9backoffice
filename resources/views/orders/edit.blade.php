@extends('layouts.backoffice')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> No. {{ $order['order_id'] }} </div>
                            <div class="card-body">
                                <h4>Ad_type:</h4>
                                <p> {{ $order['types'] }}</p>
                                <h4>data_name:</h4>
                                <p> {{ $order['data_name'] }}</p>
                                <h4>data_category:</h4>
                                <p> {{ $order['data_category'] }}</p>

                                <form method="POST" action="{{ route('orders.update', $order['order_id']) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                        <div class="col">
                                            <label>data_count</label>
                                            <input class="form-control" type="text" placeholder="data_count" name="data_count" value="{{ $order['data_count'] }}" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col">
                                            <label>buy_price</label>
                                            <input class="form-control" type="text" placeholder="buy_price" name="buy_price" value="{{ $order['buy_price'] }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label>expiration_date</label>
                                            <input class="form-control" type="text" placeholder="expiration_date" name="expiration_date" value="{{ $order['expiration_date'] }}" required autofocus>
                                        </div>
                                    </div>

                                    <button class="btn btn-block btn-success" type="submit">Save</button>
                                    <a href="{{ route('orders.index') }}" class="btn btn-block btn-primary">Return</a>
                                </form>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
