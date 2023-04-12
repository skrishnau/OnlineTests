@extends('layout.app')

@section('title')
    {{$exam->paper->name}}
@endsection

@section('content')
    <input type="hidden" id="paperId" value="{{$exam->paper->id}}"/>
    <input type="hidden" id="examId" value="{{$exam->id}}"/>
        <div class="col-md-12">
            <div>
                <div class="float-start">
                    <h3 class="">{{$exam->course->name}}</h3>
                    <h5 class="">{{$exam->paper->name}}</h5>
                </div>
                <div class="float-end">
                    <?php 
                    $canShowStartBtn = !isset($exam->start_datetime); 
                    $canShowEndBtn = isset($exam->start_datetime) && !isset($exam->end_datetime);
                    ?>
                    @if($canShowStartBtn)
                        <button type="button" class="btn btn-success btnStartExam">Start Test</button>
                        <button type="button" class="btn btn-light btnDelete">
                            <i class="bi bi-trash"></i>
                            Delete
                        </button>
                    @endif
                    <button type="button" class="btn btn-danger btnEndExam" data-bs-toggle="modal" data-bs-target="#endModal" style="display:{{$canShowEndBtn ? "inline" : "none" }};">End Test</button>
                    <a type="button" href="{{route('answer.create', ['examId'=> $exam->id, 'paperId'=> $exam->paper->id, 'show' => 'preview'])}}" class="btn btn-primary">
                        <i class="bi bi-file-earmark-minus-fill"></i> Preview
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class=" ">
                Exam Link: <a class="testLink text-decoration-none" href="{{$linkUrl}}">{{$linkUrl}}</a>
                <br/>
                Started On : <b class="lblStartDatetime">{{$exam->start_datetime}}</b>
                <br/>
                Ended On: <b class="lblEndDatetime">{{$exam->end_datetime}}</b>
                <br/>
                Type: 
            </div>
            

            <div class="box box-info clearfix pad mt-4">
                <h4>Candidates</h4>
                <button type="button" class="btn btn-primary" >
                    Add New Candidate
                </button>
                <table class="table table-hover">
                    <tr>
                        <th>S.No.</th>
                        <th style="width:40%;">Candidates </th>
                        <th>Score</th>
                        <th>Start DateTime</th>
                        <th>Duration(mins.)</th>
                        <th>Action</th>
                    </tr>
                    @php($sn = 1)
                    @foreach($candidates as $item)
                    <tr>
                        <td>
                            {{$sn}}
                        </td>
                        <td>
                            <a class="text-decoration-none " href="{{route('candidate.show', ['id' => $item->id])}}">{{$item->candidate_name}}</a>
                        </td>
                        <td>
                            {{$item->score}}
                        </td>
                        <td>
                            {{$item->startDatetime}}
                        </td>
                        <td>
                            {{$item->durationInMins}}
                        </td>
                        <td>
                            <a href="{{route('candidate.show', ['id' => $item->id])}}">View</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
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
@endsection


@section('scripts')
        
    <script src="{{asset("js/examshow.js")}}"></script>

@endsection