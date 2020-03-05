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
                            <div class="row">
                                <a href="{{ route('questions.create') }}" class="btn btn-primary m-2">Add Note</a>
                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>title</th>
                                    <th>name</th>
                                    <th>answer</th>
                                    <th>Created</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                    <td>{{ $question->id }}</td>
                                    <td><strong>{{ $question->title }}</strong></td>
                                    <td>{{ $question->user->name }}</td>
                                    <td>
                                        @if ($question->answers->count() >0)
                                            답변완료
                                        @else
                                            답변대기
                                        @endif
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($question->created_at)->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('questions.show', $question->id) }}" class="btn btn-block btn-primary">View</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-block btn-primary">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-block btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $questions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection