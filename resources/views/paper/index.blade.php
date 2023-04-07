@extends('layout.app')

@section('title')
    Question Paper
@endsection

@section('content')
        <div class="col-md-12">

            <div>
                <h3 class="float-start">Question Papers</h3>
                <div class="float-end">
                    <a href="{{route('paper.create')}}" class="btn btn-primary">Add New Question Paper</a>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="box box-info clearfix pad mt-4">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>S.No.</th>
                        <th style="width:40%;">Name </th>
                        {{-- <th>Start DateTime</th>
                        <th>End DateTime</th>
                        <th>Duration(mins.)</th> --}}
                        <th>Action</th>
                    </tr>

                    @php
                        $notStarted = $papers->whereNull('startDatetime');
                        $active = $papers->whereNotNull('startDatetime')->whereNull('endDatetime');
                        $ended = $papers->whereNotNull('startDatetime')->whereNotNull('endDatetime');
                        $sn = 1;
                    @endphp
                    @if($notStarted->count() > 0)
                        <tr>
                            <th colspan="6" class="text-primary">
                                Not Started
                            </th>
                        </tr>
                        @foreach($notStarted as $item)
                        @include('paper.indexcomp.rowitem', ['item' => $item, 'sn' => $sn])
                        @php($sn++)
                        @endforeach
                    @endif

                    @if($active->count() > 0)
                        <tr>
                            <th colspan="6" class="text-success">
                                Active
                            </th>
                        </tr>
                        {{-- @php($sn = 1) --}}
                        @foreach($active as $item)
                            @include('paper.indexcomp.rowitem', ['item' => $item, 'sn' => $sn])
                            @php($sn++)
                        @endforeach
                    @endif

                    @if($ended->count() > 0)
                        <tr>
                            <th colspan="6" class="text-danger">
                                Ended
                            </th>
                        </tr>
                        {{-- @php($sn = 1) --}}
                        @foreach($ended as $item)
                        @include('paper.indexcomp.rowitem', ['item' => $item, 'sn' => $sn])
                        @php($sn++)
                        @endforeach
                    @endif
                </table>
               
            </div>
        </div>
@endsection