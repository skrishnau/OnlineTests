@extends('layout.app')

@section('title')
    {{$paper->name}}
@endsection

@section('content')
    <input type="hidden" id="paperId" value="{{$paper['id']}}"/>
        <div class="col-md-12">
            <div>
                <h3 class="float-start">{{$paper['name']}}</h3>
                <div class="float-start">
                    <a type="button" href="{{route('paper.edit', ['id'=> $paper->id])}}" class="btn btn-primary addQuestion">Edit</a>
                </div>
                <div class="float-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Start Test</button>
                    <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> 0])}}" class="btn btn-primary addQuestion">Add New Question</a>
                    <a type="button" href="{{route('exam.create', ['paperId'=> $paper->id])}}" class="btn btn-primary">Preview</a>
                </div>
                <div class="clearfix"></div>
            </div>


            <div class="box box-info clearfix pad ">
                <div class="col-md-12">
                    <div class=" text-info">
                        Exam Link: <a class="testLink text-decoration-none" href="{{$paper->linkUrl}}">{{$paper->linkUrl}}</a>
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
                                <td class="" style="width:200px;">
                                    <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> $que->id])}}" class="btn btn-primary editQuestion" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    {{-- <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> $que->id])}}" class="btn btn-warning editQuestion">Delete</a> --}}
                                    <button class="moveUp btn btn-primary" type="button" title="Move UP">↑</button>
                                    <button class="moveDown btn btn-primary" type="button" title="Move DOWN">↓</button>
                                    <button class="remove btn btn-danger" type="button" title="DELETE">X</button>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Start Test?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to start the test?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary startTest">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
        
    <script src="{{asset("js/papershow.js")}}"></script>

@endsection