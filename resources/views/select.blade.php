<!DOCTYPE html>
<html>
<head>
    <title>Dropdown Test</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
</head>
<body>

<center>
    <h1>Laravel select dropbox using select2 without sql join + ajax</h1>
    <span>Kota: </span>
    <select id="nameku1" style="width: 300px;">
        <option></option>
        @foreach($data3 as $r)
            <option>{{ $r->nama }}</option>
        @endforeach
    </select>
    <span>Kecamatan: </span>
    <select id="nameku2" style="width: 300px;">
        <option></option>
        @foreach($data2 as $r)
            <option>{{ $r->nama }}</option>
        @endforeach
    </select>
    <span>Kelurahan: </span>
    <select id="nameku3" style="width: 300px;">
        <option></option>
        @foreach($data1 as $r)
            <option>{{ $r->nama }}</option>
        @endforeach
    </select>

    <h1>sql join + ajax</h1>
    <span>Kota: </span>
    <select id="nameku4" style="width: 300px;">
        <option value='0'>-- pilih kota --</option>
        @foreach($data3 as $r)
            <option value="{{ $r->id }}">{{ $r->nama }}</option>
        @endforeach
    </select>
    <span>Kecamatan: </span>
    <select id="nameku5" style="width: 300px;">
        <option value='0'>-- pilih kecamatan --</option>
    </select>
    <span>Kelurahan: </span>
    <select id="nameku6" style="width: 300px;">
        <option value='0'>-- pilih kelurahan --</option>
    </select>
</center>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type ="text/javascript">
    $("#nameku1").select2(
        {
            placeholder: "select a name",
            allowClear: true
        }
    );
    $("#nameku2").select2(
        {
            placeholder: "select a name",
            allowClear: true
        }
    );
    $("#nameku3").select2(
        {
            placeholder: "select a name",
            allowClear: true
        }
    );
    $("#nameku4").select2(
        {
            placeholder: "select a name",
            allowClear: true
        }
    );
    $("#nameku5").select2(
        {
            placeholder: "select a name",
            allowClear: true
        }
    );
    $("#nameku6").select2(
        {
            placeholder: "select a name",
            allowClear: true
        }
    );
    $(document).ready(function(){
        // Kecamatan
        $('#nameku4').change(function()
        {            
            var id = $(this).val();
            // Empty the dropdown
            $('#nameku5').find('option').not(':first').remove();
            $('#nameku6').find('option').not(':first').remove();

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
                            $("#nameku5").append(option); 
                        }
                    }

                }
            });
        });
        // Kelurahan
        $('#nameku5').change(function()
        {
            // Empty the dropdown
            $('#nameku6').find('option').not(':first').remove();
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
                            $("#nameku6").append(option); 
                        }
                    }

                }
            });
        });
    });
</script>

</body>
</html>