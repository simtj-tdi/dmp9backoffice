@extends('layouts.backoffice')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> No. {{ $question['question_id'] }} </div>
                    <div class="card-body">
                        <h4>Name:</h4>
                        <p> {{ $question['name'] }}</p>
                        <h4>Title:</h4>
                        <p> {{ $question['title'] }}</p>
                        <h4>Content:</h4>
                        <p> {{ $question['content'] }}</p>

                        @if ($question['answers']->count() >0)
                            <h4>Answers:</h4>
                            <p> {{ $question['answers'][0]['content'] }}</p>
                        @endif
                        <a href="{{ route('questions.index') }}" class="btn btn-block btn-primary">Return</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
