@extends('layouts.departments.master')

@section('title')
    @lang('translation.Purchase_Order')
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
            Purchase Order
        @endslot
        @slot('title')
            Create Purchase Order
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="repeater needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="{{ route('admin.email_templates.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="supplier" class="form-label">Supplier</label>
                                    <select name="supplier" class="form-control select2">
                                        <option>Select</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the supplier.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="moobile_no" class="form-label">Mobile No</label>
                                    <input type="text" class="form-control" id="moobile_no" placeholder="Mobile No"
                                        value="{{ old('moobile_no') }}" required name="moobile_no">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid subject.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category" placeholder="Category"
                                        value="{{ old('category') }}" required name="category">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid category.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="serial_no" class="form-label">Job No</label>
                                    <input type="text" class="form-control" id="job_no" placeholder="Job No"
                                        value="{{ old('job_no') }}" required name="job_no">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the job no.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Credit Days</label>
                                    <input type="text" class="form-control" id="credit_days" placeholder="Credit Days"
                                        value="{{ old('credit_days') }}" required name="credit_days">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid credit days.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gst_no" class="form-label">GST No</label>
                                    <input type="text" class="form-control" id="gst_no" placeholder="GST No"
                                        value="{{ old('gst_no') }}" required name="gst_no">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid gst no.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="required_delivery_date" class="form-label">Required Delivery
                                        Date</label>
                                    <input type="text" class="form-control" id="required_delivery_date"
                                        placeholder="Required Delivery Date" value="{{ old('required_delivery_date') }}"
                                        required name="required_delivery_date">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the delivery date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ntn_no" class="form-label">NTN No</label>
                                    <input type="text" class="form-control" id="ntn_no" placeholder="NTN No"
                                        value="{{ old('ntn_no') }}" required name="ntn_no">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the full name.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="delivery_address" class="form-label">Delivery Address</label>
                                    <input type="text" class="form-control" id="delivery_address"
                                        placeholder="Delivery Address" value="{{ old('delivery_address') }}" required
                                        name="delivery_address">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the full name.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-repeater-list="group-a">
                            <div data-repeater-item class="row data-repeater-item">
                                <div class="mb-3 col-lg-3">
                                    <label for="item_description">Item Description</label>
                                    <input type="text" id="item_description" name="item_description"
                                        class="form-control" placeholder="Enter Item Description" />
                                </div>

                                <div class="mb-3 col-lg-1">
                                    <label for="uom">UOM</label>
                                    <input type="text" id="uom" name="uom" class="form-control"
                                        placeholder="UOM" />
                                </div>

                                <div class="mb-3 col-lg-1">
                                    <label for="color">Color</label>
                                    <input type="text" id="color" name="color" class="form-control"
                                        placeholder="Color" />
                                </div>

                                <div class="mb-3 col-lg-1">
                                    <label for="size">Size</label>
                                    <input type="text" class="form-control" placeholder="Size" id="size"
                                        name="size">
                                </div>

                                <div class="mb-3 col-lg-1">
                                    <label for="qty">Qnty</label>
                                    <input type="text" id="qty" name="qty" class="form-control"
                                        placeholder="Qnty" />
                                </div>
                                <div class="mb-3 col-lg-1">
                                    <label for="rate">Rate</label>
                                    <input type="text" id="rate" name="rate" class="form-control"
                                        placeholder="rate" />
                                </div>
                                <div class="mb-3 col-lg-2">
                                    <label for="amount">Amount</label>
                                    <input type="text" id="amount" name="amount" class="form-control"
                                        onfocus="calculateSubtotal(this)" placeholder="Amount" />
                                </div>

                                <div class="col-lg-2 align-self-center">
                                    <div class="d-grid">
                                        <input data-repeater-delete type="button" class="btn btn-primary"
                                            value="Delete" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0"
                                    value="Add" />
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-editable table-nowrap align-middle table-edits">
                                            <tbody>
                                                <tr>
                                                    <td>Sub Total :</td>
                                                    <td id="subtotal">$0.00</td>
                                                    <td style="width: 50px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Less Discount : </td>
                                                    <td data-field="discount" id="discount">-$0.00</td>
                                                    <td style="width: 50px">
                                                        <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Gross Value Excluding GST :</td>
                                                    <td id="excluding_gst">$0.00</td>
                                                    <td style="width: 50px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Add GST :</td>
                                                    <td id="add_gst">$0.00</td>
                                                    <td style="width: 50px">
                                                    </td>
                                                </tr>
                                                <tr class="bg-light">
                                                    <th>Total :</th>
                                                    <th id="total">$0.00</th>
                                                    <th style="width: 50px">
                                                    </th>
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
    <script src="{{ URL::asset('build/js/pages/form-repeater.int.js') }}"></script>
    <script src="{{ URL::asset('build/libs/table-edits/build/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/table-editable.int.js') }}"></script>
    <script>
        function calculateSubtotal(input) {
            var row = $(input).closest('[data-repeater-item]');
            var rate = parseFloat(row.find('[name^="group-a"][name$="[rate]"]').val()) || 0;
            var quantity = parseFloat(row.find('[name^="group-a"][name$="[qty]"]').val()) || 0;
            var subtotal = rate * quantity;
            var total = 0;

            row.find('[name^="group-a"][name$="[amount]"]').val(subtotal.toFixed(2));

            $('[data-repeater-item]').each(function() {
                var amount = parseFloat($(this).find('[name^="group-a"][name$="[amount]"]').val()) || 0;
                total += amount;
            });

            $('#subtotal').text("$" + total.toFixed(2));
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
