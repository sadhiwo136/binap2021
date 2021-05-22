@extends('layouts.master')

@section('title')
    Detail Perusahaan | PSU App Prototype
@endsection

@section('content')
<style>
    .modal-lg {
        max-width: 80%;
    }    
</style>
<!-- The Modal -->
<div class="modal fade" id="statusModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">{{ $companies->nama_prshn }}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <center>
            <p style="font-weight:bold;">Status Perusahaan: {{ $companies->status_prshn }}</p>
            <center>
        </div>

        <div class="modal-body">
            <center>
            <a href="/diproses/{{ $companies->id_prshn }}" class="btn btn-secondary">DIPROSES</a>
            <a href="/disetujui/{{ $companies->id_prshn }}" class="btn btn-secondary">DISETUJUI</a>
            <a href="/revisi/{{ $companies->id_prshn }}" class="btn btn-secondary">REVISI</a>
            <a href="/ditolak/{{ $companies->id_prshn }}" class="btn btn-secondary">DITOLAK</a>
            <center>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Data Perusahaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/update-company/{{ $companies->id_prshn }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="modal-body">        
            <div class="form-group row">
                <label for="nama_prshn" class="col-md-4 col-form-label text-md-right">{{ ('Nama Perusahaan') }}</label>

                <div class="col-md-6">
                    <input id="nama_prshn" type="text" class="form-control" name="nama_prshn" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $companies->nama_prshn }}">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="bentuk_prshn" class="col-md-4 col-form-label text-md-right">{{ ('Bentuk Perusahaan') }}</label>
                <div class="col-md-6">
                    <select name="bentuk_prshn" class="form-control">
                        <option value="{{ $companies->bentuk_prshn }}">{{ $companies->bentuk_prshn }}</option>
                        <option value="CV">CV</option>
                        <option value="Firma">Firma</option>
                        <option value="PT">PT</option>
                        <option value="UD">UD</option>
                        <option value="BUMN">BUMN</option>
                        <option value="BUMD">BUMD</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_owner" class="col-md-4 col-form-label text-md-right">{{ ('Nama Pemilik') }}</label>

                <div class="col-md-6">
                    <input id="nama_owner" type="text" class="form-control" name="nama_owner" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $companies->nama_owner }}">                   
                </div>
            </div>

            <div class="form-group row">
                <label for="thn_est" class="col-md-4 col-form-label text-md-right">{{ ('Tahun Berdiri') }}</label>

                <div class="col-md-6">
                    <input id="thn_est" type="number" class="form-control" name="thn_est" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $companies->thn_est }}">                    
                </div>
            </div>            

            <div class="form-group row">
                <label for="alamat" class="col-md-4 col-form-label text-md-right">{{ ('Alamat') }}</label>

                <div class="col-md-6">
                    <input id="alamat" type="alamat" class="form-control" name="alamat" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $companies->alamat }}">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="lat_prshn" class="col-md-4 col-form-label text-md-right">{{ ('Latitude') }}</label>

                <div class="col-md-6">
                    <input id="lat_prshn" type="lat_prshn" class="form-control" name="lat_prshn" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $companies->lat_prshn }}">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="long_prshn" class="col-md-4 col-form-label text-md-right">{{ ('Longitude') }}</label>

                <div class="col-md-6">
                    <input id="long_prshn" type="long_prshn" class="form-control" name="long_prshn" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $companies->long_prshn }}">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="id_kota" class="col-md-4 col-form-label text-md-right">{{ ('Kota') }}</label>
                <div class="col-md-6">
                    <select name="id_kota" id="id_kota2" style="width: 500px;">
                    <option value="{{ $companies->id_kota }}">{{ $companies->kotaku }}</option>                        
                        @foreach($kota as $data)
                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="id_kecamatan" class="col-md-4 col-form-label text-md-right">{{ ('Kecamatan') }}</label>
                <div class="col-md-6">
                    <select name="id_kecamatan" id="id_kecamatan2" style="width: 500px;">
                    <option value="{{ $companies->id_kecamatan }}">{{ $companies->camatku }}</option>                        
                        @foreach($camat as $data)
                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="id_klurahn" class="col-md-4 col-form-label text-md-right">{{ ('Kelurahan') }}</label>
                <div class="col-md-6">
                    <select name="id_klurahn" id="id_klurahn2" style="width: 500px;">
                    <option value="{{ $companies->id_klurahn }}">{{ $companies->lurahku }}</option>                                                
                        @foreach($lurah as $data)
                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="telepon" class="col-md-4 col-form-label text-md-right">{{ ('Telepon') }}</label>

                <div class="col-md-6">
                    <input id="telepon" type="number" class="form-control" name="telepon" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')" value="{{ $companies->telepon }}">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ ('Email') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $companies->email }}">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="website" class="col-md-4 col-form-label text-md-right">{{ ('Website') }}</label>

                <div class="col-md-6">
                    <input id="website" type="website" class="form-control" name="website" value="{{ $companies->website }}">                    
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
                <a href="/companies" class="btn btn-secondary float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                <h5 class="card-title">{{ $companies->nama_prshn }}</h5>
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('success2'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('success2') }}
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
                        <label style="font-weight:bold;" for="bentuk_prshn" class="col-md-4 text-md-right">{{ ('Bentuk Perusahaan') }}</label>
                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="bentuk_prshn" class="col-md-5 text-md-left">{{ $companies->bentuk_prshn }}</label>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label style="font-weight:bold;" for="nama_owner" class="col-md-4 text-md-right">{{ ('Nama Pemilik') }}</label>

                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="nama_owner" class="col-md-5 text-md-left">{{ $companies->nama_owner }}</label>                   
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="thn_est" class="col-md-4 text-md-right">{{ ('Tahun Berdiri') }}</label>

                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="thn_est" class="col-md-5 text-md-left">{{ $companies->thn_est }}</label>
                        </div>
                    </div>            

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="alamat" class="col-md-4 text-md-right">{{ ('Alamat') }}</label>

                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="alamat" class="col-md-5 text-md-left">{{ $companies->alamat }}</label>
                        </div>
                    </div>            

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="id_kota" class="col-md-4 text-md-right">{{ ('Kota') }}</label>

                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="id_kota" class="col-md-5 text-md-left">{{ $companies->kotaku }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="id_kecamatan" class="col-md-4 text-md-right">{{ ('Kecamatan') }}</label>

                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="id_kecamatan" class="col-md-5 text-md-left">{{ $companies->camatku }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="id_klurahn" class="col-md-4 text-md-right">{{ ('Kelurahan') }}</label>

                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="id_klurahn" class="col-md-5 text-md-left">{{ $companies->lurahku }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="telepon" class="col-md-4 text-md-right">{{ ('Telepon') }}</label>

                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="telepon" class="col-md-5 text-md-left">{{ $companies->telepon }}</label>                    
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="email" class="col-md-4 text-md-right">{{ ('Email') }}</label>

                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="email" class="col-md-5 text-md-left">{{ $companies->email }}</label>   
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-weight:bold;" for="website" class="col-md-4 text-md-right">{{ ('Website') }}</label>

                        <div class="col-md-6">
                            <label style="font-weight:bold;" for="website" class="col-md-5 text-md-left">{{ $companies->website }}</label>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card-header">
                <h5 class="card-title">Lokasi Perusahaan</h5>
                <div class="card-body" id="mapid2">

                </div>
                <div class="card-body" style="text-align:center;">
                    <label style="font-weight:bold;">Latitude</label>
                    <input id="userLat" type="text" name="val-lat" value="{{ $companies->lat_prshn }}" />
                    <label style="font-weight:bold;">Longitude</label>
                    <input id="userLng" type="text" name="val-lng" value="{{ $companies->long_prshn }}" />
                </div>
            </div>
            <div class="card-header">
                <h5 class="card-title">Dokumen Perusahaan</h5>
            </div>
            <div class="card-body" style="text-align:center;">
                <button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#myModal1{{$companies->id_prshn}}">Akta Perusahaan</button>

                <div id="myModal1{{$companies->id_prshn}}" class="modal fade" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            
                            <div class="modal-header">				
                                <h5 class="modal-title">Document View</h5>
                            </div>
                            
                            <div class="modal-body">
                                <p>{{ $companies->file_akta }}</p>
                                <embed src="{{ url('z_akta/'.$companies->file_akta) }}" frameborder="0" width="500" height="700">
                            <form action="/update_file_akta/{{ $companies->id_prshn }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                                <div class="form-group row">
                                    <label for="file_akta" class="col-md-4 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                    <div class="custom-file" id="customFile" lang="es" style="width: 40%;">
                                        <input size="100" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="file_akta" accept=".pdf,.jpg,.jpeg,.png">
                                        <label class="custom-file-label" for="exampleInputFile">
                                            Pilih file...
                                        </label>
                                    </div>                                    
                                </div>

                                <div class="modal-footer">
                                    <button id="b1" type="submit" class="btn btn-primary">Simpan File Baru</button>
                            </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#myModal2{{$companies->id_prshn}}">KTP</button>

                <div id="myModal2{{$companies->id_prshn}}" class="modal fade" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            
                            <div class="modal-header">				
                                <h5 class="modal-title">Document View</h5>
                            </div>
                            
                            <div class="modal-body">
                                <p>{{ $companies->file_ktp }}</p>
                                <embed src="{{ url('z_ktp/'.$companies->file_ktp) }}" frameborder="0" width="500" height="326">

                            <form action="/update_file_ktp/{{ $companies->id_prshn }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                                <div class="form-group row">
                                    <label for="file_ktp" class="col-md-4 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                    <div class="custom-file" id="customFile" lang="es" style="width: 40%;">
                                        <input size="100" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="file_ktp" accept=".pdf,.jpg,.jpeg,.png">
                                        <label class="custom-file-label" for="exampleInputFile">
                                            Pilih file...
                                        </label>
                                    </div>                                    
                                </div>

                                <div class="modal-footer">
                                    <button id="b1" type="submit" class="btn btn-primary">Simpan File Baru</button>
                            </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#myModal3{{$companies->id_prshn}}">Foto Pemilik</button>

                <div id="myModal3{{$companies->id_prshn}}" class="modal fade" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            
                            <div class="modal-header">				
                                <h5 class="modal-title">Document View</h5>
                            </div>
                            
                            <div class="modal-body">
                                <p>{{ $companies->file_foto }}</p>
                                <embed src="{{ url('z_foto/'.$companies->file_foto) }}" frameborder="0" width="350" height="400">
                            
                            <form action="/update_file_foto/{{ $companies->id_prshn }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                                <div class="form-group row">
                                    <label for="file_foto" class="col-md-4 col-form-label text-md-right">{{ ('Ubah file: ') }}</label>

                                    <div class="custom-file" id="customFile" lang="es" style="width: 40%;">
                                        <input size="100" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="file_foto" accept=".pdf,.jpg,.jpeg,.png">
                                        <label class="custom-file-label" for="exampleInputFile">
                                            Pilih file...
                                        </label>
                                    </div>                                    
                                </div>

                                <div class="modal-footer">
                                    <button id="b1" type="submit" class="btn btn-primary">Simpan File Baru</button>
                            </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="card-header">
                <h5 class="card-title">Status Perusahaan</h5>
            </div>            
            <div style="color:purple; font-weight:bold;">
                <center>
                {{ $companies->status_prshn }}
                <center>
            </div>
            <div class="card-body" style="text-align:center;">
                @if(Auth::user()->usertype == 'admin')
                <button class="btn btn-success" data-toggle="modal" data-target="#statusModal">Ubah Status Perusahaan</button>
                @endif
                <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal2">Ubah Data Perusahaan</button>
                
                <a href="{{ route('company.delete', ['id_prshn' => $companies->id_prshn]) }}" class="btn btn-danger" role="button" onclick='return confirm("Mau menghapus data perusahaan?")'>Delete</a>
                
            </div>
            <!-- <div class="card-header">
                <h5 class="card-title">Riwayat Proyek</h5>
            </div>
            <div class="card-body" style="text-align:center;">
                <a href="/index_proyek/{{ $companies->id_prshn }}" class="btn btn-success">Menu Proyek</a>
            </div>-->
        </div>
    </div>
</div>    
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    var newMarker, latlong;
    var mymap = L.map('mapid2').setView([{{ $companies->lat_prshn }} , {{ $companies->long_prshn }} ], 14);

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
        newMarker = new L.marker([{{ $companies->lat_prshn }} , {{ $companies->long_prshn }} ]).addTo(mymap);
        mymap.addLayer(newMarker);
        mymap.scrollWheelZoom.disable();   
    });

    $("#id_kota2").select2({
        dropdownParent: $("#exampleModal2 .modal-content"),
        placeholder: 'Pilih Kota'
    });

    $("#id_kecamatan2").select2({
        dropdownParent: $("#exampleModal2 .modal-content"),
        placeholder: 'Pilih Kecamatan'
    });

    $("#id_klurahn2").select2({
        dropdownParent: $("#exampleModal2 .modal-content"),
        placeholder: 'Pilih Kelurahan'
    });

    $('.custom-file-input').on('change', function() { 
        let fileName = $(this).val().split('\\').pop(); 
        $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });
 
    $(document).ready(function(){
        // Kecamatan
        $('#id_kota2').change(function()
        {            
            var id = $(this).val();
            // Empty the dropdown
            $('#id_kecamatan2').find('option').not(':first').remove();
            $('#id_klurahn2').find('option').not(':first').remove();

            // AJAX request 
            $.ajax({
                url: 'getKecamatan2/'+id,
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
                            $("#id_kecamatan2").append(option); 
                        }
                    }

                }
            });
        });
        // Kelurahan
        $('#id_kecamatan2').change(function()
        {
            // Empty the dropdown
            $('#id_klurahn2').find('option').not(':first').remove();
            var id = $(this).val();

            // AJAX request 
            $.ajax({
                url: 'getKelurahan2/'+id,
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
                            $("#id_klurahn2").append(option); 
                        }
                    }

                }
            });
        });
        
    });
</script>
@endsection