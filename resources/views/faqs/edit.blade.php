@extends('layouts.backoffice')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Edit: {{ $faq['faq_id'] }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('faqs.update', $faq['faq_id']) }}">
                                @csrf
                                @method('PUT')


                                <div class="form-group row">
                                    <div class="col">
                                        <label>Title</label>
                                        <input class="form-control" type="text" placeholder="Title" name="title" value="{{ $faq['title'] }}" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>Content</label>
                                        <textarea class="form-control" type="text" placeholder="Email" name="content"  required autofocus>{{ $faq['content'] }}</textarea>
                                    </div>
                                </div>

                                <button class="btn btn-block btn-success" type="submit">Save</button>
                                <a href="{{ route('faqs.index') }}" class="btn btn-block btn-primary">Return</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
