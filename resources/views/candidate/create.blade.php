@extends('layout.app')

@section('title')
    Candidate
@endsection

@section('content')
        <div class="col-md-8">

            <div>
                <h3 class="float-start">{{isset($candidate)? "Edit" : "Create"}} Candidate</h3>
                <div class="clearfix"></div>
            </div>

            <div class="box box-info clearfix pad mt-4">
                <form action="/candidate/store" method="POST">
                    {{-- {!! Form::open(array('route'=>'paper.store' ))!!} --}}
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{old('id'), $candidate?->id}}"/>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} clearfix">
                        <label for="name" class="col-sm-4 control-label">Name</label>

                        <div class="col-sm-8">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $candidate?->name) }}" required
                                autofocus autocomplete="off">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix pad"></div>
                    <div align="right">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a type="button" class="btn btn-warning" href="{{$candidate ? route("candidate.show", $paper->id) : route("candidate.index")}}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
@endsection