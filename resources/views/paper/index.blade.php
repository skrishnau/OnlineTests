@extends('layout.app')

@section('title')
    Question Paper
@endsection

@section('content')
        <div class="col-md-12">

            <h3>Question Papers</h3>
            <div>
                <a href="{{route('paper.create')}}" class="btn btn-primary">Add New Question Paper</a>
            </div>
            <div class="box box-info clearfix pad ">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th style="width:40%;">Name </th>
                        <th>Start DateTime</th>
                        <th>Duration(mins.)</th>
                        <th>Action</th>
                    </tr>
                    @foreach($papers as $item)
                        <tr>
                            <td>
                                {{$item->name}}
                            </td>
                            <td>
                                {{$item->startDateTime}}
                            </td>
                            <td>
                                {{$item->durationInMins}}
                            </td>
                            <td>
                                <a href="{{route('paper.show', ['id' => $item->id])}}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
               
            </div>
        </div>
@endsection