@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    @if($errors->has('today') || $errors->has('date'))
                        <span class="help-block text-danger">Please Do Not Mess With The Original Code !!!</span>
                    @endif
                    <div class="card-header text-center">
                        <span class="float-left"><h4>Birthdays</h4></span>
                        <button type="button" onclick="printT('print-student')"
                                class="btn btn-dark btn-sm text-center"><i class="fa fa-print"></i>
                        </button>
                        <span class="float-right">
                        <form action="{{route('birthday.p')}}" method="post">
                            @csrf
                            <input type="date" name="date" required>
                            <input type="hidden" name="today" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                            <button type="submit" class="btn btn-sm btn-secondary">search</button>
                        </form>
                    </span>

                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif
                        <div class="table-responsive" id="print-student">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Date Of Birth</th>
                                    <th>Institute</th>
                                    <th>Batches</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($students as $i => $student)
                                    <tr>
                                        <td> {{ $i + 1 }} </td>
                                        <td> {{ $student->name }} </td>
                                        <td> {{ $student->phone }} </td>
                                        <td> {{ $student->dob }} </td>
                                        <td> {{ $student->institute }} </td>
                                        <td>
                                            @forelse($student->batches as $b)
                                                {{$b }}
                                            @empty
                                                No batch to show
                                            @endforelse
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function printT(el) {
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'student-list';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
