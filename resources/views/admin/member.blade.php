@extends('layouts.master')

@section('title')
    Registered Members | PSU App Prototype
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Registered Members
                    <a href="/register" class="btn btn-primary">Add</a>
                </h4>
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ (session('status')) }}
                    </div>
                @endif

            </div>
            <div class="container">
                <form action="/search-member" method="POST" role="search">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="q"
                            placeholder="Search member..."> <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="mytable" class="table table-striped">
                        <thead class=" text-primary">
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th class="text-center" colspan="2">Actions</th>                        
                        </thead>
                        <tbody>
                            @foreach ($users as $row)
                                <tr>
                                    <td> {{ $row->name }}</td>
                                    <td> {{ $row->phone }}</td>
                                    <td> {{ $row->email }}</td>
                                    <td> {{ $row->usertype }}</td>
                                    <td><a href="/role-edit/{{ $row->id }}" class="btn btn-success">Edit</a></td>
                                    <td>
                                        <form action="/role-delete/{{ $row->id }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger" onclick='return confirm("Are you sure?")'>Delete</button>
                                        </form>
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach                
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection

@section('scripts')
    <script>
        $(document).ready( function () {
            $('#mytable').DataTable();
        } );
    </script>
@endsection