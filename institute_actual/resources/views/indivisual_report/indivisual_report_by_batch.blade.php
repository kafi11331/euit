@extends('layouts.master')
@section('title', 'Indivisual Summary  - European IT Solutions Institute')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush
@section('content')
<button onClick="window.print('#table_one')">Print this page</button>

@php
    $row_1 = 0;$discount = 0;$all_course_fee = 0;$all_paid = 0;$all_due = 0;$total_due = 0;$not_interested_due = 0; $actual_due = 0;$all_not_interested_due = 0;$all_actual_due = 0;$count = 0;$discount = 0;$course_fee = 0; $total_payment = 0;
    $total_paid = 0;$total_course_fee = 0;$total_student = 0;$total_course_fee = 0;$total_discount = 0;$comment = "nothing"; $status = "not defined";
    $tr_count_1 = 0;$row_span_1 = 0; $row_span_2 = 0; $sl = 0;$table_a = [];$tr_1 = "";$align_middle = "align-middle";$table_active = "table-active";
@endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                            <span class="text-center">
                            	<h4>Indivisual Report<small>-{{$batch_name}}</small></h4>
                            </span>
                    </div>
                     <div class="card-body" style = "visibility:hidden;">
                        @if(session('success'))
                        <p class="alert alert-success text-center hide">
                            {{ session('success') }}
                        </p>
                    @elseif(session('error'))
                        <p class="alert alert-danger text-center hide">
                            {{ session('error') }}
                        </p>
                    @endif
                                <div class="table-responsive">
                                    <table id="table_one" class="table table-bordered text-center " style = "visibility:visible;">
                                        <tr >
                                            <th class="align-middle">Course Name</th>
                                            <th class="align-middle">Batch Number & Mentor</th>
                                            <th class="align-middle">#SL</th>
                                            <th class="align-middle">Name</th>
                                            <th class="align-middle">Phone Number</th>
                                            <th class="align-middle">Course Fee</th>
                                            <th class="align-middle">Paid</th>
                                            <th class="align-middle">Due</th>
                                            <th class="align-middle">Not Interested Due</th>
                                            <th class="align-middle">Actual Due</th>
                                            <th class="align-middle">Comment</th>
                                            <th class="align-middle">Status</th>
                                        </tr>
                                        {{-- {{count($all_batches)}} --}}
                                            @if (count($all_batches) > 0)
                                                @php
                                                    foreach ($all_batches as $key1 => $in_batch)
                                                    {
                                                        $table = $key1."</td>";//******************************Course Name*************************
                                                        foreach ($in_batch as $ib)
                                                        {
                                                            $total_paid = 0;
                                                            $row_span_2 = count($ib->students)+1;
                                                            $batch_name = batch_name(optional($ib->course)->title_short_form, $ib->year, $ib->month, $ib->batch_number);
                                                            $table .= $tr_1."<td class = '".$align_middle."' rowspan ='".$row_span_2."'>".$batch_name."</td>";//******************************Batch Number & Mentor******************************
                                                            $course_fee = $ib->course->fee;
                                                            foreach($ib->students as $key => $student)
                                                            {
                                                                $total_payment = 0;
                                                                $row_1++;
                                                                $sl++;
                                                                $total_discount = 0;
                                                                $name = $student->name;
                                                                $phone_number = $student->phone;
                                                                $student_id = $student->id;
                                                                $table .= "<td class = '".$align_middle."' >".$sl."</td>";//******************************#SL******************************
                                                                $table .= "<td class = '".$align_middle."' >".$name."</td>";//******************************Name******************************
                                                                $table .= "<td class = '".$align_middle."' >".$phone_number."</td>";//******************************Phone Number******************************
                                                                foreach($student->accounts as $key2 => $acc)
                                                                {
                                                                    $discount = $acc->discount_amount;

                                                                    foreach($acc->payments as $key4 => $pmt)
                                                                    {
                                                                        $payment = $pmt->amount ;
                                                                        $total_payment +=  $payment;
                                                                    }
                                                                    $total_paid += $total_payment;
                                                                }
                                                                $total_course_fee = $course_fee - $discount ;
                                                                $all_course_fee += $total_course_fee;
                                                                $table .= "<td class = '".$align_middle."' >".$total_course_fee."</td>";//******************************Course Fee******************************
                                                                $table .= "<td class = '".$align_middle."' >".$total_payment."</td>";//******************************Paid******************************
                                                                    $total_due = $total_course_fee - $total_payment;
                                                                    $all_due +=$total_due;
                                                                    $discount = 0;
                                                                $table .= "<td class = '".$align_middle."' >".$total_due."</td>";//******************************Due******************************
                                                                $table .= "<td class = '".$align_middle."' >".$not_interested_due."</td>";//******************************Not Interested Due******************************
                                                                    $actual_due = $total_due - $not_interested_due;
                                                                    $all_not_interested_due += $not_interested_due;
                                                                    $all_actual_due += $actual_due;
                                                                $table .= "<td class = '".$align_middle."' >".$actual_due."</td>";//******************************Actual Due******************************
                                                                $table .= "<td class = '".$align_middle."' >".$comment."</td>";//******************************Comment Due******************************
                                                                $table .= "<td class = '".$align_middle."' >".$status."</td>";//******************************Status******************************


                                                                $table .= "</tr>";
                                                            }
                                                            $row_1++;
                                                            $sl = 0;
                                                            $tr_count_1++;
                                                            $table .= "<tr class = '".$table_active."' ><td class = '".$align_middle."' ></td>";//sl
                                                                $table .= " <td class = '".$align_middle."' ></td>";//name
                                                                $table .= "<td class = '".$align_middle."' >Total</td>";//phone
                                                                $table .= "<td class = '".$align_middle."' >".$all_course_fee."</td>";//course_fee
                                                                $all_course_fee = 0;
                                                                $table .= "<td class = '".$align_middle."' >".$total_paid."</td>";//Paid
                                                                $table .= "<td class = '".$align_middle."' >".$all_due."</td>";//due
                                                                $all_due = 0;
                                                                $table .= " <td class = '".$align_middle."' >".$all_not_interested_due."</td>";//not interested due
                                                                $all_not_interested_due = 0;
                                                                $table .= "<td class = '".$align_middle."' >".$all_actual_due."</td>";//actual due
                                                                $all_actual_due = 0;
                                                                $table .= "<td class = '".$align_middle."' ></td>";//comment
                                                                $table .= "<td class = '".$align_middle."' ></td></tr>";//status



                                                        }
                                                        $row_span_1 = $row_1;
                                                        $pre_table = "<td  class = '".$align_middle."'  rowspan ='".$row_span_1."'>";
                                                        $row_1 =0;
                                                        $final_table = "".$pre_table. "".$table;
                                                        $table_a[] = $final_table;
                                                    }
                                                    print_r($table_a);
                                                @endphp
                                            @endif
                                            <tr>
                                                <th class="align-middle">Course Name</th>
                                                <th class="align-middle">Batch Number & Mentor</th>
                                                <th class="align-middle">#SL</th>
                                                <th class="align-middle">Name</th>
                                                <th class="align-middle">Phone Number</th>
                                                <th class="align-middle">Course Fee</th>
                                                <th class="align-middle">Paid</th>
                                                <th class="align-middle">Due</th>
                                                <th class="align-middle">Not Interested Due</th>
                                                <th class="align-middle">Actual Due</th>
                                                <th class="align-middle">Comment</th>
                                                <th class="align-middle">Status</th>
                                            </tr>
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
            $('#table_one').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Summary'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6]
                        }
                    }, 'pageLength'
                ]
            });


        });
    </script>
@endpush


