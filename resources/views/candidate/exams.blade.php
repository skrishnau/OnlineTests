@extends('layout.app')

@section('title')
    My Exams
@endsection

@section('heading')
My Exams
@endsection

@section('content')
    <div class="divExams">
        <h4>Examinations</h4>
        <table class="table table-hover">
            <tr>
                <th>S.No.</th>
                <th>Class</th>
                <th>Paper </th>
                <th>Start DateTime</th>
                <th>End DateTime</th>
                {{-- <th>Duration(mins.)</th> --}}
                <th>Action</th>
            </tr>
            @php
            // $dt = date('Y-m-d')
             $active = $exams;//->whereNull('start_datetime')->where('examDatetime', '>=', $dt)->get();
            //$active = $exams->whereNotNull('startDatetime')->whereNull('end_datetime');
            //$ended = $exams->whereNotNull('startDatetime')->whereNotNull('endDatetime');
            $sn = 1;
            @endphp
           

            @if($active->count() > 0)
                {{-- <tr>
                    <th colspan="6" class="text-success">
                        Active
                    </th>
                </tr> --}}
                @foreach($active as $item)
                    @include('candidate.examscomp.rowitem', ['item' => $item, 'sn' => $sn])
                    @php($sn++)
                @endforeach
            @endif

            {{-- @if($ended->count() > 0)
                <tr>
                    <th colspan="6" class="text-danger">
                        Ended
                    </th>
                </tr>
                @foreach($ended as $item)
                @include('candidate.examscomp.rowitem', ['item' => $item, 'sn' => $sn])
                @php($sn++)
                @endforeach
            @endif --}}
        </table>
    </div>
@endsection


@section('scripts')
        
    <script src="{{asset("js/examshow.js")}}"></script>

@endsection