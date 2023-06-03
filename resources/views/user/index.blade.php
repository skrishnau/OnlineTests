@extends('layout.app')

@section('title')
    Users
@endsection

@section('heading')
Users
@endsection

@section('content')
        <div class="col-md-12">
            <div>
                <div class="float-end">
                    <a href="{{route('user.create')}}" class="btn btn-primary">Add New User</a>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="box box-info clearfix pad mt-4">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>S.No.</th>
                        <th style="width:40%;">Name </th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    @php($sn=1)
                    @foreach($users as $item)
                        <tr>
                            <td>
                                {{$sn}}
                            </td>
                            <td>
                                <a class="text-decoration-none " href="{{route('user.show', ['id' => $item->id])}}">{{$item->name}}</a>
                            </td>
                            <td>
                                {{$item->role}}
                            </td>
                            <td>
                                <a href="{{route('user.show', ['id' => $item->id])}}">View</a>
                            </td>
                        </tr>
                        @php($sn++)
                    @endforeach
                </table>
               
            </div>
        </div>
@endsection