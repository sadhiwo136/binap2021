@extends('layouts.master')

@section('title')
    Laporan | PSU App Prototype
@endsection()

@section('content')
<style>
    .modal-lg {
        max-width: 80%;
    }    
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Laporan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/savewarga" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="modal-body">
                <div class="form-group row">
                    <label for="judul" class="col-md-4 col-form-label text-md-right">{{ ('Judul Laporan') }}</label>
                    <div class="col-md-6">
                        <input id="judul" type="text" class="form-control" name="judul" required oninvalid="this.setCustomValidity('Data belum terisi')" oninput="setCustomValidity('')">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="deskripsi" class="col-md-4 col-form-label text-md-right">{{ ('Deskripsi') }}</label>
                    <div class="col-md-6">
                        <textarea id="deskripsi" class="form-control span8" name="deskripsi" rows="10" required oninvalid="this.setCustomValidity('Data belum terisi')" oninput="setCustomValidity('')"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="foto1" class="col-md-4 col-form-label text-md-right">{{ ('Foto Bukti 1') }}</label>

                    <div class="custom-file" id="customFile" lang="es" style="width: 47%; left: 15px;">
                        <input size="50" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="foto1" oninput="setCustomValidity('')">
                        <label class="custom-file-label" for="exampleInputFile">
                            Pilih file...
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="foto2" class="col-md-4 col-form-label text-md-right">{{ ('Foto Bukti 2') }}</label>

                    <div class="custom-file" id="customFile" lang="es" style="width: 47%; left: 15px;">
                        <input size="50" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="foto2" oninput="setCustomValidity('')">
                        <label class="custom-file-label" for="exampleInputFile">
                            Pilih file...
                        </label>
                    </div>
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
                <h5 class="card-title">Laporan Terkirim
                    @if(Auth::user()->usertype == 'warga')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah Laporan</button>
                    @endif
                </h5>
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if(!empty($successMsg))
                    <div class="alert alert-success"> {{ $successMsg }} </div>
                @endif
            </div>
            <style>
                .w-10p
                {
                    width: 10% !important;
                }
            </style>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="mytable" class="table table-stripped">
                        <thead class="text-primary">
                            <th class="text-center w-10p">Judul Laporan</th>
                            <th class="text-center w-10p">Tanggal Laporan</th>
                            <th class="text-center w-10p">Status Terakhir</th>
                            <th class="text-center w-10p">Action</th>

                        </thead>
                        <tbody>
                            @if(Auth::user()->usertype == 'warga')
                                @foreach($laporan as $data)
                                @if(Auth::user()->id == $data->id_pelapor)
                                <tr>
                                    <td class="text-center w-10p">{{ $data->judul }}</td>
                                    <td class="text-center w-10p">{{ $data->tanggal_laporan }}</td>
                                    @switch($data->status_terakhir)
                                        @case (1)
                                            <td class="text-center w-10p" id="st">Pending</td>
                                            @break
                                        @case (2)
                                            <td class="text-center w-10p" id="st">Diterima</td>
                                            @break
                                        @case (3)
                                            <td class="text-center w-10p" id="st">Ditolak</td>
                                            @break
                                        @default
                                        <td class="text-center w-10p" id="st">-</td>                                                         
                                    @endswitch
                                    <td class="text-center w-10p"><a href="/laporan/{{ $data->id_laporan }}" class="btn btn-success">Open</a></td>
                                </tr>
                                @endif
                                @endforeach
                            @endif
                            @if(Auth::user()->usertype == 'admin')
                                @foreach($laporan as $data)
                                <tr>
                                    <td class="text-center w-10p">{{ $data->judul }}</td>
                                    <td class="text-center w-10p">{{ $data->tanggal_laporan }}</td>
                                    @switch($data->status_terakhir)
                                        @case (1)
                                            <td class="text-center w-10p" id="st">Pending</td>
                                            @break
                                        @case (2)
                                            <td class="text-center w-10p" id="st">Diterima</td>
                                            @break
                                        @case (3)
                                            <td class="text-center w-10p" id="st">Ditolak</td>
                                            @break
                                        @default
                                        <td class="text-center w-10p" id="st">-</td>                                                         
                                    @endswitch
                                    <td class="text-center w-10p"><a href="/laporan/{{ $data->id_laporan }}" class="btn btn-success">Open</a></td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    
    $('.modal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
    });

    $('.custom-file-input').on('change', function() { 
        let fileName = $(this).val().split('\\').pop(); 
        $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });

</script>

@endsection