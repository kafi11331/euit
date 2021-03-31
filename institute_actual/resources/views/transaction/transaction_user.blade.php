@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Daily Transaction Report </h4>
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

                        <div class="clearfix">
                            <p class="float-left">
                                <i class="fa fa-money-bill"></i>
                                @if($user == 'all')
                                    Transactions of all users
                                @else
                                    Transactions By <b>{{ $user->name }}</b>
                                @endif
                            </p>
                            <p class="float-right"><b>Date : </b> {{ date('D d F, Y') }}</p>
                        </div>

                        @if (!empty($payments))

                            @php($total = 0)

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>SL</th>
                                        <th>Batch</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Student As</th>
                                        <th>Amount</th>
                                    </tr>

                                    @foreach ($payments as $pk => $payment)

                                        @php($total += $payment->amount)

                                        <tr>
                                            <td>{{ ++$pk }}</td>
                                            <td>{{ $payment->batch }}</td>
                                            <td>{{ $payment->student_name }}</td>
                                            <td>{{ $payment->student_phone }}</td>
                                            <td>{{ $payment->student_as }}</td>
                                            <td>{{ $payment->amount }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <p class="text-center" style="font-size: 20px;">
                                <b>Total Transaction :</b> {{ number_format($total, 2) }} Taka
                            </p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
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
