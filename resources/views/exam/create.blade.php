@extends('layout.app')

@section('title')
    {{$paper->name}}
@endsection

@section('content')
        <div class="col-md-12">
            {{-- to block the window (show loading icon) on page load. need to ublock from js after document.ready--}}
            <?php $blockWindow = true;?>
            <h3>{{$paper['name']}}</h3>
            <div class="box box-info float-none pad ">
                <div class="col-md-12">
                    <div class="questionNumber mt-5">
                        @foreach($questions as $que)
                            <div class="">
                                <div class="float-start">
                                    {{$que->serial_number}}
                                </div>
                                <div class="float-start ms-2" >
                                    {!! htmlspecialchars_decode($que->description) !!}
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            @if(isset($que->options) && sizeof($que->options) > 0)
                                @foreach($que->options as $opt)
                                    <div class="form-check ms-5">
                                        <div class="float-start">
                                            <input class="form-check-input" type="radio" name="que_{{$que->id}}" value="none"/>
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
                          
                        @endforeach
                    </div>
                </div>
                <div class="col-md-9">
                   <div class="questionView">
                   </div>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            blockWindow();
            setTimeout(() => {
                unblockWindow();
            }, 1000);
        })
    </script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script src="{{asset("js/ckeditorconfig.js")}}"></script>
    <script src="{{asset("js/examcreate.js")}}"></script>
@endsection