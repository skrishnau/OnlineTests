@extends('layout.app')

@section('title')
    {{$paper->name}}
@endsection

@section('content')
        <div class="col-md-12">

            <h3>{{$paper['name']}}</h3>
            <div class="box box-info clearfix pad ">
                <div class="col-md-3">
                    <h5>Questions</h5>
                    <div>
                        <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> 0])}}" class="btn btn-primary addQuestion">Add New Question</a>
                    </div>
                    <ul class="questionNumber">
                        @foreach($questions as $que)
                            <li>{{$que->serialNumber}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9">
                   <div class="questionView">
                   </div>
                </div>
            </div>
        </div>

@endsection


@section('scripts')
    <script src="{{asset('js/question.js')}}"></script>
@endsection