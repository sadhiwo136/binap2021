@extends('layouts.master')

@section('title')
    Tambah Proyek untuk {{ $nama->nama_prshn }}  | PSU App Prototype
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            <a href="{{ url()->previous() }}" class="btn btn-secondary float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
            <h4 class="card-title">{{ $nama->nama_prshn }} -> Tambah Proyek Baru</h4>
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
            <div class="card-body">
                <div class="table-responsive">                
                    <div class="card-body">
                        <form id="new_proyek" name="new_proyek" method="POST" action="/store_proyek/{{ $nama->id_prshn }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Lokasi</label>

                                <div class="col-md-6">
                                    <input id="lokasi" name="lokasi" type="text" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Longitude</label>

                                <div class="col-md-6">
                                    <input id="longitude_loc" name="longitude_loc" type="text" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Latitude</label>

                                <div class="col-md-6">
                                    <input id="latitude_loc" name="latitude_loc" type="text" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="id_kota" class="col-md-4 col-form-label text-md-right">Kota</label>
                                <div class="col-md-6">
                                    <select name="id_kota" id="id_kota" style="width: 480px;">
                                        <option value="0">Pilih Kota</option>                        
                                        @foreach($kota as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_kecamatan" class="col-md-4 col-form-label text-md-right">Kecamatan</label>
                                <div class="col-md-6">
                                    <select name="id_kecamatan" id="id_kecamatan" style="width: 480px;">
                                        <option value="0">Pilih Kecamatan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_klurahn" class="col-md-4 col-form-label text-md-right">Kelurahan</label>
                                <div class="col-md-6">
                                    <select name="id_klurahn" id="id_klurahn" style="width: 480px;">
                                        <option value="0">Pilih Kelurahan</option>                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Luas Area (ha)</label>

                                <div class="col-md-6">
                                    <input id="luas_area" name="luas_area" type="number" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Jumlah Unit</label>

                                <div class="col-md-6">
                                    <input id="jml_unit" name="jml_unit" type="number" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Jenis Produk</label>

                                <div class="col-md-6">
                                    <select name="jenis_produk" id="jenis_produk" style="width: 480px; height: 30px;">
                                        <option value="0">Pilih Produk</option>
                                        <option value="1">Rumah Tapak</option>
                                        <option value="2">Rumah Susun</option>
                                        <option value="3">Rumah Toko</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Tanggal Mulai</label>

                                <div class="col-md-6">
                                    <input id="tgl_mulai" name="tgl_mulai" type="date" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Tanggal Selesai</label>

                                <div class="col-md-6">
                                    <input id="tgl_target" name="tgl_target" type="date" class="form-control" required oninvalid="this.setCustomValidity('Data belum terisi.')" oninput="setCustomValidity('')">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Siteplan</label>

                                <div class="col-md-6">
                                    <input size="100" type="file" class="custom-file-input" id="siteplan" aria-describedby="fileHelp" name="siteplan" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="exampleInputFile">
                                        Pilih file...
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">UKL-UPL</label>

                                <div class="col-md-6">
                                    <input size="100" type="file" class="custom-file-input" id="ukl_upl" aria-describedby="fileHelp" name="ukl_upl" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="exampleInputFile">
                                        Pilih file...
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">IMB</label>

                                <div class="col-md-6">
                                    <input size="100" type="file" class="custom-file-input" id="imb" aria-describedby="fileHelp" name="imb" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="exampleInputFile">
                                        Pilih file...
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">IPB</label>

                                <div class="col-md-6">
                                    <input size="100" type="file" class="custom-file-input" id="ipb" aria-describedby="fileHelp" name="ipb" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="exampleInputFile">
                                        Pilih file...
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Sertifikat Tanah</label>

                                <div class="col-md-6">
                                    <input size="100" type="file" class="custom-file-input" id="sertifikat_tanah" aria-describedby="fileHelp" name="sertifikat_tanah" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="exampleInputFile">
                                        Pilih file...
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Akta Notaris</label>

                                <div class="col-md-6">
                                    <input size="100" type="file" class="custom-file-input" id="akta_notaris" aria-describedby="fileHelp" name="akta_notaris" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="exampleInputFile">
                                        Pilih file...
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Sertifikat PSU</label>

                                <div class="col-md-6">
                                    <input size="100" type="file" class="custom-file-input" id="sertifikat_psu" aria-describedby="fileHelp" name="sertifikat_psu" required oninvalid="this.setCustomValidity('Format file belum benar.')" oninput="setCustomValidity('')" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="exampleInputFile">
                                        Pilih file...
                                    </label>
                                </div>
                            </div>
                        </form>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-success" onclick="confirmTest()">
                                    {{ __('Simpan') }}
                                </button>                                    
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
    var file = document.getElementById("sertifikat_psu");

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
            if(check_sertifikat_psu() == false || check_akta_notaris() == false || check_sertifikat_tanah() == false || check_ipb() == false || check_imb() == false || check_ukl_upl() == false || check_siteplan() == false)
                alert('Format file masih salah, harus pdf atau image.');
        
            if(check_sertifikat_psu() == true && check_akta_notaris() == true && check_sertifikat_tanah() == true && check_ipb() == true && check_imb() == true && check_ukl_upl() == true && check_siteplan() == true)
                document.getElementById("new_proyek").submit();
        }
    }

    function check_siteplan()
    {
        var file = document.getElementById("siteplan");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
            return false;
        else
            return true;
    }

    function check_ukl_upl()
    {
        var file = document.getElementById("ukl_upl");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
            return false;
        else
            return true;
    }

    function check_imb()
    {
        var file = document.getElementById("imb");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
            return false;
        else
            return true;
    }

    function check_ipb()
    {
        var file = document.getElementById("ipb");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
            return false;
        else
            return true;
    }

    function check_sertifikat_tanah()
    {
        var file = document.getElementById("sertifikat_tanah");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
            return false;
        else
            return true;
    }

    function check_akta_notaris()
    {
        var file = document.getElementById("akta_notaris");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
            return false;
        else
            return true;
    }

    function check_sertifikat_psu()
    {
        var file = document.getElementById("sertifikat_psu");
        if(file.value.split('.')[1] != 'pdf' && file.value.split('.')[1] != 'jpg' && file.value.split('.')[1] != 'png' && file.value.split('.')[1] != 'jpeg')
            return false;
        else
            return true;
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