@extends('layout.app')

@section('title')
    Question
@endsection

@section('head')
    <style>
        #container {
            /* width: 1000px; */
            margin: 20px auto;
        }
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 200px;
        }
        .ck-content .image {
            /* block images */
            max-width: 80%;
            margin: 20px auto;
        }
    </style>
@endsection

@section('content')
         <div class="col-md-12">

            <h4>Paper: {{$paper->name}}</h4>

            <h3>Create Question</h3>
            <div class="box box-info clearfix pad ">
                <form id="questionCreateForm" action="/paper/store" method="POST">
                    @csrf

                    
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }} clearfix">
                        <label for="type" class="col-sm-4 control-label">Answer Type</label>

                        <div class="col-sm-8">
                            <select id="type" type="text" class="form-control" name="type" value="{{ old('type') }}" required autofocus autocomplete="off">
                                <option value="1">Multi Choice</option>
                                <option value="2">Text Answer</option>
                            </select>

                            @if ($errors->has('type'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }} clearfix">
                        <label for="group" class="col-sm-4 control-label">Group</label>

                        <div class="col-sm-8">
                            <input id="group" type="text" class="form-control" name="group" value="{{ old('group') }}" 
                                autofocus autocomplete="off">

                            @if ($errors->has('group'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('group') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }} clearfix">
                        <label for="tag" class="col-sm-4 control-label">Tag</label>

                        <div class="col-sm-8">
                            <input id="tag" type="text" class="form-control" name="tag" value="{{ old('tag') }}"
                                autofocus autocomplete="on">

                            @if ($errors->has('tag'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('tag') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>



                     <h4>Question</h4>
                    <div id="container">
                        <textarea id="editorQuestion">
                        </textarea>
                    </div>
                 

                    <table id="optionTable" class="table" >
                        <tr>
                            <th><h4>Option Text</h4></th>
                            <th>Is Correct?</th>
                            <th>Actions</th>
                        </tr>
                        
                    </table>
                    <div>
                        <button id="addOption" type="button" class="btn btn-primary">Add Option</button>
                    </div>

                    <div class="clearfix pad"></div>
                    <div align="right">
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        <a type="button" class="btn btn-sm btn-warning" href="/">Cancel</a>
                    </div>
                </form>

                {{-- Template for option --}}
                <table id="optionTemplate" style="display:none;">
                    <tr class="optionSection">
                        <td>
                            <div>
                                <div class="editorOption">
                                </div>
                            </div>
                        </td>

                        <td>
                            <div>
                                <select type="text" class="isCorrect form-control" name="type" required>
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <button class="moveUp btn btn-primary" type="button" title="Move UP">↑</button>
                            <button class="moveDown btn btn-primary" type="button" title="Move DOWN">↓</button>
                            <button class="remove btn btn-danger" type="button" title="DELETE">X</button>
                        </td>
                    </tr>
                </div>
            </div>
        </div> 

       

        
       
@endsection


@section('scripts')

        <!--
            The "super-build" of CKEditor 5 served via CDN contains a large set of plugins and multiple editor types.
            See https://ckeditor.com/docs/ckeditor5/latest/installation/getting-started/quick-start.html#running-a-full-featured-editor-from-cdn
        -->
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>
        <!--
            Uncomment to load the Spanish translation
            <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/translations/es.js"></script>
        -->
        <script src="{{asset("js/ckeditorconfig.js")}}"></script>
        <script src="{{asset("js/questioncreate.js")}}"></script>


@endsection