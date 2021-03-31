@extends('layouts.master')

@section('title', 'Create User - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User</h4>
                    </div>

                    <div class="card-body">

                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @elseif(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @endif

                        <div class="row">
                            <div class="col-md-6">

                                <form action="{{route('user.store')}}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" value="{{old('name')}}" id="name" class="form-control">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="username" class="form-control-label">Username <span class="text-danger">*</span> </label>
                                        <input type="text" name="username" value="{{old('username')}}" id="username" class="form-control">
                                        @if ($errors->has('username'))
                                            <span class="text-danger">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-control-label">Password <span class="text-danger">*</span> </label>
                                        <input type="password" name="password" id="password" class="form-control">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password" class="form-control-label">Confirm Password <span class="text-danger">*</span> </label>
                                        <input type="password" name="password_confirmation" id="confirm_password" class="form-control">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                    </div>

                                </form>

                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Action</th>
                                        </tr>
                                        @forelse ($users as $key => $user)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->username}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{route('user.edit', $user->id)}}" class="btn btn-info btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        @if ($user->role != 'admin')
                                                            <a href="{{route('user.destroy', $user->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    No user found!
                                                </td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush