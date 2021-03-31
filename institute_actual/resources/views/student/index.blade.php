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
                    <div class="card-header">
                    <span class="float-left">
                        <h4> {{$student_as}} Students <span class="badge badge-blue">{{$students->count()}}</span> </h4>
                    </span>
                    @if($totalStudents)
                        <h6 class="float-right"> Total Students {{count($totalStudents)}}</h6>
                    @endif
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

                        @if ($years->count() > 0)
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-3">
                                    <div class="row">
                                        <label for="year" class="col-md-3">Select Year</label>
                                        <div class="col-md-9">
                                            <select id="year" class="form-control form-control-sm">
                                                <option value="">Choose...</option>
                                                @foreach ($years as $_year)
                                                    <option value="{{ $_year->year }}" {{ $year == $_year->year ? 'selected' : '' }}>
                                                        {{ $_year->year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="table" class="display nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Institute</th>
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($students as $key => $student)
                                    <tr>
                                        <td> {{ $student->year.$student->reg_no }} </td>
                                        <td> {{ $student->name }} </td>
                                        <td> {{ $student->phone }} </td>
                                        <td> {{ optional($student->institute)->name }} </td>
                                        <td> {{ optional($student->user)->name }} </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('student.show', $student->id) }}"
                                                   class="btn btn-sm btn-dark">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('student.edit', $student->id) }}"
                                                   class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('student.delete', $student->id) }}"
                                                   onclick="return confirm('Are you sure?')"
                                                   class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Institute</th>
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.print.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            $(document).on('change', '#year', function () {
                if ('' !== $(this).val()) {
                    let _url = '{{route('students', [lcfirst($student_as), '_year'])}}';
                    window.location.href = _url.replace('_year', $(this).val());
                }
            });

            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Students'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>

@endpush
