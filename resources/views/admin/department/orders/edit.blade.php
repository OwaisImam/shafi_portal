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
            @lang('translation.Orders')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="repeater needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="{{ route('admin.departments.orders.update', ['slug' => $department->slug, 'order' => $order->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="supplier" class="form-label">Customer's PO Number</label>
                                    <input type="text" name="customer_po_number"
                                        value="{{ $order->customer_po_number ? $order->customer_po_number : old('customer_po_number') }}"
                                        class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid po no.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="moobile_no" class="form-label">Job No</label>
                                    <select name="job_id" class="form-control select2" required>
                                        <option>Select</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ $order->job_id == $job->id ? 'selected' : '' }}>{{ $job->number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid job no.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer" class="form-label">Customer</label>
                                    <select class="form-control select2" name="customer_id">
                                        <option>Select</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $order->customer_id == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid customer.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="serial_no" class="form-label">PO Receive Date</label>
                                    <input type="date" class="form-control" id="po_receive_date"
                                        placeholder="PO Receive Date"
                                        value="{{ $order->po_receive_date ? $order->po_receive_date : old('po_receive_date') }}"
                                        required name="po_receive_date">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the po receive date.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Delivery Date</label>
                                    <input type="date" class="form-control" id="delivery_date" placeholder="Deliery Date"
                                        value="{{ $order->delivery_date ? $order->delivery_date : old('delivery_date') }}"
                                        required name="delivery_date">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid delivery date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gst_no" class="form-label">Payment Terms</label>
                                    <select name="payment_term_id" class="form-control select2">
                                        <option>Select</option>
                                        @foreach ($paymentTerms as $paymentTerm)
                                            <option value="{{ $paymentTerm->id }}"
                                                {{ $order->payment_term_id == $paymentTerm->id ? 'selected' : '' }}>
                                                {{ $paymentTerm->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid payment terms.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Fabric Construction</label>
                                    <select name="fabric_construction_id" class="form-control select2">
                                        <option>Select</option>
                                        @foreach ($fabricConstructions as $fabricConstruction)
                                            <option value="{{ $fabricConstruction->id }}"
                                                {{ $order->fabric_construction_id == $fabricConstruction->id ? 'selected' : '' }}>
                                                {{ $fabricConstruction->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid fabric cosntruction.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_quantity" class="form-label">Total Order Quantity</label>
                                    <input type="text" class="form-control" id="order_quantity"
                                        placeholder="Total Order Quantity"
                                        value="{{ $order->order_quantity ? $order->order_quantity : old('order_quantity') }}"
                                        required name="order_quantity">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid order quantity.
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div data-repeater-list="group-a">
                            @php
                                $sumQty = 0;
                            @endphp
                            @foreach ($order->order_items as $key => $order_item)
                                <div data-repeater-item class="row data-repeater-item">
                                    <div class="mb-3 col-lg-1">
                                        <label for="article_style_no-{{ $key }}">Article No</label>
                                        <input type="text" id="article_style_no-{{ $key }}"
                                            value="{{ $order_item->article_style_no ? $order_item->article_style_no : old('article_style_no') }}"
                                            name="article_style_no" class="form-control"
                                            placeholder="Enter Item Article No" />
                                        <input type="hidden" name="order_item_id" value="{{ $order_item->id }}">
                                    </div>

                                    <div class="mb-3 col-lg-2">
                                        <label for="article_style_id-{{ $key }}">Title / Product Type</label>
                                        <select name="article_style_id" id="article_style_id-{{ $key }}"
                                            class="form-control select2">
                                            <option>Select</option>
                                            @foreach ($articleStyles as $articleStyle)
                                                <option value="{{ $articleStyle->id }}"
                                                    {{ $order_item->article_style_id == $articleStyle->id ? 'selected' : '' }}>
                                                    {{ $articleStyle->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-lg-2">
                                        <label for="description-{{ $key }}">Description</label>
                                        <input type="text" id="description-{{ $key }}" name="description"
                                            value="{{ $order_item->description }}" class="form-control"
                                            placeholder="Description" />
                                    </div>

                                    <div class="mb-3 col-lg-1">
                                        <label for="range_id-{{ $key }}" class="form-label">Range</label>
                                        <select name="range_id" class="form-control select2">
                                            <option>Select</option>
                                            @foreach ($ranges as $range)
                                                <option value="{{ $range->id }}"
                                                    {{ $order_item->range_id == $range->id ? 'selected' : '' }}>
                                                    {{ $range->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-lg-1">
                                        <label for="size-{{ $key }}">Size</label>
                                        <select name="size" id="size-{{ $key }}"
                                            class="form-control select2 select2-multiple" multiple>
                                            @foreach (App\Constants\DefaultValues::SIZES as $size)
                                                <option value="{{ $size }}"
                                                    {{ in_array($size, json_decode($order_item->sizes)) ? 'selected' : '' }}>
                                                    {{ $size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-lg-1">
                                        <label for="color">GSM</label>
                                        <input type="text" id="gsm" name="gsm" required
                                            value="{{ $order_item->gsm }}" class="form-control" placeholder="GSM" />
                                    </div>
                                    <div class="mb-3 col-lg-1">
                                        <label for="color-{{ $key }}">Color</label>
                                        <input type="text" id="color-{{ $key }}" name="color"
                                            value="{{ $order_item->color }}" class="form-control colorpicker-showalpha"
                                            placeholder="Color" />
                                    </div>
                                    <div class="mb-3 col-lg-1">
                                        <label for="qty-{{ $key }}">Qty</label>
                                        <input type="number" id="qty-{{ $key }}"
                                            value="{{ $order_item->qty }}" onchange="calculateQnty(this)"
                                            onkeyup="calculateQnty(this)" name="qty" class="form-control"
                                            placeholder="Qty" />
                                    </div>
                                    <div class="mb-3 col-lg-1">
                                        <label for="unit-{{ $key }}">Unit</label>
                                        <input type="text" id="unit-{{ $key }}"
                                            value="{{ $order_item->unit }}" name="unit" class="form-control"
                                            placeholder="Unit" />
                                    </div>

                                    <div class="col-lg-1 align-self-center">
                                        <div class="d-grid">
                                            <span data-repeater-delete type="button"><i
                                                    class="bx bx-trash-alt font-size-20 text-danger verti-timeline"></i></span>

                                        </div>
                                    </div>
                                </div>
                                @php
                                    $sumQty += $order_item->qty;
                                @endphp
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0 add-row"
                                    value="Add" />
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-editable table-nowrap align-middle table-edits">
                                            <tbody>
                                                <tr>
                                                    <td>Total Order Qty :</td>
                                                    <td id="total_qty">{{ $sumQty }}</td>
                                                    <td style="width: 50px">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
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

    <script src="{{ URL::asset('build/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/order-form-repeaterr.int.js') }}"></script>
    <script src="{{ URL::asset('build/libs/table-edits/build/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/table-editable.int.js') }}"></script>
    <script>
        function calculateQnty(input) {
            var total = 0;
            var definedQty = parseInt($('#order_quantity').val());

            $('[data-repeater-item]').each(function() {
                var qty = parseFloat($(this).find('[name^="group-a"][name$="[qty]"]').val()) || 0;
                total += qty;
            });

            $('#total_qty').text(total);

        }
        $(".select2").each(function() {
            $(this).select2({
                placeholder: "Select"
            });
        });
    </script>
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
