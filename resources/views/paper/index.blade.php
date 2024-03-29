@extends('layout.app')

@section('title')
    Question Paper
@endsection

@section('heading')
Question Papers
@endsection

@section('content')
        <div class="col-md-12">
            <div>
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
                        <th>Action</th>
                    </tr>
                    @php($sn=1)
                    @foreach($papers as $item)
                        <tr>
                            <td>
                                {{$sn}}
                            </td>
                            <td>
                                <a class="text-decoration-none " href="{{route('paper.show', ['id' => $item->id])}}">{{$item->name}}</a>
                            </td>
                            <td>
                                <a href="{{route('paper.show', ['id' => $item->id])}}">View</a>
                            </td>
                        </tr>
                        @php($sn++)
                    @endforeach
                </table>
               
            </div>
        </div>
@endsection