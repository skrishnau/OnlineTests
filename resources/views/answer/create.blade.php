@extends('layout.app')

@section('title')
    {{$exam->paper->name}}
@endsection

@section('content')
    <div class="col-md-12">
        {{-- to block the window (show loading icon) on page load. need to ublock from js after document.ready--}}
        <?php $blockWindow = true;?>
        <input type="hidden" class="paperId" value="{{$exam->paper->id}}"/>
        <input type="hidden" class="examId" value="{{$exam->id}}"/>
        <input type="hidden" class="displayId" value="{{$exam->display}}"/>
        @if($isPreview)
            <div class="mb-1 text-center bg-warning">
                Examination Preview
            </div>
        @endif
        <div class="">
            <div class="float-start">
                <h3 class="">{{$exam->name}}</h3>
                <h3 class="">{{$exam->paper->name}}</h3>
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
        @php($sectionNo = 1)
        <div class="box box-info float-none pad ">
            <div class="col-md-12 mt-5">
                @if($exam->type == 1)
                <div class="queSection" data-sn = '{{$sectionNo}}'>
                    {{-- Anonymous type --}}
                    <div class="form-group{{ $errors->has('candidateName') ? ' has-error' : '' }} clearfix">
                        <label for="candidateName" class="col-sm-4 control-label">Name</label>
                        <div class="col-sm-8">
                            <input id="candidateName" type="text" class="form-control candidateName" name="candidateName" value="{{ old('candidateName') }}" required
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
                            <input id="candidateEmail" type="text" class="form-control candidateEmail" name="candidateEmail" value="{{ old('candidateEmail') }}" required
                                autofocus autocomplete="off">
                            @if ($errors->has('candidateEmail'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('candidateEmail') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @php($sectionNo++)
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
                    <h4>Questions</h3>
                </div>
                <div class="float-start">
                    {{-- @foreach($groups as $grp)
                        <div style="height:30px">
                            {{$grp->group}}
                        </div>
                    @endforeach --}}
                </div>
                @foreach($questions as $que)
                    <div class="questionRow queSection" id="questionRow{{$que->id}}" data-sn="{{$sectionNo}}">
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
                            <?php $hasMultipleRightAnswers = $que->options->where('is_correct', 1)->count() > 1; ?>
                            @foreach($que->options as $opt)
                                <div class="form-check ms-5 optionRow">
                                    <div class="float-start">
                                        @if(!$hasMultipleRightAnswers)
                                            <input class="form-check-input" type="radio" name="que_{{$que->id}}" value="{{$opt->id}}"/>
                                        @else
                                            <input class="form-check-input" type="checkbox" name="que_{{$que->id}}" value="{{$opt->id}}"/>
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
                    @php($sectionNo++)
                @endforeach
            </div>
            <div class="col-md-12 mt-5">
                <hr>
                <div align="right">
                    <button type="button" class="btn btn-primary examSubmit {{$isPreview ? "disabled" : ""}}">Submit</button>
                </div>
            </div>
            
            <div class="col-md-12 mt-5">
                <hr>
                <div align="right">
                    <button type="button" class="btn btn-primary examPrevious" disabled>Previous</button>
                    <button type="button" class="btn btn-primary examNext">Next</button>
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