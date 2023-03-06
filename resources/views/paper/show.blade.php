@extends('layout.app')

@section('title')
    {{$paper->name}}
@endsection

@section('content')
        <div class="col-md-12">

            <h3>{{$paper['name']}}</h3>
            <div class="box box-info clearfix pad ">
                <div class="col-md-12">
                    <div>
                        <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> 0])}}" class="btn btn-primary addQuestion">Add New Question</a>
                    </div>
                    <div class="questionNumber mt-5">
                        @foreach($questions as $que)
                            <div class="">
                                <div class="pull-left">
                                    {{$que->serial_number}}
                                </div>
                                <div class="pull-left ml-1" style="margin-left:20px;">
                                    {!! htmlspecialchars_decode($que->description) !!}
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            @foreach($que->options as $opt)
                                <div style="margin-left:20px;">
                                    <div class="pull-left">
                                        <input type="radio" name="opt{{$opt->id}}" value="none"/>
                                    </div>
                                    <div class="pull-left">
                                        {!! html_entity_decode($opt->description) !!}
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>

                                @endforeach
                        @endforeach
                    </div>
                </div>
                <div class="col-md-9">
                   <div class="questionView">
                   </div>
                </div>
            </div>
        </div>

@endsection