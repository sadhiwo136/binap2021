@extends('layouts.master')

@section('title')
    Detail Proyek '{{ $projects->lokasi }}'  | PSU App Prototype
@endsection

@section('content')

<div class="row" id="top">
    <div class="col-md-12">
        
        <div class="card" style="width: 850px; position:relative; left:100px;">
            <div class="card-header">
            <a href="/index_proyek/{{$projects->id_prshn}}" class="btn btn-secondary float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
            <h4 class="card-title">Info Proyek</h4>
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
                #mapid2
                { 
                    width: 650px; 
                    height: 360px;
                    margin: auto;
                    padding: 10px;
                }
            </style>
            <div class="card-body">
                <div class="table-responsive">                
                    <div class="card-body">
                        <form id="proyek_info" name="proyek_info" method="POST" action="/update_proyek/{{ $projects->id }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Lokasi</label>

                                <div class="col-md-5">
                                    <input id="lokasi" name="lokasi" type="text" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $projects->lokasi }}" disabled style="font-weight:bold; color:black; width: 450px;" >
                                </div>
                            </div>
                            <div class="form-group row" id="mapid2"></div>
                            <div class="form-group row"></div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Longitude</label>

                                <div class="col-md-5">
                                    <input id="longitude_loc" name="longitude_loc" type="text" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $projects->longitude_loc }}" disabled style="font-weight:bold; color:black; width: 450px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Latitude</label>

                                <div class="col-md-5">
                                    <input id="latitude_loc" name="latitude_loc" type="text" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $projects->latitude_loc }}" disabled style="font-weight:bold; color:black; width: 450px;">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="id_kota" class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Kota</label>
                                <div class="col-md-5">
                                    <select name="id_kota" id="id_kota" style="width: 450px;" disabled>
                                        <option value="{{ $projects->id_kota }}">{{ $projects->kotaku }}</option>                        
                                        @foreach($kota as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_kecamatan" class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Kecamatan</label>
                                <div class="col-md-5">
                                    <select name="id_kecamatan" id="id_kecamatan" style="width: 450px;" disabled>
                                        <option value="{{ $projects->id_kecamatan }}">{{ $projects->camatku }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_klurahn" class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Kelurahan</label>
                                <div class="col-md-6">
                                    <select name="id_klurahn" id="id_klurahn" style="width: 450px;" disabled>
                                        <option value="{{ $projects->id_klurahn }}">{{ $projects->lurahku }}</option>                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Luas Area (ha)</label>

                                <div class="col-md-5">
                                    <input id="luas_area" name="luas_area" type="number" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $projects->luas_area }}" disabled style="font-weight:bold; color:black; width: 450px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Jumlah Unit</label>

                                <div class="col-md-5">
                                    <input id="jml_unit" name="jml_unit" type="number" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $projects->jml_unit }}" disabled style="font-weight:bold; color:black; width: 450px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Jenis Produk</label>

                                <div class="col-md-5">
                                    <select name="jenis_produk" id="jenis_produk" style="width: 450px; height: 30px;position:relative; top:5px;" disabled>
                                        <option value="{{ $projects->jenis_produk }}">
                                        @switch($projects->jenis_produk)
                                            @case (1)
                                                Rumah Tapak
                                                @break
                                            @case (2)
                                                Rumah Susun
                                                @break
                                            @case (3)
                                                Rumah Toko
                                                @break
                                            @default
                                                -                                              
                                        @endswitch
                                        </option>
                                        <option value="1">Rumah Tapak</option>
                                        <option value="2">Rumah Susun</option>
                                        <option value="3">Rumah Toko</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Tanggal Mulai</label>

                                <div class="col-md-5">
                                    <input id="tgl_mulai" name="tgl_mulai" type="date" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $projects->tgl_mulai }}" disabled style="font-weight:bold; color:black; width: 450px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Tanggal Selesai</label>

                                <div class="col-md-5">
                                    <input id="tgl_target" name="tgl_target" type="date" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $projects->tgl_target }}" disabled style="font-weight:bold; color:black; width: 450px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right" style="font-weight:bold;">Status Tahap Terakhir</label>
                                <div class="col-md-5">
                                    <select name="status_thp_terakhir" id="status_thp_terakhir" style="width: 450px; height: 30px; position:relative; top:5px;" disabled >
                                        <option value="{{ $projects->status_thp_terakhir }}">
                                        @switch($projects->status_thp_terakhir)
                                            @case (1)
                                                Dalam Pengerjaan
                                                @break
                                            @case (2)
                                                Selesai
                                                @break
                                            @case (3)
                                                Berhenti
                                                @break
                                            @default
                                                -                                              
                                        @endswitch
                                        </option>
                                        <option value="1">Dalam Pengerjaan</option>
                                        <option value="2">Selesai</option>
                                        <option value="3">Berhenti</option>
                                    </select>
                                </div>
                            </div>                            
                        </form>
                        <div class="card-body" style="text-align:center;">                            
                            <button class="btn btn-primary" id="edit_button" onclick="myFunction()">Ubah Data</button>
                            <button class="btn btn-warning" id="save_button" onclick="confirmTest()" disabled>Simpan Data</button>
                            <button class="btn btn-info" id="test_button" data-toggle="collapse" data-target="#demoku">Dokumen <i class="fa fa-arrow-down"></i></button>
                        </div>
                        <div class="collapse" id="demoku">
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label text-md-right" style="color:black;">Siteplan</label>
                                <a href="#" class="btn btn-secondary" style="position:relative; top:-10px;" data-toggle="modal" data-target="#myModal1">Lihat File</a>

                                <div id="myModal1" class="modal fade" role="dialog" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">				
                                                <h5 class="modal-title">Document View</h5>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p>{{ $projects->siteplan }}</p>
                                                <center>
                                                <embed src="{{ url('proyek/1/'.$projects->siteplan) }}" frameborder="0" width="500" height="400">
                                                </center>                                       
                                            </div>
                                            <form id="update_siteplan" action="/update_siteplan/{{ $projects->id }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div id="f1" class="form-group row">
                                                <label for="siteplan" class="col-md-3 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                                <div class="custom-file" id="customFile" lang="es" style="width: 47%;">
                                                    <input size="100" type="file" class="custom-file-input" id="siteplan" aria-describedby="fileHelp" name="siteplan" accept=".pdf,.jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="exampleInputFile">
                                                        Pilih file...
                                                    </label>
                                                    <a onclick="update_siteplan()" class="btn btn-warning" style="position:relative; top: -15px; left: 400px;">Ubah</a>
                                                </div>                                                
                                            </div>                              
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>                                                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label text-md-right" style="color:black;">UKL-UPL</label>
                                <a href="#" class="btn btn-secondary" style="position:relative; top:-10px;" data-toggle="modal" data-target="#myModal2">Lihat File</a>

                                <div id="myModal2" class="modal fade" role="dialog" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">				
                                                <h5 class="modal-title">Document View</h5>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p>{{ $projects->ukl_upl }}</p>
                                                <center>
                                                <embed src="{{ url('proyek/2/'.$projects->ukl_upl) }}" frameborder="0" width="500" height="400">
                                                </center>
                                            </div>
                                            <!-- update_ukl_upl -->
                                            <form id="update_ukl_upl" action="/update_ukl_upl/{{ $projects->id }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div id="f2" class="form-group row">
                                                <label for="ukl_upl" class="col-md-3 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                                <div class="custom-file" id="customFile" lang="es" style="width: 47%;">
                                                    <input size="100" type="file" class="custom-file-input" id="ukl_upl" aria-describedby="fileHelp" name="ukl_upl" accept=".pdf,.jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="exampleInputFile">
                                                        Pilih file...
                                                    </label>
                                                    <a onclick="update_ukl_upl()" class="btn btn-warning" style="position:relative; top: -15px; left: 400px;">Ubah</a>
                                                </div>                                                
                                            </div>                              
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label text-md-right" style="color:black;">IMB</label>
                                <a href="#" class="btn btn-secondary" style="position:relative; top:-10px;" data-toggle="modal" data-target="#myModal3">Lihat File</a>

                                <div id="myModal3" class="modal fade" role="dialog" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">				
                                                <h5 class="modal-title">Document View</h5>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p>{{ $projects->imb }}</p>
                                                <center>
                                                <embed src="{{ url('proyek/3/'.$projects->imb) }}" frameborder="0" width="500" height="400">
                                                </center>
                                            </div>
                                            <!--update_imb-->
                                            <form id="update_imb" action="/update_imb/{{ $projects->id }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div id="f3" class="form-group row">
                                                <label for="imb" class="col-md-3 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                                <div class="custom-file" id="customFile" lang="es" style="width: 47%;">
                                                    <input size="100" type="file" class="custom-file-input" id="imb" aria-describedby="fileHelp" name="imb" accept=".pdf,.jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="exampleInputFile">
                                                        Pilih file...
                                                    </label>
                                                    <a onclick="update_imb()" class="btn btn-warning" style="position:relative; top: -15px; left: 400px;">Ubah</a>
                                                </div>                                                
                                            </div>                              
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label text-md-right" style="color:black;">IPB</label>
                                <a href="#" class="btn btn-secondary" style="position:relative; top:-10px;" data-toggle="modal" data-target="#myModal4">Lihat File</a>

                                <div id="myModal4" class="modal fade" role="dialog" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">				
                                                <h5 class="modal-title">Document View</h5>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p>{{ $projects->ipb }}</p>
                                                <center>
                                                <embed src="{{ url('proyek/4/'.$projects->ipb) }}" frameborder="0" width="500" height="400">
                                                </center>
                                            </div>
                                            <!--update_ipb-->
                                            <form id="update_ipb" action="/update_ipb/{{ $projects->id }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div id="f4" class="form-group row">
                                                <label for="ipb" class="col-md-3 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                                <div class="custom-file" id="customFile" lang="es" style="width: 47%;">
                                                    <input size="100" type="file" class="custom-file-input" id="ipb" aria-describedby="fileHelp" name="ipb" accept=".pdf,.jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="exampleInputFile">
                                                        Pilih file...
                                                    </label>
                                                    <a onclick="update_ipb()" class="btn btn-warning" style="position:relative; top: -15px; left: 400px;">Ubah</a>
                                                </div>                                                
                                            </div>                              
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label text-md-right" style="color:black;">Sertifikat Tanah</label>
                                <a href="#" class="btn btn-secondary" style="position:relative; top:-10px;" data-toggle="modal" data-target="#myModal5">Lihat File</a>

                                <div id="myModal5" class="modal fade" role="dialog" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">				
                                                <h5 class="modal-title">Document View</h5>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p>{{ $projects->sertifikat_tanah }}</p>
                                                <center>
                                                <embed src="{{ url('proyek/5/'.$projects->sertifikat_tanah) }}" frameborder="0" width="500" height="400">
                                                </center>
                                            </div>
                                            <!--update_sertifikat_tanah-->
                                            <form id="update_sertifikat_tanah" action="/update_sertifikat_tanah/{{ $projects->id }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div id="f5" class="form-group row">
                                                <label for="sertifikat_tanah" class="col-md-3 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                                <div class="custom-file" id="customFile" lang="es" style="width: 47%;">
                                                    <input size="100" type="file" class="custom-file-input" id="sertifikat_tanah" aria-describedby="fileHelp" name="sertifikat_tanah" accept=".pdf,.jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="exampleInputFile">
                                                        Pilih file...
                                                    </label>
                                                    <a onclick="update_sertifikat_tanah()" class="btn btn-warning" style="position:relative; top: -15px; left: 400px;">Ubah</a>
                                                </div>                                                
                                            </div>                              
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label text-md-right" style="color:black;">Akta Notaris</label>
                                <a href="#" class="btn btn-secondary" style="position:relative; top:-10px;" data-toggle="modal" data-target="#myModal6">Lihat File</a>

                                <div id="myModal6" class="modal fade" role="dialog" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">				
                                                <h5 class="modal-title">Document View</h5>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p>{{ $projects->akta_notaris }}</p>
                                                <center>
                                                <embed src="{{ url('proyek/6/'.$projects->akta_notaris) }}" frameborder="0" width="500" height="400">
                                                </center>
                                            </div>
                                            <!--update_akta_notaris-->
                                            <form id="update_akta_notaris" action="/update_akta_notaris/{{ $projects->id }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div id="f6" class="form-group row">
                                                <label for="akta_notaris" class="col-md-3 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                                <div class="custom-file" id="customFile" lang="es" style="width: 47%;">
                                                    <input size="100" type="file" class="custom-file-input" id="akta_notaris" aria-describedby="fileHelp" name="akta_notaris" accept=".pdf,.jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="exampleInputFile">
                                                        Pilih file...
                                                    </label>
                                                    <a onclick="update_akta_notaris()" class="btn btn-warning" style="position:relative; top: -15px; left: 400px;">Ubah</a>
                                                </div>                                                
                                            </div>                              
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label text-md-right" style="color:black;">Sertifikat PSU</label>
                                <a href="#" class="btn btn-secondary" style="position:relative; top:-10px;" data-toggle="modal" data-target="#myModal7">Lihat File</a>

                                <div id="myModal7" class="modal fade" role="dialog" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">				
                                                <h5 class="modal-title">Document View</h5>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p>{{ $projects->sertifikat_psu }}</p>
                                                <center>
                                                <embed src="{{ url('proyek/7/'.$projects->sertifikat_psu) }}" frameborder="0" width="500" height="400">
                                                </center>
                                            </div>                                            
                                            <!--update_sertifikat_psu-->
                                            <form id="update_sertifikat_psu" action="/update_sertifikat_psu/{{ $projects->id }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div id="f7" class="form-group row">
                                                <label for="sertifikat_psu" class="col-md-3 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                                <div class="custom-file" id="customFile" lang="es" style="width: 47%;">
                                                    <input size="100" type="file" class="custom-file-input" id="sertifikat_psu" aria-describedby="fileHelp" name="sertifikat_psu" accept=".pdf,.jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="exampleInputFile">
                                                        Pilih file...
                                                    </label>
                                                    <a onclick="update_sertifikat_psu()" class="btn btn-warning" style="position:relative; top: -15px; left: 400px;">Ubah</a>
                                                </div>                                                
                                            </div>                              
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type ="text/javascript">
    function getFocus() 
    {
        window.scrollTo(0, document.body.scrollHeight / 2);
    }

    var newMarker, latlong;
    var mymap = L.map('mapid2').setView([{{ $projects->longitude_loc }} , {{ $projects->latitude_loc }} ], 14);

    $(function(){
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);
        //newMarkerGroup = new L.LayerGroup();
        //mymap.on('click', addMarker);    
        newMarker = new L.marker([{{ $projects->longitude_loc }} , {{ $projects->latitude_loc }} ]).addTo(mymap);
        mymap.addLayer(newMarker);
        mymap.scrollWheelZoom.disable();   
    });    

    function myFunction() 
    {
        window.scrollTo(0, document.body.scrollHeight / 2);
        var x = document.getElementById("edit_button");
        if (x.innerHTML === "Ubah Data") 
        {
            document.getElementById("save_button").disabled = false;
            x.innerHTML = "Lihat Data";
            
            var form = document.getElementById("proyek_info");
            var elements = form.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                if(elements[i].nodeName != "BUTTON" && elements[i].type != "file")
                    elements[i].disabled = false;
            }            
        } 
        else 
        {
            document.getElementById("save_button").disabled = true;
            x.innerHTML = "Ubah Data";
            
            var form = document.getElementById("proyek_info");
            var elements = form.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                if(elements[i].nodeName != "BUTTON" && elements[i].type != "file")
                    elements[i].disabled = true;
            }
        }
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        document.body.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }    

    function confirmTest()
    {
        var a = document.getElementById('lokasi').value;
        var b = document.getElementById('longitude_loc').value;
        var c = document.getElementById('latitude_loc').value;
        var d = document.getElementById('id_kota').value;
        var e = document.getElementById('id_kecamatan').value;
        var f = document.getElementById('id_klurahn').value;
        var g = document.getElementById('luas_area').value;
        var h = document.getElementById('jml_unit').value;
        var i = document.getElementById('jenis_produk').value;
        var j = document.getElementById('tgl_mulai').value;
        var k = document.getElementById('tgl_target').value;

        if (a == null || a == "" || b == null || b == "" || c == null || c == "" || d == "0" || e == "0" || f == "0" ||g == null || g == "" || h == null || h == "" || i == "0" || j == null || j == "" || k == null || k == "") 
            alert("Mohon lengkapi semua isian kolom!");
        else
        {        
            document.getElementById("proyek_info").submit();
        }
    }

    function check_siteplan()
    {
        var file = document.getElementById("siteplan");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
        {
            alert("Format file salah/kosong");
            return false;
        }
        else
            return true;
    }

    function update_siteplan()
    {
        if(check_siteplan()==true)
            document.getElementById("update_siteplan").submit();
    }

    function check_ukl_upl()
    {
        var file = document.getElementById("ukl_upl");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
        {
            alert("Format file salah/kosong");
            return false;
        }
        else
            return true;
    }

    function update_ukl_upl()
    {
        if(check_ukl_upl()==true)
            document.getElementById("update_ukl_upl").submit();
    }

    function check_imb()
    {
        var file = document.getElementById("imb");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
        {
            alert("Format file salah/kosong");
            return false;
        }
        else
            return true;
    }

    function update_imb()
    {
        if(check_imb()==true)
            document.getElementById("update_imb").submit();
    }

    function check_ipb()
    {
        var file = document.getElementById("ipb");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
        {
            alert("Format file salah/kosong");
            return false;
        }
        else
            return true;
    }

    function update_ipb()
    {
        if(check_ipb()==true)
            document.getElementById("update_ipb").submit();
    }

    function check_sertifikat_tanah()
    {
        var file = document.getElementById("sertifikat_tanah");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
        {
            alert("Format file salah/kosong");
            return false;
        }
        else
            return true;
    }

    function update_sertifikat_tanah()
    {
        if(check_sertifikat_tanah()==true)
            document.getElementById("update_sertifikat_tanah").submit();
    }

    function check_akta_notaris()
    {
        var file = document.getElementById("akta_notaris");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
        {
            alert("Format file salah/kosong");
            return false;
        }
        else
            return true;
    }

    function update_akta_notaris()
    {
        if(check_akta_notaris()==true)
            document.getElementById("update_akta_notaris").submit();
    }

    function check_sertifikat_psu()
    {
        var file = document.getElementById("sertifikat_psu");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
        {
            alert("Format file salah/kosong");
            return false;
        }
        else
            return true;
    }

    function update_sertifikat_psu()
    {
        if(check_sertifikat_psu()==true)
            document.getElementById("update_sertifikat_psu").submit();
    }

    $('.custom-file-input').on('change', function() { 
        let fileName = $(this).val().split('\\').pop(); 
        $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });    
    
    $("#id_kota").select2(
        {
            placeholder: "select a name",
            allowClear: true
        }
    );
    $("#id_kecamatan").select2(
        {
            placeholder: "select a name",
            allowClear: true
        }
    );
    $("#id_klurahn").select2(
        {
            placeholder: "select a name",
            allowClear: true
        }
    );
    $(document).ready(function(){
        // Kecamatan
        $('#id_kota').change(function()
        {            
            var id = $(this).val();
            // Empty the dropdown
            $('#id_kecamatan').find('option').not(':first').remove();
            $('#id_klurahn').find('option').not(':first').remove();

            // AJAX request 
            $.ajax({
                url: 'getKecamatan3/'+id,
                type: 'get',
                dataType: 'json',
                success: function(response){

                    var len = 0;
                    if(response['data'] != null){
                    len = response['data'].length;
                    }

                    if(len > 0){
                    // Read data and create <option >
                        for(var i=0; i<len; i++)
                        {
                            var id = response['data'][i].id;
                            var nama = response['data'][i].nama;
                            var option = "<option value='"+id+"'>"+nama+"</option>"; 
                            $("#id_kecamatan").append(option); 
                        }
                    }

                }
            });
        });
        // Kelurahan
        $('#id_kecamatan').change(function()
        {
            // Empty the dropdown
            $('#id_klurahn').find('option').not(':first').remove();
            var id = $(this).val();

            // AJAX request 
            $.ajax({
                url: 'getKelurahan3/'+id,
                type: 'get',
                dataType: 'json',
                success: function(response){

                    var len = 0;
                    if(response['data'] != null){
                    len = response['data'].length;
                    }

                    if(len > 0){
                    // Read data and create <option >
                        for(var i=0; i<len; i++)
                        {
                            var id = response['data'][i].id;
                            var nama = response['data'][i].nama;
                            var option = "<option value='"+id+"'>"+nama+"</option>"; 
                            $("#id_klurahn").append(option); 
                        }
                    }

                }
            });
        });
    });
</script>
@endsection