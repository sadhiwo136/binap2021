@extends('layouts.master')

@section('title')
    Descriptions | PSU App Prototype
@endsection

@section('content')

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add description about us.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/save-description" method="POST">
        {{ csrf_field() }}

        <div class="modal-body">        
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Title:</label>
                <input type="text" name="title" class="form-control" id="recipient-name">
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Subtitle:</label>
                <input type="text" name="subtitle" class="form-control" id="recipient-name">
            </div>
            <div class="form-group">
                <label for="message-text" class="col-form-label">Description:</label>
                <textarea name="description" class="form-control" id="message-text"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save!</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Description List 
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add</button>
                </h5>
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if(!empty($successMsg))
                    <div class="alert alert-success"> {{ $successMsg }}</div>
                @endif
            </div>
            <div class="container">
                <form action="/search-abouts" method="POST" role="search">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="q"
                            placeholder="Search description..."> <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <!-- <span class="glyphicon glyphicon-search"></span> -->
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            <style>
                .w-10p
                {
                    width: 10% !important;
                }
            </style>
            <div class="card-body">
                <div class="table-responsive">
                    
                    <table id="mytable" class="table table-striped">
                        <thead class=" text-primary">                        
                            <th class="w-10p">Title</th>
                            <th class="w-10p">Subtitle</th>
                            <th class="w-10p">Description</th>
                            <th class="text-center w-10p" colspan="2">Actions</th>
                        </thead>
                        <tbody>
                            @foreach($abouts as $data)
                            <tr>                            
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->subtitle }}</td>
                                <td>
                                    <!-- <div style="height:80px; overflow: hidden;"> -->
                                        {{ $data->description }}
                                    <!-- </div> -->
                                </td>
                                <td class="text-center"><a href="{{ url('abouts/'.$data->id) }}" class="btn btn-success">Edit</a></td>
                                <td class="text-center">
                                    <form action="{{ url('abouts-delete/'.$data->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger" onclick='return confirm("Are you sure?")'>Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach                
                        </tbody>
                    </table>
                    {{ $abouts->links() }}
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