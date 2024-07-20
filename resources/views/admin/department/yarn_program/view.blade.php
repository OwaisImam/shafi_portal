@extends('layouts.departments.master')

@section('title')
    @lang('translation.Orders')
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/toastr/build/toastr.min.css') }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.Departments')
        @endslot
        @slot('li_2')
            {{ $department->name }}
        @endslot
        @slot('title')
            View @lang('translation.YarnProgram')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Job No: </th>
                                        <td>{{ $yarnProgram->job->number }}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Name: </th>
                                        <td>{{ $yarnProgram->name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="orders-row">
                        <div id="repeater-container">
                            <table class="table main_table">
                                <thead>
                                    <tr>
                                        <th>Job#</th>
                                        @foreach ($yarnProgram->job->orders as $key => $order)
                                            <th class="text-center">{{ $order->fabric_construction->name }}
                                                ({{ $order->code }})</th>
                                        @endforeach
                                        <th>Total Kgs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_kgs = 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $yarnProgram->job->number }}</td>
                                        @foreach ($yarnProgram->job->orders as $key => $order)
                                            <td>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Qty:</th>
                                                            <td>{{ $order->order_quantity }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Required Kg:</th>
                                                            <td>{{ $yarnProgram->items->where('order_id', $order->id)->first()->required_kgs }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            @php
                                                $total_kgs += $yarnProgram->items
                                                    ->where('order_id', $order->id)
                                                    ->first()->required_kgs;
                                            @endphp
                                        @endforeach
                                        <td>{{ $total_kgs }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @php
                                $totalKgs = 0;
                                $totalBags = 0;
                            @endphp
                            @foreach ($yarnProgram->job->orders as $key => $order)
                                @php
                                    $subTotalKgs = 0;
                                    $subTotalBags = 0;
                                @endphp
                                <div class="card">
                                    <div class="card-body">
                                        <h5>{{ $order->fabric_construction->name }} ({{ $order->code }})
                                        </h5>
                                        <div>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Count</th>
                                                        <th>Fiber</th>
                                                        <th>Percentage</th>
                                                        <th>Total Kgs</th>
                                                        <th>Total Bags</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($yarnProgram->items->where('order_id', $order->id) as $item)
                                                        <tr>
                                                            <td>{{ $item->count->name }}</td>
                                                            <td>{{ $item->fiber->name }}</td>
                                                            <td>{{ $item->percentage }}</td>
                                                            <td>{{ $item->kgs }}</td>
                                                            <td>{{ $item->bags }}</td>
                                                        </tr>
                                                        @php
                                                            $totalKgs += $item->kgs;
                                                            $totalBags += $item->bags;
                                                            $subTotalKgs += $item->kgs;
                                                            $subTotalBags += $item->bags;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3">Total</th>
                                                        <th>{{ $subTotalKgs }}</th>
                                                        <th>{{ $subTotalBags }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <table class="table footer_table">
                                <thead>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th id="sum_kgs">{{ number_format($totalKgs, 2) }} Kgs</th>
                                        <th id="sum_bags">{{ number_format($totalBags, 2) }} Bags</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end card -->
        </div> <!-- end col -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/inputmask/inputmask.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/inputmask/jquery.inputmask.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-mask.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/yarn-program-form-repeater.int.js') }}"></script>

    <script src="{{ URL::asset('build/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
    <!-- form advanced init -->
    <script src="{{ URL::asset('build/libs/toastr/build/toastr.min.js') }}"></script>
    <!-- toastr init -->
    <script src="{{ URL::asset('build/js/pages/toastr.init.js') }}"></script>

    <script src="{{ URL::asset('build/libs/table-edits/build/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/table-editable.int.js') }}"></script>

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr["error"]('{{ $error }}');
            @endforeach
        </script>
    @endif
    @if (session('success'))
        <script>
            toastr["success"]('{{ session('success') }}');
        </script>
    @endif
    @if (session('error'))
        <script>
            toastr["error"]('{{ session('error') }}');
        </script>
    @endif
@endsection
