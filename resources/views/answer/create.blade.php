@extends('layout.app')

@section('title')
    {{$paper->name}}
@endsection

@section('content')
    <div class="col-md-12">
        {{-- to block the window (show loading icon) on page load. need to ublock from js after document.ready--}}
        <?php $blockWindow = true;?>
        <input type="hidden" class="paperId" value="{{$paper->id}}"/>
        <input type="hidden" class="examId" value="{{$exam->id}}"/>
        <input type="hidden" class="displayId" value="{{$exam->display}}"/>
        <input type="hidden" class="isAnswer" value="{{$isAnswer}}"/>
        <input type="hidden" class="startDatetime" value="{{$candidate?->startDatetime}}"/>
        <input type="hidden" class="candidateId" value="{{$candidate?->id}}"/>
        @php
            $isSingleDisplay = (($exam->display === 2) || ($exam->display === 3)) ? "true" : "false";
            $isGroupDisplay = $exam->display == 3 ? "true" : "false";
        @endphp
        <input type="hidden" class="isSingleDisplay" value="{{$isSingleDisplay}}" />
        <input type="hidden" class="isGroupDisplay" value="{{$isGroupDisplay}}" />
        
        @if($isPreview)
            <div class="mb-1 text-center bg-warning">
                Examination Preview
            </div>
            {{-- <div>
                <button class="btnToggleDisplay">Toggle Display</button>
            </div> --}}
        @endif
        <div class="">
            <div class="float-start">
                <h3 class="">{{$exam->name}}</h3>
                <h3 class="">{{$paper->name}}</h3>
            </div>
            <div class="float-end" >
                Questions: {{$questions->count()}}
                {{-- <br>
                Deadline: 
                <br>
                Started On:
                <br> --}}
                <div> 
                    Time: <span class="timer"></span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <?php 
        $sectionIndex = 0;
        $showConfirm = !$isPreview && !$isAnswer;
        ?>

        <div class="box box-info float-none pad confirmSection text-center" style="{{$showConfirm ? "" : "display:none;"}}">
            <button class="btn btn-success btnStartExam">Start Exam</button>
        </div>
        <div class="box box-info float-none pad examSection" style="{{$showConfirm ? "display:none;" : ""}}">
            <?php
            $groups = $questions->groupBy('group');
            //var_dump($groups->toArray());
            $grpBtnSN = 1;
            ?>
           
            <div class="col-md-12 mt-5">
                <table style="width:99%;">
                    <tr>
                        @if($isGroupDisplay == "true")
                        <td width="22px">
                            <div class="d-flex align-items-start disabled" >
                                <div class="disabled nav flex-column nav-pills me-3 divGroupButtons" id="v-pills-tab" role="tablist" aria-orientation="vertical" >
                                    @foreach($groups as $grp=>$val)
                                        <button disabled style="width:22px;padding-right:0rem;" class="btnGroup vertical-text nav-link {{$grpBtnSN == 1 ? "active" : ""}}" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true" title="{{$grp}}" data-group="{{$grp}}">{{substr($grp,0, 5)}}</button>
                                        @php($grpBtnSN++)
                                    @endforeach
                                  {{-- <button class="vertical-text nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</button> --}}
                                </div>
                              
                            </div>
                           {{--  <div class="float-start" >
                                @foreach($groups as $grp=>$val)
                                    <div style="writing-mode: vertical-rl;text-orientation: upright;" title="{{$grp}}">
                                       {{substr($grp,0, 5)}}
                                    </div>
                                    <hr>
                                @endforeach 
                            </div>--}}
                        </td> 
                        @endif

                        <td style="text-align:start; vertical-align: top;">
                            <div class="" style="width:100%;">
                                @if($exam->type == 1)
                                <div class="queSection" data-index = '{{$sectionIndex}}'>
                                    {{-- Anonymous type --}}
                                    <div class="form-group{{ $errors->has('candidateName') ? ' has-error' : '' }} clearfix">
                                        <label for="candidateName" class="col-sm-4 control-label">Name {{$candidate->name}}</label>
                                        <div class="col-sm-8">
                                            
                                            <input id="candidateName" type="text" class="form-control candidateName" name="candidateName" value="{{ old('candidateName', $candidate->name) }}" required
                                                autofocus autocomplete="off">
                                            @if ($errors->has('candidateName'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('candidateName') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('candidateEmail') ? ' has-error' : '' }} clearfix">
                                        <label for="candidateEmail" class="col-sm-4 control-label">Email</label>
                                        <div class="col-sm-8">
                                            <input id="candidateEmail" type="text" class="form-control candidateEmail" name="candidateEmail" value="{{ old('candidateEmail', $candidate->email) }}" required
                                                autofocus autocomplete="off">
                                            @if ($errors->has('candidateEmail'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('candidateEmail') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php($sectionIndex++)
                                @endif
                                {{-- <div class="form-group{{ $errors->has('candidateId') ? ' has-error' : '' }} clearfix">
                                    <label for="candidateId" class="col-sm-4 control-label">ID/Roll</label>
                                    <div class="col-sm-8">
                                        <input id="candidateId" type="text" class="form-control candidateId" name="email" value="{{ old('candidateId') }}" required
                                            autofocus autocomplete="off">
            
                                        @if ($errors->has('candidateId'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('candidateId') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div> --}}
            
                                <div class="mt-4 mb-4">
                                    {{-- <h4>Questions</h3> --}}
                                </div>
                            
                                @foreach($questions as $que)
                                    <div class="questionRow queSection" id="questionRow{{$que->id}}" data-index="{{$sectionIndex}}" data-group="{{$que->group}}">
                                        <input type="hidden" class="questionId" value="{{$que->id}}"/>
                                        <input type="hidden" name="serialNumber" class="serialNumber" value="{{$que->serial_number}}"/>
                                        <div class="">
                                            <div class="float-start">
                                                <input type="hidden" name="questionId" class="questionId"/>
                                                <b>{{$que->serial_number}}.</b>
                                            </div>
                                            <div class="float-start ms-2" >
                                                {!! htmlspecialchars_decode($que->description) !!}
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        @if(isset($que->options) && sizeof($que->options) > 0)
                                            <?php $hasMultipleRightAnswers = $que->options->where('is_correct', 1)->count() > 1; 
                                            
                                            ?>
                                            @foreach($que->options as $opt)
                                            <?php $isSelected = $opt->id == $que->selected_option_id;
                                            $isCorrectAnswer = $que->is_correct && $isSelected;
                                            ?>
                                                <div class="form-check ms-5 optionRow ">
                                                    {{-- @if($isCorrectAnswer)
                                                    <div class="float-start bg-success border border-2 border-success">
                                                        &nbsp;  &nbsp;  &nbsp;  &nbsp;
                                                    </div> 
                                                    @endif --}}
                                                    <div class="float-start {{$isCorrectAnswer ? "p-1 bg-success border border-1 border-success" : ""}}">
                                                        @if(!$hasMultipleRightAnswers)
                                                            <input class="form-check-input" type="radio" name="que_{{$que->id}}" value="{{$opt->id}}" {{$isSelected ? "checked": ""}}/>
                                                        @else
                                                            <input class="form-check-input" type="checkbox" name="que_{{$que->id}}" value="{{$opt->id}}"  {{$isSelected ? "checked": ""}}/>
                                                        @endif
                                                    </div>
                                                    <div class="float-start ms-1">
                                                        {!! html_entity_decode($opt->description) !!}
                                                    </div>
                                                    <div class="clearfix">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div>
                                                <textarea class="editorAnswer" id="editorAnswer{{$que->id}}"></textarea>
                                            </div>
                                        @endif
                                    </div>
                                    @php($sectionIndex++)
                                @endforeach
                            </div>
                        </td>
                    </tr>
                </table>
                
               
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 mt-5">
                <hr>
                <div align="right">
                    <span class="divSubmit">
                        <button type="button" class="btn btn-success examSubmit {{$isPreview ? "disabled" : ""}}">Submit</button>
                    </span>
                    <span class="divNextPrevious">
                        <button type="button" class="btn btn-primary examPrevious" disabled>Previous</button>
                        <button type="button" class="btn btn-primary examNext">Next</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        
    </script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script src="{{asset("js/ckeditorconfig.js")}}"></script>
    <script src="{{asset("js/answercreate.js")}}"></script>
@endsection