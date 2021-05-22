@extends('layouts.master')

@section('title')
    Daftar Proyek | PSU App Prototype
@endsection

@section('content')
<style>
    .modal-lg {
        max-width: 80%;
    }    
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Proyek Terdaftar 
                    @if(Auth::user()->usertype == 'developer')
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add</button> -->
                    @endif
                </h5>
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if(session('status2'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('status2') }}
                    </div>
                @endif
            </div>
            <div class="container">
                <!-- <form action="/search-company" method="POST" role="search">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="q"
                            placeholder="Cari perusahaan..."> <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">                                
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                            </button>
                        </span>
                    </div>
                </form> -->
            </div>
            <style>
                .w-10p
                {
                    width: 10% !important;
                }
                .w-14p
                {
                    width: 14% !important;
                }
            </style>
            <div class="card-body">
                <div class="table-responsive">                    
                    <table id="mytable" class="table table-striped">
                        <thead class="text-primary">           
                            <th class="text-center w-13p">Tgl Masuk</th>             
                            <th class="text-center w-13p">Lokasi</th>
                            <th class="text-center w-13p">Perusahaan</th>
                            <th class="text-center w-13p">Kota</th>
                            <th class="text-center w-13p">Status</th>
                            <th class="text-center w-13p" colspan="2">Action</th>
                        </thead>
                        <tbody>
                            @foreach($projects as $data)
                            <tr>
                                <td class="text-center w-13p">{{ $data->tgl_entri }}</td>
                                <td class="text-center w-13p">{{ $data->lokasi }}</td>
                                <td class="text-center w-13p">{{ $data->namaku }}</td>
                                <td class="text-center w-13p">{{ $data->kotaku }}</td>
                                @switch($data->status_thp_terakhir)
                                @case (1)
                                    <td class="text-center w-13p" id="st">Dalam Pengerjaan</td>
                                    @break
                                @case (2)
                                    <td class="text-center w-13p" id="st">Selesai</td>
                                    @break
                                @case (3)
                                    <td class="text-center w-13p" id="st">Berhenti</td>
                                    @break
                                @default
                                <td class="text-center w-13p" id="st">-</td>                                                         
                                @endswitch                                
                                <td class="text-center w-13p"><a href="/proyek_info/{{ $data->id }}" class="btn btn-info">Open</a></td>
                                <td class="text-center w-13p"><a href="/delete_proyek/{{ $data->id }}" class="btn btn-danger" role="button" onclick='return confirm("Mau menghapus data proyek?")'>Delete</a></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
        
</script>

@endsection