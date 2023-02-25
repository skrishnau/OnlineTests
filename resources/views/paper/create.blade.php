@extends('layout.app')

@section('title')
    Question Paper
@endsection

@section('content')
        <div class="col-md-8">

            <h3>Create Question Paper</h3>
            <div class="box box-info clearfix pad ">
                <form action="/paper/store" method="POST">
                    {{-- {!! Form::open(array('route'=>'paper.store' ))!!} --}}
                    {{-- <input hidden name="subject_id" value="{{$_GET['subject']}}"> --}}
                    @csrf
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} clearfix">
                        <label for="name" class="col-sm-4 control-label">Name</label>

                        <div class="col-sm-8">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required
                                autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }} clearfix">
                        <label for="desc" class="col-sm-4 control-label">Description</label>
                        <div class="col-sm-8">
                            <textarea id="desc" type="text" class="form-control" name="desc" value="{{ old('desc') }}"
                                    required autofocus></textarea>
                            @if ($errors->has('desc'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('desc') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div> }}
                    <div class="form-group{{ $errors->has('min_marks') ? ' has-error' : '' }} clearfix">
                        <label for="min_marks" class="col-sm-4 control-label">Min. Marks</label>
                        <div class="col-sm-8">
                            <input id="min_marks" type="number" class="form-control" name="min_marks" value="{{ old('min_marks') }}"
                                    required autofocus>
                            {{-- @if ($errors->has('min_marks'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('min_marks') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('max_marks') ? ' has-error' : '' }} clearfix">
                        <label for="max_marks" class="col-sm-4 control-label">Max. Marks</label>
                        <div class="col-sm-8">
                            <input id="max_marks" type="number" class="form-control" name="max_marks" value="{{ old('max_marks') }}"
                                    required autofocus>
                            @if ($errors->has('max_marks'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('max_marks') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div> --}}

                    <div class="clearfix pad"></div>
                    <div align="right">
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        {{-- {{Form::submit('Save Chapter', array('class'=>'btn btn-sm btn-primary ','title'=>'Save the Chapter'))}} --}}
                        <a type="button" class="btn btn-sm btn-warning" href="/">Cancel</a>
                        {{-- {!! Form::close() !!} --}}

                    </div>
                </form>
            </div>
        </div>
@endsection