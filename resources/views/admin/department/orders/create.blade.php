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
            New @lang('translation.Orders') Form
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="repeater needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="{{ route('admin.departments.orders.store', ['slug' => $department->slug]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="supplier" class="form-label">Customer's PO Number</label>
                                    <input type="text" name="customer_po_number" required
                                        value="{{ old('customer_po_number') }}" class="form-control">
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
                                            <option value="{{ $job->id }}">{{ $job->number }}</option>
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
                                    <select class="form-control select2" name="customer_id" required>
                                        <option>Select</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
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
                                        placeholder="PO Receive Date" value="{{ old('po_receive_date') }}" required
                                        name="po_receive_date">
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
                                        value="{{ old('delivery_date') }}" required name="delivery_date">
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
                                    <select name="payment_term_id" class="form-control select2" required>
                                        <option value="0">Select</option>
                                        @foreach ($paymentTerms as $paymentTerm)
                                            <option value="{{ $paymentTerm->id }}">{{ $paymentTerm->name }}</option>
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
                                    <select name="fabric_construction_id" required class="form-control select2">
                                        <option>Select</option>
                                        @foreach ($fabricConstructions as $fabricConstruction)
                                            <option value="{{ $fabricConstruction->id }}">{{ $fabricConstruction->name }}
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
                                        placeholder="Total Order Quantity" value="{{ old('order_quantity') ?: 0 }}"
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
                            <div data-repeater-item class="row data-repeater-item">
                                <div class="mb-3 col-lg-1">
                                    <label for="article_style_no">Article No</label>
                                    <input type="text" id="article_style_no" required name="article_style_no"
                                        class="form-control" placeholder="Enter Item Article No" />
                                </div>

                                <div class="mb-3 col-lg-2">
                                    <label for="uom">Title / Product Type</label>
                                    <select name="article_style_id" required id="article_style_id"
                                        class="form-control select2">
                                        <option value="0">Select</option>
                                        @foreach ($articleStyles as $articleStyle)
                                            <option value="{{ $articleStyle->id }}">{{ $articleStyle->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-2">
                                    <label for="description">Description</label>
                                    <input type="text" id="description" required name="description"
                                        class="form-control" placeholder="Description" />
                                </div>

                                <div class="mb-3 col-lg-1">
                                    <label for="credit_days" class="form-label">Range</label>
                                    <select name="range_id" id="range_id" class="form-control select2" required>
                                        <option>Select</option>
                                        @foreach ($ranges as $range)
                                            <option value="{{ $range->id }}">{{ $range->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-1">
                                    <label for="size">Size</label>
                                    <select name="size" id="size" required
                                        class="form-control select2 select2-multiple" multiple>
                                        @foreach (App\Constants\DefaultValues::SIZES as $size)
                                            <option value="{{ $size }}">{{ $size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-1">
                                    <label for="color">GSM</label>
                                    <input type="text" id="gsm" name="gsm" required class="form-control"
                                        placeholder="GSM" />
                                </div>

                                <div class="mb-3 col-lg-1">
                                    <label for="color">Color</label>
                                    <input type="text" id="color" name="color" required value="#556ee6"
                                        class="form-control colorpicker-showalpha" placeholder="Color" />

                                </div>
                                <div class="mb-3 col-lg-1">
                                    <label for="qty">Qty</label>
                                    <input type="number" id="qty" onchange="calculateQnty(this)"
                                        onkeyup="calculateQnty(this)" required name="qty" class="form-control"
                                        placeholder="Qty" />
                                </div>
                                <div class="mb-3 col-lg-1">
                                    <label for="unit">Unit</label>
                                    <input type="text" id="unit" name="unit" class="form-control"
                                        placeholder="Unit" required />
                                </div>

                                <div class="col-lg-1 align-self-center">
                                    <div class="d-grid">
                                        <span data-repeater-delete type="button"><i
                                                class="bx bx-trash-alt font-size-20 text-danger verti-timeline"></i></span>

                                    </div>
                                </div>
                            </div>
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
                                                    <td id="total_qty">0.00</td>
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
                            <button class="btn btn-primary" type="submit">Ceeate</button>
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
