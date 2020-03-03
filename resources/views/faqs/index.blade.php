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
                                <a href="{{ route('faqs.create') }}" class="btn btn-primary m-2">Add Note</a>
                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>title</th>
                                    <th>name</th>
                                    <th>Created</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($faqs as $faq)
                                    <tr>
                                    <td>{{ $faq->id }}</td>
                                    <td><strong>{{ $faq->title }}</strong></td>
                                    <td>{{ $faq->user->name }}</td>
                                    <td>
                                        {{ Carbon\Carbon::parse($faq->created_at)->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('faqs.show', $faq->id) }}" class="btn btn-block btn-primary">View</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-block btn-primary">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-block btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $faqs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
