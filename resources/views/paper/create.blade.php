@extends('layout.app')

@section('title')
    Question Paper
@endsection


@section('heading')
{{isset($paper)? "Edit" : "Create"}} Question Paper
@endsection

@section('content')
        <div class="col-md-8">
            <div class="box box-info clearfix pad mt-4">
                <form action="/paper/store" method="POST">
                    {{-- {!! Form::open(array('route'=>'paper.store' ))!!} --}}
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{old('id'), $paper?->id}}"/>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} clearfix">
                        <label for="name" class="col-sm-4 control-label">Name</label>

                        <div class="col-sm-8">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $paper?->name) }}" required
                                autofocus autocomplete="off">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3 form-group{{ $errors->has('each_marks') ? ' has-error' : '' }} clearfix">
                        <label for="eachMarks" class="col-sm-8 control-label">Each Question Marks <small class="text-muted">(Can be changed in each question)</small></label>

                        <div class="col-sm-8">
                            <input id="eachMarks" type="text" class="form-control" name="eachMarks" value="{{ old('each_marks', $paper?->each_marks) }}" required
                                autofocus autocomplete="off">

                            @if ($errors->has('each_marks'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('each_marks') }}</strong>
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