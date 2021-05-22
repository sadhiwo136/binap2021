@extends('layouts.master')

@section('title')
    Detail Laporan | PSU App Prototype
@endsection

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
                    <h5 class="modal-title" id="exampleModalLabel">Respon Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/respon_laporan/{{ $laporan->id_laporan }}" method="POST">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="judul" class="col-md-4 col-form-label text-md-right">{{ ('Judul') }}</label>

                            <div class="col-md-6">
                                <label style="font-weight:bold;" for="judul" class="col-md-5 text-md-left">{{ $laporan->judul }}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deskripsi" class="col-md-4 col-form-label text-md-right">{{ ('Deskripsi') }}</label>

                            <div class="col-md-6">
                            <!-- <label style="font-weight:bold;" for="deskripsi" class="col-md-5 text-md-left">{{ $laporan->deskripsi }}</label> -->
                                <textarea class="ckeditor form-control" name="deskripsi"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status_terakhir" class="col-md-4 col-form-label text-md-right">{{ ('Status Terakhir') }}</label>
                            <div class="col-md-6">
                                <select name="status_terakhir" class="form-control">
                                    <option value="{{ $laporan->status_terakhir }}">{{ $laporan->status_terakhir }}</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Diterima</option>
                                    <option value="3">Ditolak</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="SKPD_terkait" class="col-md-4 col-form-label text-md-right">{{ ('SKPD Terkait') }}</label>

                            <div class="col-md-6">
                                <input id="SKPD_terkait" type="text" class="form-control" name="SKPD_terkait" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $laporan->SKPD_terkait }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jawaban_SKPD" class="col-md-4 col-form-label text-md-right">{{ ('Jawaban SKPD') }}</label>

                            <div class="col-md-6">
                                <input id="jawaban_SKPD" type="text" class="form-control" name="jawaban_SKPD" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $laporan->jawaban_SKPD }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="feedback_pelapor" class="col-md-4 col-form-label text-md-right">{{ ('Feedback Pelapor') }}</label>

                            <div class="col-md-6">
                                <input id="feedback_pelapor" type="text" class="form-control" name="feedback_pelapor" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $laporan->feedback_pelapor }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanggal_status_terakhir" class="col-md-4 col-form-label text-md-right">{{ ('Tanggal Status Terakhir') }}</label>

                            <div class="col-md-6">
                                <input id="tanggal_status_terakhir" type="date" class="form-control" name="tanggal_status_terakhir" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $laporan->tanggal_status_terakhir }}">
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
                <a href="./" class="btn btn-danger float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                <h5 class="card-title">{{ $laporan->judul }}</h5>
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

            <style>
                .w-10p
                {
                    width: 10% !important;
                }

                #mapid2
                {
                    width: 650px;
                    height: 360px;
                    margin: auto;
                    padding: 10px;
                }
            </style>

            <div class="card-body">
                <div class="">

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="judul" class="col-md-4 text-md-right">{{ ('Judul Laporan') }}</label>
                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="judul" class="col-md-5 text-md-left">{{ $laporan->judul }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="tanggal_laporan" class="col-md-4 text-md-right">{{ ('Tanggal Laporan') }}</label>
                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="tanggal_laporan" class="col-md-5 text-md-left">{{ $laporan->tanggal_laporan }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="deskripsi" class="col-md-4 text-md-right">{{ ('Deskripsi') }}</label>
                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="deskripsi" class="col-md-5 text-md-left">{{ $laporan->deskripsi }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="status_terakhir" class="col-md-4 text-md-right">{{ ('Status Terakhir') }}</label>
                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="status_terakhir" class="col-md-5 text-md-left">{{ $laporan->status_terakhir }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="SKPD_terkait" class="col-md-4 text-md-right">{{ ('SKPD Terkait') }}</label>
                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="SKPD_terkair" class="col-md-5 text-md-left">{{ $laporan->SKPD_terkait }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="jawaban_SKPD" class="col-md-4 text-md-right">{{ ('Jawaban SKPD') }}</label>
                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="jawaban_SKPD" class="col-md-5 text-md-left">{{ $laporan->jawaban_SKPD }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="feedback_pelapor" class="col-md-4 text-md-right">{{ ('Feedback Pelapor') }}</label>
                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="feedback_pelapor" class="col-md-5 text-md-left">{{ $laporan->feedback_pelapor }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="tanggal_status_terakhir" class="col-md-4 text-md-right">{{ ('Tanggal Status Terakhir') }}</label>
                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="tanggal_status_terakhir" class="col-md-5 text-md-left">{{ $laporan->tanggal_status_terakhir }}</label>
                        </div>
                    </div>

                    <div class="card-body" style="text-align:center;">
                        <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Respon Laporan</button>
                    </div>
                </div>
            </div>

            <div class="card-header">
                <h5 class="card-title">Foto Pendukung</h5>
            </div>
            <div class="card-body" style="text-align: center;">
                <button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#myModal1{{$laporan->id_laporan}}">Foto 1</button>

                <div id="myModal1{{$laporan->id_laporan}}" class="modal fade" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Document View</h5>
                            </div>

                            <div class="modal-body">

                                <embed src="{{ url('fotoo1/'.$laporan->foto1) }}" frameborder="0">
                                <form action="/update_foto1/{{ $laporan->id_laporan }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                    <div class="form-group row">
                                        <label for="foto1" class="col-md-4 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                        <div class="custom-file" id="customFile" lang="es" style="width: 40%;">
                                            <input size="50" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="foto1">
                                            <label class="custom-file-label" for="exampleInputFile">
                                                Pilih file...
                                            </label>
                                        </div>
                                    </div>
                                        <button id="b1" type="submit" class="btn btn-primary">Simpan File Baru</button>

                                </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#myModal2{{$laporan->id_laporan}}">Foto 2</button>

                <div id="myModal2{{$laporan->id_laporan}}" class="modal fade" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Document View</h5>
                            </div>

                            <div class="modal-body">

                                <embed src="{{ url('fotoo2/'.$laporan->foto2) }}" frameborder="0">
                                <form action="/update_foto2/{{ $laporan->id_laporan }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group row">
                                        <label for="foto1" class="col-md-4 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                        <div class="custom-file" id="customFile" lang="es" style="width: 40%;">
                                            <input size="50" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="foto2">
                                            <label class="custom-file-label" for="exampleInputFile">
                                                Pilih file...
                                            </label>
                                        </div>
                                    </div>

                                        <button id="b1" type="submit" class="btn btn-primary">Simpan File Baru</button>

                                </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            </div>
                        </div>
                    </div>
            </div>

                <div class="card-body" style="text-align:center;">
                    <form action="/del_laporan/{{ $laporan->id_laporan }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger" onclick='return confirm("Hapus data?")'>Hapus</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $(document).ready(function() {
       $('.ckeditor').ckeditor();
    });

    var desc = CKEDITOR.instances['deskripsi'].getData();
</script>
@endsection
