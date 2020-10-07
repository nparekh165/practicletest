@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Address</h2>
            </div>
            <div class="pull-right">
                @can('useraddress-create')
                <a class="btn btn-success" href="{{ route('useraddress.create') }}"> Create New Product</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Address</th>
            <th>User</th>
            <th>Defult</th>
            <th width="280px">Action</th>
        </tr>

	    @foreach ($useraddresss as $useraddress)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $useraddress->address }}</td>
            <td>{{ $useraddress->user["name"] }}</td>
	        <td>
                @if($useraddress->isprimary=='1')
                    Defult
                @else
                    
                @endif

            </td>
	        <td>
                <form action="{{ route('useraddress.destroy',$useraddress->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('useraddress.show',$useraddress->id) }}">Show</a>
                    @can('useraddress-edit')
                    <a class="btn btn-primary" href="{{ route('useraddress.edit',$useraddress->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('useraddress-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $useraddresss->links() !!}

@endsection