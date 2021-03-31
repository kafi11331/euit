
@extends('layouts.master')
@section('title', 'Summary - European IT Solutions Institute')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush
@section('content')
@php
    $discount = 0;
    $total_due = 0;
    $not_interested_due = 0;
    $actual_due = 0;
@endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                            <span class="text-center">
                            	<h4>Summary Report<small>-{{$batch_name}}</small></h4>
                            </span>
                    </div>
                     <div class="card-body">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="industrial" role="tabpanel"
                                 aria-labelledby="nav-home-tab">
                                <div class="table-responsive">
                                    <table id="table_one" class="display nowrap table table-bordered text-center table-sm" style = "">
                                        <thead>
                                        <tr >
                                            <th class="align-middle">Course Name</th>
                                            <th class="align-middle">Batch Number</th>
                                            <th class="align-middle">
                                            	Total Course Fee<small>(BDT)</small>
                                            </th>
                                            <th class="align-middle">
                                            	Total paid<small>(BDT)</small>
                                            </th>
                                            <th class="align-middle">
                                            	Total Due <small>(BDT)</small>
                                            </th>
                                            <th class="align-middle">
                                            	Not Interested  Due <small>(BDT)</small>
                                            </th>
                                            <th class="align-middle">
                                            	Actual Due <small>(BDT)</small>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($all_batches) > 0)
                                                @foreach ($all_batches as $key1 => $in_batch)
                                                    <tr>
                                            	        <td rowspan="{{count($in_batch)+1}}" class="align-middle">
                                            		        {{$key1}}
                                            	        </td>

                                            	     @forelse ($in_batch as $ib)

                                            	        <td rowspan="">
                                            	 	        {{batch_name(optional($ib->course)->title_short_form, $ib->year, $ib->month, $ib->batch_number)}}
                                                        @php
                                                            $total_student = $ib->students->count();
                                                            $total_discount = 0;
                                                            $total_fee = $ib->course->fee;
                                                        @endphp
                                            	        </td>
                                                        <td>
                                                            @forelse($ib->students as $key => $student)
                                                                @forelse($student->accounts as $key2 => $acc)
                                                                    @php
                                                                        $account_id[] = $acc->id;
                                                                        $discount = $acc->discount_amount;
                                                                        $total_discount += $discount;
                                                                    @endphp
                                                                @empty
                                                                @endforelse
                                                            @empty
                                                            @endforelse
                                                            {{$total_course_fee = ($total_student*$total_fee)-$total_discount}}
                                                        </td>
                                                        <td>@php
                                                                $total_paid = 0;
                                                            @endphp
                                                            @forelse($ib->students as $key => $student)
                                                                    @php
                                                                        $total_payment = 0;
                                                                    @endphp
                                                                @forelse($student->accounts as $key3 => $acc)

                                                                    @forelse($acc->payments as $key4 => $pmt)
                                                                        @php

                                                                        $payment = $pmt->amount ;
                                                                        $total_payment +=  $payment;

                                                                        @endphp
                                                                    @empty
                                                                    @endforelse
                                                                    @php
                                                                        $total_paid += $total_payment;
                                                                    @endphp
                                                                @empty
                                                                @endforelse
                                                            @empty
                                                            @endforelse
                                                            {{$total_paid}}
                                                        </td>
                                                        <td>
                                                            {{$total_due = $total_course_fee-$total_paid}}
                                                        </td>

                                                        <td>
                                                            {{$not_interested_due}}
                                                        </td>
                                                        <td>
                                                            {{$not_interested_due = $total_due - $not_interested_due}}
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    @endforelse

                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th class="align-middle">Course Name</th>
                                            <th class="align-middle">Batch Number</th>
                                            <th class="align-middle">
                                            	Total Course Fee<small>(BDT)</small>
                                            </th>
                                            <th class="align-middle">
                                            	Total paid<small>(BDT)</small>
                                            </th>
                                            <th class="align-middle">
                                            	Total Due <small>(BDT)</small>
                                            </th>
                                            <th class="align-middle">
                                            	Not Interested  Due <small>(BDT)</small>
                                            </th>
                                            <th class="align-middle">
                                            	Actual Due <small>(BDT)</small>
                                            </th>
                                        </tr>
                                        </tfoot>
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
    <script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table_one').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Industrial Courses'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                    }, 'pageLength'
                ]
            });

    </script>
@endpush


