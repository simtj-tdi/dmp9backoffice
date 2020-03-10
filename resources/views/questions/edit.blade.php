@extends('layouts.backoffice')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Edit: {{ $question['question_id'] }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('questions.update', $question['question_id']) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="question_id" value="{{ $question['question_id'] }}">

                                <h5>작성자:</h5>
                                <p> {{ $question['name'] }}</p>
                                <h5>제목:</h5>
                                <p> {{ $question['title'] }}</p>
                                <h5>내용:</h5>
                                <p> {{ $question['content'] }}</p>
                                <h5>답변:</h5>
                                <p>
                                    <textarea class="form-control" type="text" placeholder="answers" name="content"  required autofocus>
                                        @if ($question['answers']->count() >0)
                                            {{ $question['answers'][0]['content'] }}
                                        @endif
                                    </textarea>
                                </p>

                                <button class="btn btn-block btn-success" type="submit">Save</button>
                                <a href="{{ route('questions.index') }}" class="btn btn-block btn-primary">Return</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
