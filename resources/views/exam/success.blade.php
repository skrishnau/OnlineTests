@extends('layout.app')

@section('title')
    {{$exam->paper->name}}
@endsection

@section('content')
        <div class="col-md-12 text-center">
            <h3>Submitted Successfully!</h3>
            <h4>You may close this tab</h4>
        </div>
@endsection

@section('scripts')
@endsection