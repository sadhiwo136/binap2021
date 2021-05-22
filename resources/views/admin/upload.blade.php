@extends('layouts.master')

@section('title')
    Upload Document | PSU App Prototype
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Document Feature 
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add</button> -->
                </h5>
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                    </div>
                @endif
            </div>
            <!-- <div class="container">
                <form action="/search-abouts" method="POST" role="search">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="q"
                            placeholder="Search description..."> <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">                                
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div> -->
            <style>
                .w-10p
                {
                    width: 10% !important;
                }
            </style>
            
            <div class="card-body">
                <div class="table-responsive">                    
                    <!-- <table id="mytable" class="table table-striped">
                        
                    </table> -->
                    <form action="/upload/proses" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div>                
                            <input type="file" name="fileku" class="form-control">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>                        
                    </form>
                    <table id="mytable" class="table table-striped">
                        <thead class=" text-primary">                            
                            <th>File</th>
                            <th class="text-center" colspan="2">Actions</th>                        
                        </thead>
                        <tbody>
                            @foreach ($documents as $row)
                                <tr>                                    
                                    <td> {{ $row->file_name }}</td>
                                    <td class="text-center">
                                            @if($row->ext != "docx")
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal{{$row->id}}">Open</button>
                                            @else
                                            <a href="files/{{$row->file_name}}" class="btn btn-success">Open</a>
                                            @endif
                                        
                                            <div id="myModal{{$row->id}}" class="modal fade" role="dialog">
                                                <div class="modal-dialog modal-lg">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        
                                                        <div class="modal-header">				
                                                            <h5 class="modal-title">Document View</h5>
                                                        </div>
                                                        
                                                        <div class="modal-body">

                                                            <embed src="{{ url('files/'.$row->file_name) }}" frameborder="0" width="100%" height="400px">

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ url('upload-delete/'.$row->id) }}" method="post">
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
                </div>
            </div>            
            
        </div>
    </div>
</div>    
@endsection

@section('scripts')
    <!-- <script>
        $(document).ready( function () {
            $('#mytable').DataTable();
        } );
    </script> //baru jalan kalo foreach table mysqlnya dihapus semua -->
    
@endsection