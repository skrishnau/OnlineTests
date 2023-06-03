@php
$linkUrl = route('answer.create', ['examId' => $item->examId, 'code'=> $item->examLinkId]);
@endphp
<tr>
    <td>
        {{$sn}}
    </td>
    <td>
        {{-- <a class="text-decoration-none " href="{{route('exam.show', ['examId' => $item->id])}}">{{$item->ExamName}}</a> --}}
        <a class="testLink text-decoration-none" href="{{$linkUrl}}">{{$item->examName}}</a>
    </td>
    <td>
        <a class="testLink text-decoration-none" href="{{$linkUrl}}">{{$item->paperName}}</a>
    </td>
    <td>
        {{$item->startDatetime}}
    </td>
    <td>
        {{$item->endDatetime}}
    </td>
    {{-- <td>
        {{$item->durationInMins}}
    </td> --}}
    <td>
        <a href="{{$linkUrl}}">View</a> 
    </td>
</tr>