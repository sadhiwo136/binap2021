@extends('layouts.master')

@section('title')
    Daftar Perusahaan | PSU App Prototype
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
        <h5 class="modal-title" id="exampleModalLabel">Perusahaan Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/save-company" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="modal-body">        
            <div class="form-group row">
                <label for="nama_prshn" class="col-md-4 col-form-label text-md-right">{{ ('Nama Perusahaan') }}</label>

                <div class="col-md-6">
                    <input id="nama_prshn" type="text" class="form-control" name="nama_prshn" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="bentuk_prshn" class="col-md-4 col-form-label text-md-right">{{ ('Bentuk Perusahaan') }}</label>
                <div class="col-md-6">
                    <select name="bentuk_prshn" class="form-control">
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
                    <input id="nama_owner" type="text" class="form-control" name="nama_owner" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">                   
                </div>
            </div>

            <div class="form-group row">
                <label for="thn_est" class="col-md-4 col-form-label text-md-right">{{ ('Tahun Berdiri') }}</label>

                <div class="col-md-6">
                    <input id="thn_est" type="number" class="form-control" name="thn_est" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">                    
                </div>
            </div>            

            <div class="form-group row">
                <label for="alamat" class="col-md-4 col-form-label text-md-right">{{ ('Alamat') }}</label>

                <div class="col-md-6">
                    <input id="alamat" type="alamat" class="form-control" name="alamat" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="lat_prshn" class="col-md-4 col-form-label text-md-right">{{ ('Latitude') }}</label>

                <div class="col-md-6">
                    <input id="lat_prshn" type="lat_prshn" class="form-control" name="lat_prshn" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="long_prshn" class="col-md-4 col-form-label text-md-right">{{ ('Longitude') }}</label>

                <div class="col-md-6">
                    <input id="long_prshn" type="long_prshn" class="form-control" name="long_prshn" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">                    
                </div>
            </div>            

            <div class="form-group row">
                <label for="id_kota" class="col-md-4 col-form-label text-md-right">{{ ('Kota') }}</label>
                <div class="col-md-6">
                    <select name="id_kota" id="id_kota2" style="width: 500px;">
                        <option value="0">Pilih Kota</option>                        
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
                        <option value="0">Pilih Kecamatan</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="id_klurahn" class="col-md-4 col-form-label text-md-right">{{ ('Kelurahan') }}</label>
                <div class="col-md-6">
                    <select name="id_klurahn" id="id_klurahn2" style="width: 500px;">
                        <option value="0">Pilih Kelurahan</option>                        
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="telepon" class="col-md-4 col-form-label text-md-right">{{ ('Telepon') }}</label>

                <div class="col-md-6">
                    <input id="telepon" type="number" class="form-control" name="telepon" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ ('Email') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="website" class="col-md-4 col-form-label text-md-right">{{ ('Website') }}</label>

                <div class="col-md-6">
                    <input id="website" type="website" class="form-control" name="website">                    
                </div>
            </div>

            <div style="color:red;">
                <center>
                File harus dalam format pdf,png, jpg, atau jpeg.
                </center>
            </div>

            <div class="form-group row">
                <label for="file_akta" class="col-md-4 col-form-label text-md-right">{{ ('Akta Perusahaan') }}</label>

                <div class="custom-file" id="customFile" lang="es" style="width: 47%; left: 15px;">
                    <input size="50" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="file_akta" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                    <label class="custom-file-label" for="exampleInputFile">
                        Pilih file...
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <label for="file_ktp" class="col-md-4 col-form-label text-md-right">{{ ('Scan KTP') }}</label>

                <div class="custom-file" id="customFile" lang="es" style="width: 47%; left: 15px;">
                    <input size="50" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="file_ktp" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                    <label class="custom-file-label" for="exampleInputFile">
                        Pilih file...
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <label for="file_foto" class="col-md-4 col-form-label text-md-right">{{ ('Foto Pemilik') }}</label>

                <div class="custom-file" id="customFile" lang="es" style="width: 47%; left: 15px;">
                    <input size="50" type="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp" name="file_foto" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                    <label class="custom-file-label" for="exampleInputFile">
                        Pilih file...
                    </label>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <input type="reset" class="btn btn-info" value="Kosongkan">
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
                <h5 class="card-title">Perusahaan Terdaftar 
                    @if(Auth::user()->usertype == 'developer')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add</button>
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
            </style>
            <div class="card-body">
                <div class="table-responsive">                    
                    <table id="mytable" class="table table-striped">
                        <thead class="text-primary">                        
                            <th class="text-center w-12p">Nama</th>
                            <th class="text-center w-12p">Bentuk</th>
                            <th class="text-center w-12p">Pemilik</th>
                            <th class="text-center w-12p">Status</th>
                            <th class="text-center w-12p" colspan="3">Action</th>
                        </thead>
                        <tbody>
                            @foreach($companies as $data)
                            <tr>                            
                                <td class="text-center w-12p">{{ $data->nama_prshn }}</td>
                                <td class="text-center w-12p">{{ $data->bentuk_prshn }}</td>
                                <td class="text-center w-12p">{{ $data->nama_owner }}</td>
                                <td class="text-center w-12p">{{ $data->status_prshn }}</td>
                                <td class="text-center w-12p"><a href="/perusahaan/{{ $data->id_prshn }}" class="btn btn-info">Detail</a></td>
                                <td class="text-center w-12p"><a href="/index_proyek/{{ $data->id_prshn }}" class="btn btn-info">Proyek</a></td>
                                <td class="text-center w-12p"><a href="/del_comp/{{ $data->id_prshn }}" class="btn btn-danger" role="button" onclick='return confirm("Mau menghapus data perusahaan?")'>Delete</a></td>
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
    
    $('.modal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
    });

    $("#id_kota2").select2({
        dropdownParent: $("#exampleModal .modal-content"),
        placeholder: 'Pilih Kota'
    });

    $("#id_kecamatan2").select2({
        dropdownParent: $("#exampleModal .modal-content"),
        placeholder: 'Pilih Kecamatan'
    });

    $("#id_klurahn2").select2({
        dropdownParent: $("#exampleModal .modal-content"),
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