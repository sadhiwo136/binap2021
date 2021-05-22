@extends('layouts.master')

@section('title')
    Riwayat Proyek | PSU App Prototype
@endsection()

@section('content')
<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
        <a href="/companies" class="btn btn-secondary float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
        <h4 class="modal-title">{{ $nama->nama_prshn }} -> Daftar Proyek</h4>
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
        <style>
            .w-10p
            {
                width: 10% !important;
            }
            
            .w-12p
            {
                width: 12% !important;
            }
        </style>
        <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" class="table table-striped">
                    <thead class=" text-primary">
                        <th class="text-center w-13p">Lokasi</th>
                        <th class="text-center w-13p">Jenis Produk</th>
                        <th class="text-center w-13p">Status</th>
                        <th class="text-center w-13p" colspan="2">Action</th>
                    </thead>
                    <tbody>
                        @foreach($projects as $data)
                        <tr>
                            <td class="text-center w-13p">{{ $data->lokasi }}</td>
                            @switch($data->jenis_produk)
                                @case (1)
                                    <td class="text-center w-13p" id="st">Rumah Tapak</td>
                                    @break
                                @case (2)
                                    <td class="text-center w-13p" id="st">Rumah Susun</td>
                                    @break
                                @case (3)
                                    <td class="text-center w-13p" id="st">Rumah Toko</td>
                                    @break
                                @default
                                <td class="text-center w-13p" id="st">-</td>                                                         
                            @endswitch
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
                <a href="/add_proyek/{{ $nama->id_prshn }}" class="btn btn-success float-left">Tambah Proyek</a>
            </div>
        </div>
    </div>
</div>    
@endsection()

@section('scripts')
@endsection()