<tr>
    <td>
        {{$sn}}
    </td>
    <td>
        <a class="text-decoration-none " href="{{route('paper.show', ['id' => $item->id])}}">{{$item->name}}</a>
    </td>
    <td>
        {{$item->startDatetime}}
    </td>
    <td>
        {{$item->endDatetime}}
    </td>
    <td>
        {{$item->durationInMins}}
    </td>
    <td>
        <a href="{{route('paper.show', ['id' => $item->id])}}">View</a>
    </td>
</tr>