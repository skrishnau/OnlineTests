@extends('layout.app')

@section('title')
    {{$paper->name}}
@endsection

@section('content')

<div class="col-md-12">
    <div class="box box-info float-none pad ">
        <form method="POST" action="{{route('exam.store')}}" class="formExamCreate">
            <h4>Create Exam</h4>
            <input type="hidden" value="{{$paper->id}}" class="paperId" />
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} clearfix mt-4">
                <label for="name" class="col-sm-4 control-label">Examination Name <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <input id="name" type="text" class="form-control name" name="name" value="{{ old('name') }}" required
                        autofocus autocomplete="off">
            
                    @if ($errors->has('name'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }} clearfix mt-4">
                <label for="name" class="col-sm-4 control-label">Take Type<i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <select id="type" class="form-control type" name="type" value="{{ old('type') }}" required
                        autofocus autocomplete="off">
                        <option value="1">Anonymous</option>
                        <option value="2">Authorized</option>
                    </select>
                    @if ($errors->has('type'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                    @endif
                </div>
            </div>

            
            <div class="form-group{{ $errors->has('display') ? ' has-error' : '' }} clearfix mt-4">
                <label for="name" class="col-sm-4 control-label">Display Type<i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <select id="display" class="form-control display" name="display" value="{{ old('display') }}" required
                        autofocus autocomplete="off">
                        <option value="1">All Question in a Single Page</option>
                        <option value="2">One Question at a time</option>
                        <option value="3">Grouping. One Question at a time</option>
                    </select>
                    @if ($errors->has('display'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('display') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="clearfix pad"></div>
            <div align="right">
                <button type="submit" class="btn btn-primary">Save</button>
                <a type="button" class="btn btn-warning" href="{{$paper ? route("paper.show", $paper->id) : route("paper.index")}}">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection


@section('scripts')
    <script>
        
    </script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script> --}}
    {{-- <script src="{{asset("js/ckeditorconfig.js")}}"></script> --}}
    <script src="{{asset("js/examcreate.js")}}"></script>
@endsection