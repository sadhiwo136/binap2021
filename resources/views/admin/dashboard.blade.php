@extends('layouts.master')

@section('title')
    Dashboard | PSU App Prototype
@endsection()

@section('content')
<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
        <h4 class="card-title">Summary</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                        <th class="text-center">Anggota</th>                        
                        <th class="text-center">Kelurahan</th>
                        <th class="text-center">Kecamatan</th>
                        <th class="text-center">Kota</th>
                        <th class="text-center">Perusahaan</th>
                        <th class="text-center">Laporan</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><h3>{{$c1}}</h3></td>
                            <td class="text-center"><h3>{{$d1}}</h3></td>
                            <td class="text-center"><h3>{{$d2}}</h3></td>
                            <td class="text-center"><h3>{{$m1}}</h3></td>
                            <td class="text-center"><h3>{{$n1}}</h3></td>
                            <td class="text-center"><h3>{{$L1}}</h3></td>
                        </tr>                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    
@endsection()

@section('scripts')
@endsection()