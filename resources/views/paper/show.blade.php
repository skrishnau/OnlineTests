@extends('layout.app')

@section('title')
    {{$paper->name}}
@endsection

@section('content')
        <div class="col-md-12">
            <div>
                <h3 class="float-start">{{$paper['name']}}</h3>
                <div class="float-start">
                    <a type="button" href="{{route('paper.edit', ['id'=> $paper->id])}}" class="btn btn-primary addQuestion">Edit</a>
                </div>
                <div class="float-end">
                    <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> 0])}}" class="btn btn-primary addQuestion">Add New Question</a>
                    <a type="button" href="{{route('exam.create', ['paperId'=> $paper->id])}}" class="btn btn-primary">Preview</a>
                </div>
                <div class="clearfix"></div>
            </div>


            <div class="box box-info clearfix pad ">
                <div class="col-md-12">
                    <div>
                         </div>
                    <table class="table table-hover mt-5 questionNumber ">
                        @foreach($questions as $que)
                            <tr class="questionRow">
                                <td class="">
                                    <input type="hidden" class="questionId" value="{{$que->id}}"/>
                                    <div>
                                        <div class="">
                                            <div class="float-start">
                                                {{$que->serial_number}}
                                            </div>
                                            <div class="float-start ms-4">
                                                {!! htmlspecialchars_decode($que->description) !!}
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        @foreach($que->options as $opt)
                                            <div class="ms-4">
                                                <div class="float-start">
                                                    <input type="radio" name="opt{{$opt->id}}" value="none"/>
                                                </div>
                                                <div class="float-start">
                                                    {!! html_entity_decode($opt->description) !!}
                                                </div>
                                                <div class="clearfix">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="" style="width:100px;">
                                    <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> $que->id])}}" class="btn btn-primary editQuestion">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-md-9">
                   <div class="questionView">
                   </div>
                </div>
            </div>
        </div>

@endsection