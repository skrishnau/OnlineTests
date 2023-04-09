@extends('layout.app')

@section('title')
    {{$paper->name}}
@endsection

@section('content')

    @php
        $sn = 1;
    @endphp
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
                    <a class="btn btn-primary" href="{{route("exam.create", $paper['id'])}}">
                        Create Exam
                    </a>
                    <a type="button" href="{{route('exam.create', ['paperId'=> $paper->id, 'show' => 'preview'])}}" class="btn btn-primary">
                        <i class="bi bi-file-earmark-minus-fill"></i> Preview
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            

            <div class="box box-info clearfix pad ">
                <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="question-tab" data-bs-toggle="tab" data-bs-target="#question" type="button" role="tab" aria-controls="question" aria-selected="true">Questions</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="exam-tab" data-bs-toggle="tab" data-bs-target="#exam" type="button" role="tab" aria-controls="exam" aria-selected="false">Exams</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    {{-- Questions --}}
                    <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab">
                        <h4>Questions</h4>
                        <div class="mt-4">
                            @if($canEdit)
                                <a type="button" href="{{route('question.create', ['paperId'=> $paper->id, 'questionId'=> 0])}}" class="btn btn-primary addQuestion">
                                    <i class="bi bi-plus-lg"></i> Add New Question
                                </a>
                            @endif
                        </div>
                        <div class="divQuestion">
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

                    {{-- Exam --}}
                    <div class="tab-pane fade" id="exam" role="tabpanel" aria-labelledby="exam-tab">
                        <div class="divExams">
                            <h4>Examinations</h4>
                            <table class="table table-hover">
                                <tr>
                                    <th>S.No.</th>
                                    <th style="width:40%;">Class/Course Name </th>
                                    <th>Start DateTime</th>
                                    <th>End DateTime</th>
                                    <th>Duration(mins.)</th>
                                    <th>Action</th>
                                </tr>
                                @php
                                $notStarted = $exams->whereNull('start_datetime');
                                $active = $exams->whereNotNull('start_datetime')->whereNull('end_datetime');
                                $ended = $exams->whereNotNull('start_datetime')->whereNotNull('end_datetime');
                                $sn = 1;
                                @endphp
                                @if($notStarted->count() > 0)
                                    <tr>
                                        <th colspan="6" class="text-primary">
                                            Not Started
                                        </th>
                                    </tr>
                                    @foreach($notStarted as $item)
                                    @include('paper.showcomp.rowitem', ['item' => $item, 'sn' => $sn])
                                    @php($sn++)
                                    @endforeach
                                @endif
            
                                @if($active->count() > 0)
                                    <tr>
                                        <th colspan="6" class="text-success">
                                            Active
                                        </th>
                                    </tr>
                                    {{-- @php($sn = 1) --}}
                                    @foreach($active as $item)
                                        @include('paper.showcomp.rowitem', ['item' => $item, 'sn' => $sn])
                                        @php($sn++)
                                    @endforeach
                                @endif
            
                                @if($ended->count() > 0)
                                    <tr>
                                        <th colspan="6" class="text-danger">
                                            Ended
                                        </th>
                                    </tr>
                                    {{-- @php($sn = 1) --}}
                                    @foreach($ended as $item)
                                    @include('paper.showcomp.rowitem', ['item' => $item, 'sn' => $sn])
                                    @php($sn++)
                                    @endforeach
                                @endif

                                @foreach($exams as $item)
                               
                                @php($sn++)
                                @endforeach
                            </table>
                        </div>
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
                    <div><b>Are you sure to start the test?</b></div>

                    
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
                <h1 class="modal-title fs-5" id="endModalLabel">End Test?</h1>
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