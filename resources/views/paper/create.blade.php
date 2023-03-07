@extends('layout.app')

@section('title')
    Question Paper
@endsection

@section('content')
        <div class="col-md-8">

            <div>
                <h3 class="float-start">Create Question Paper</h3>
                <div class="clearfix"></div>
            </div>

            <div class="box box-info clearfix pad ">
                <form action="/paper/store" method="POST">
                    {{-- {!! Form::open(array('route'=>'paper.store' ))!!} --}}
                    @csrf
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} clearfix">
                        <label for="name" class="col-sm-4 control-label">Name</label>

                        <div class="col-sm-8">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required
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
                        <a type="button" class="btn btn-warning" href="/">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
@endsection