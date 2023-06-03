@extends('layout.app')

@section('title')
    User
@endsection


@section('heading')
{{isset($user)? "Edit" : "Create"}} User
@endsection

@section('content')
        <div class="col-md-8">
            <div class="box box-info clearfix pad mt-4">
                <form action="/user/store" method="POST" class="formUserCreate">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{old('id'), $user?->id}}"/>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} clearfix">
                        <label for="name" class="col-sm-4 control-label">Name</label>
                        <div class="col-sm-8">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user?->name) }}" required
                                autofocus autocomplete="off">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} clearfix">
                        <label for="uEmail" class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-8">
                            <input id="uEmail" type="text" class="form-control" name="uEmail" value="{{ old('email', $user?->email) }}" required
                                autofocus autocomplete="off">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }} clearfix">
                        <label for="role" class="col-sm-4 control-label">Role</label>
                        <div class="col-sm-8">
                            <select id="role" type="text" class="form-control" name="role" value="{{ old('role', $user?->role) }}" required
                                autofocus autocomplete="off">
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                            </select>
                            @if ($errors->has('role'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} clearfix">
                        <label for="uPassword" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-8">
                            <input id="uPassword" type="password" class="form-control" name="uPassword" value="{{ old('password', $user?->password) }}" required
                                autofocus autocomplete="off">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('confirmPassword') ? ' has-error' : '' }} clearfix">
                        <label for="confirmPassword" class="col-sm-4 control-label">Confirm Password</label>
                        <div class="col-sm-8">
                            <input id="confirmPassword" type="password" class="form-control" name="confirmPassword" value="{{ old('confirmPassword', $user?->confirmPassword) }}" required
                                autofocus autocomplete="off">

                            @if ($errors->has('confirmPassword'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('confirmPassword') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>


                    <div class="clearfix pad"></div>
                    <div align="right">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a type="button" class="btn btn-warning" href="{{$user ? route("user.show", $user->id) : route("user.index")}}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
@endsection

@section('scripts')
    <script src="{{asset("js/usercreate.js")}}"></script>
@endsection