@extends('layouts.master')

@section('title', 'Create Student - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet"
          href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <style>
        fieldset {
            width: 100% !important;
            padding: 5px !important;
            border: 1px solid lightgray;
        }

        legend {
            width: auto;
            font-size: 20px;
        }

        table, tr, td {
            margin: 0 !important;
            padding: 5px !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Assign Course For Student</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('students', $student->year) }}"
                           class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="mb-3">
                                    <legend>Student Information</legend>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>ID</td>
                                                <td>:</td>
                                                <td>{{ $student->id }}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{ $student->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Student As</td>
                                                <td>:</td>
                                                <td>{{ $student->student_as }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>{{ $student->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Institute</td>
                                                <td>:</td>
                                                <td>{{ optional($student->institute)->name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="mb-3">
                                    <legend>Course Information</legend>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Course</td>
                                                <td>:</td>
                                                <td>{{ optional($batch->course)->title }}</td>
                                            </tr>
                                            <tr>
                                                <td>Batch</td>
                                                <td>:</td>
                                                <td>{{ batch_name(optional($batch->course)->title_short_form, $batch->year, $batch->month, $batch->batch_number) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Course Fee</td>
                                                <td>:</td>
                                                <td>{{ optional($batch->course)->fee }}</td>
                                            </tr>
                                            <tr>
                                                <td>Payable Fee</td>
                                                <td>:</td>
                                                <td>{{ $total_fee }}</td>
                                            </tr>
                                            @if ($payments > 0 && ($total_fee <= $payments))
                                                <tr>
                                                    <td>Paid</td>
                                                    <td>:</td>
                                                    <td>{{ $payments }}</td>
                                                </tr>
                                            @elseif ($due)
                                                <tr>
                                                    <td>Due</td>
                                                    <td>:</td>
                                                    <td>{{ $due }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        @if ($errors->has('course'))
                            <p class="alert alert-danger text-center">{{ $errors->first('course') }}</p>
                        @elseif ($errors->has('batch'))
                            <p class="alert alert-danger text-center">{{ $errors->first('batch') }}</p>
                        @elseif (session('error'))
                            <p class="alert alert-danger text-center">{{ session('error') }}</p>
                        @endif

                        <form action="{{route('student.course.migrate')}}" method="post" class="mt-3">
                            @csrf

                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <input type="hidden" name="old_batch_id" value="{{ $batch->id }}">

                            <div class="row" id="courses">
                                @foreach ($course_types as $course_type)
                                    <div class="col-md-6 mb-2">
                                        <p class="font-weight-bold">{{ $course_type->type_name }}</p>

                                        @foreach ($course_type->courses as $k => $course)

                                            <div class="ml-3 mb-2">

                                                @if (in_array($course->id, $student_course_exist))

                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input type="checkbox" checked disabled="disabled"
                                                               class="custom-control-input">
                                                        <label class="custom-control-label"
                                                               for="customControlAutosizing">{{ $course->title }}</label>

                                                        @foreach ($course->batches as $bk => $batch)
                                                            @if (in_array($batch->id, $student_batch_ids))
                                                                <span class="border py-1 px-3 ml-2">
                                                                {{batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                                                    {{'('.$batch->students->count().')'}}
                                                            </span>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                @else

                                                    <div>

                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" name="course"
                                                                   id="course_{{ $course->id }}"
                                                                   value="{{ $course->id }}"
                                                                   {{$course->batches->count() > 0 ? '' : 'disabled'}} class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="course_{{ $course->id }}">{{ $course->title }}</label>

                                                            @if ($course->batches->count() > 0)
                                                                <select name="batch"
                                                                        class="ml-2 form-control-sm batches">
                                                                    <option selected disabled hidden> Choose Batch
                                                                    </option>
                                                                    @foreach ($course->batches as $bk => $batch)
                                                                        <option value="{{ $batch->id }}">
                                                                            {{batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                                                            {{'('.$batch->students->count().')'}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <span class="border py-1 px-3 ml-2 text-danger"> No batch found </span>
                                                            @endif
                                                        </div>

                                                    </div>

                                                @endif

                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <div class="row my-4">
                                <label for="note" class="col-md-3">
                                    <u>Course Migration Note</u>
                                </label>
                                <div class="col-md-9">
                                    <textarea name="note" id="note" class="form-control"></textarea>
                                    @if ($errors->has('note'))
                                        <span class="text-danger">{{$errors->first('note')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <input type="submit" value="Migrate" class="btn btn-danger btn-block">
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("js")
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>
    <script type="text/javascript">
        $("#institute").select2();
        CKEDITOR.replace('note', {height: 100});
    </script>
    <script>
        $(document).on('change', 'input[type=radio]', function () {
            $('#courses').contents().find('select').hide();
            $(this).parent().parent().find('select').slideDown();
        });
    </script>
@endpush