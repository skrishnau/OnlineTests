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
                    <?php 
                    $canShowStartBtn = !isset($paper->start_datetime); 
                    $canShowEndBtn = isset($paper->start_datetime) && !isset($paper->end_datetime);
                    ?>
                    @if($canShowStartBtn)
                    <button type="button" class="btn btn-success btnStartPaper" data-bs-toggle="modal" data-bs-target="#startModal">Start Test</button>
                    @endif
                    <button type="button" class="btn btn-danger btnEndPaper" data-bs-toggle="modal" data-bs-target="#endModal" style="display:{{$canShowEndBtn ? "inline" : "none" }};">End Test</button>
                    <a type="button" href="{{route('exam.create', ['paperId'=> $paper->id, 'show' => 'preview'])}}" class="btn btn-primary">
                        <i class="bi bi-file-earmark-minus-fill"></i> Preview
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class=" ">
                Exam Link: <a class="testLink text-decoration-none" href="{{$linkUrl}}">{{$linkUrl}}</a>
                <br/>
                Started On : <b class="lblStartDatetime">{{$paper->start_datetime}}</b>
                <br/>
                Ended On: <b class="lblEndDatetime">{{$paper->end_datetime}}</b>
            </div>
            <div class="mt-5">
                @if($canEdit)
                    <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> 0])}}" class="btn btn-primary addQuestion">
                        <i class="bi bi-plus-lg"></i> Add New Question
                    </a>
                @endif
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
                                                <div class="float-start ms-3">
                                                    {!! html_entity_decode($opt->description) !!}
                                                </div>
                                                <div class="clearfix">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="divQuestionAction" style="width:200px;">
                                    @if($canEdit)
                                        <a class="btn btn-outline-info editQuestion" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> $que->id])}}"  title="Edit Question">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        {{-- <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> $que->id])}}" class="btn btn-warning editQuestion">Delete</a> --}}
                                        <button class="btn btn-outline-primary moveUp" type="button" title="Move UP">↑</button>
                                        <button class="btn btn-outline-primary moveDown" type="button" title="Move DOWN">↓</button>
                                        <button class="btn btn-outline-danger remove" type="button" title="Delete Question">X</button>
                                    @endif
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
    <div class="modal fade" id="startModal" tabindex="-1" aria-labelledby="startModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="startModalLabel">Start Test?</h1>
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
    {{-- TODO: implement end and start modal in a sinlge modal. --}}
    <div class="modal fade" id="endModal" tabindex="-1" aria-labelledby="endModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="startModalLabel">End Test?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to end the test?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary endTest">Yes</button>
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