@extends('layout.app')

@section('title')
    {{$paper->name}}
@endsection

@section('content')
    <input type="hidden" id="paperId" value="{{$paper['id']}}"/>
        <div class="col-md-12">
            <div>
                <h3 class="float-start">{{$paper['name']}}</h3>
                <div class="float-start ms-3">
                    <a class="btn btn-outline-info addQuestion" type="button" href="{{route('paper.edit', ['id'=> $paper->id])}}" title="Edit Paper">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
                <div class="float-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Start Test</button>
                    <a type="button" href="{{route('exam.create', ['paperId'=> $paper->id])}}" class="btn btn-primary">
                        <i class="bi bi-file-earmark-minus-fill"></i> Preview
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class=" ">
                Exam Link: <a class="testLink text-decoration-none" href="{{$paper->linkUrl}}">{{$paper->linkUrl}}</a>
            </div>
            <div class="mt-3">
                <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> 0])}}" class="btn btn-primary addQuestion">
                    <i class="bi bi-plus-lg"></i> Add New Question
                </a>
            </div>

            <div class="box box-info clearfix pad ">
                <div class="col-md-12">
                   
                    <table class="table table-hover mt-2 questionNumber ">
                        @foreach($questions as $que)
                            <tr class="questionRow movableSection" id="questionRow{{$que->id}}">
                                <td class="">
                                    <input type="hidden" class="questionId" value="{{$que->id}}"/>
                                    <input type="hidden" name="serialNumber" class="serialNumber" value="{{$que->serial_number}}"/>
                                    <div>
                                        <div class="">
                                            <div class="float-start">
                                                <span class="serialNumberText">{{$que->serial_number}}</span>
                                            </div>
                                            <div class="float-start ms-4">
                                                {!! htmlspecialchars_decode($que->description) !!}
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        @foreach($que->options as $opt)
                                            <div class="ms-4">
                                                <div class="float-start">
                                                    <input type="radio" name="que_{{$que->id}}" value="none"/>
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
                                    <a class="btn btn-outline-info editQuestion" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> $que->id])}}"  title="Edit Question">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    {{-- <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> $que->id])}}" class="btn btn-warning editQuestion">Delete</a> --}}
                                    <button class="btn btn-outline-primary moveUp" type="button" title="Move UP">↑</button>
                                    <button class="btn btn-outline-primary moveDown" type="button" title="Move DOWN">↓</button>
                                    <button class="btn btn-outline-danger remove" type="button" title="Delete Question">X</button>
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

    <div class="modal fade" id="questionDeleteModal" tabindex="-1" aria-labelledby="questionDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="questionDeleteModalLabel">Delete Question?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="questionId" value=""/>
                    Are you sure to delete the question?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary deleteQuestion">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
        
    <script src="{{asset("js/papershow.js")}}"></script>

@endsection