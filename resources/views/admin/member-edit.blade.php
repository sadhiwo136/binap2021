@extends('layouts.master')

@section('title')
    Edit Member | PSU App Prototype
@endsection()

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Member Role</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/role-register-update/{{ $users->id }}" method="POST">

                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="form-group">
                                    <label>Name: </label>
                                    <input type="text" name="username" value="{{ $users->name }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Phone: </label>
                                    <input type="text" name="phone" value="{{ $users->phone }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Role: </label>
                                    <select name="usertype" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="developer">Developer</option>
                                        <option value="warga">Warga</option>
                                        <option value="verifikator">Verifikator</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Email Lama: </label>
                                    <input type="text" name="email" value="{{ $users->email }}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Password Lama: </label>
                                    <input type="text" name="password" value="{{ $users->password }}" class="form-control" disabled>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="/role-member" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection