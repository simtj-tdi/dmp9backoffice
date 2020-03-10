@extends('layouts.backoffice')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> No. {{ $faq['faq_id'] }} </div>
                    <div class="card-body">
                        <h5>작성자:</h5>
                        <p> {{ $faq['name'] }}</p>
                        <h5>제목:</h5>
                        <p> {{ $faq['title'] }}</p>
                        <h5>내용:</h5>
                        <p> {{ $faq['content'] }}</p>
                        <a href="{{ route('faqs.index') }}" class="btn btn-block btn-primary">Return</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
