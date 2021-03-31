@extends('layouts.master')

@section('title', '')

@push('css')
    <style>
        .table td, .table th {
            padding: 8px 10px !important;
        }

        .student-copy {
            margin-top: 120px;
            font-size: 20px;
        }

        .institute-copy {
            margin-top: 100px;
            font-size: 20px
        }

        body {
            background: white;
        }
    </style>
@endpush

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10 text-right">
            <button type="button" onclick="print_money_receipt()" class="btn btn-dark">
                <i class="fa fa-print"></i>
            </button>
        </div>
    </div>

    <div id="student_copy">
        <div class="row student-copy">
            <div class="col-md-10 offset-md-1">

                <div class="row mb-2">
                    <div class="col-md-7">
                        <img src="{{asset('images/EUITSols Institute New.png')}}" style="height: 40px;" alt="">
                    </div>
                    <div class="col-md-5">
                        <h5 style="color: #26ACE2;">European IT Solutions Institute</h5>
                        Noor Mansion (3rd Floor), Plot#04, Main Road#01, Mirpur-10, Dhaka-1216
                    </div>
                </div>

                <div class="my-4">
                    <p class="text-center py-3 font-weight-bold">MONEY RECEIPT</p>
                    <div class="border p-1 mb-2">
                        <div class="clearfix">
                            <div class="float-left"><b>Receipt Number:</b> {{$receipt_no}}</div>
                            <div class="float-right"><b>Date:</b> {{date('D d F, Y')}}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>ID</th>
                                <td>:</td>
                                <td>{{$student->year.$student->reg_no}}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>:</td>
                                <td>{{$student->name}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>:</td>
                                <td>{{$student->phone}}</td>
                            </tr>
                            <tr>
                                <th>Course</th>
                                <td>:</td>
                                <td>{{$course->title}}</td>
                            </tr>
                            <tr>
                                <th>Batch</th>
                                <td>:</td>
                                <td>{{$batch_name}}</td>
                            </tr>
                        </table>
                        @if($due > 0 && count($_installment_dates) > 0)
                            <table class="table">
                                <tr>
                                    <th>Installment Date</th>
                                    <th>Amount</th>
                                </tr>
                                @foreach($_installment_dates as $installment_date)
                                    <tr>
                                        <td>{{ date('D d F, Y', strtotime($installment_date)) }}</td>
                                        <td>{{ ceil($installment_amount) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>Course Fee</th>
                                <td>:</td>
                                <td>{{$course->fee}}</td>
                            </tr>
                            @if ($account->discount_percent > 0 || $account->discount_amount > 0)
                                <tr>
                                    <th>Discount</th>
                                    <td>:</td>
                                    <td>
                                        @if($account->discount_percent > 0)
                                            {{$account->discount_percent}} %
                                        @elseif($account->discount_amount > 0)
                                            {{$account->discount_amount}}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            @if ($account->installment_quantity > 0)
                                <tr>
                                    <th>Installment</th>
                                    <td>:</td>
                                    <td>{{$account->installment_quantity}}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Total Fee</th>
                                <td>:</td>
                                <td>{{number_format($total_fee, 2)}}</td>
                            </tr>
                        </table>
                        <table class="table">
                            <tr>
                                <th>Payment Date</th>
                                <th>Amount</th>
                            </tr>
                            @if ($payments->count() > 0)
                                @foreach($payments as $_payment)
                                    <tr>
                                        <td>{{date('D d F, Y', strtotime($_payment->created_at))}}</td>
                                        <td>{{$_payment->amount}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                        <p class="text-left mt-4" style="padding-left: 12px;">
                            <b>Paid : </b> {{number_format($total_payments, 2)}}
                            <b class="ml-2">Due : </b> {{number_format($due, 2)}}
                        </p>
                    </div>
                </div>

                <div style="margin-top: 150px;">
                    <p class="float-left border-top ml-5"> Received By </p>
                    <p class="float-right" style="font-size: 14px;">
                        # Software generated money receipt
                    </p>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function print_money_receipt() {
            printT('student_copy', 'money_receipt');
        }

        function printT(el, title = '') {
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush

