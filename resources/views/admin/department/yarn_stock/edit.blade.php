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
            @lang('translation.YarnStock')
        @endslot
    @endcomponent

    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST" id="yarnPurchaseOrder-form"
        action="{{ route('admin.departments.yarn_stock.update', ['slug' => $department->slug, 'yarn_stock' => $yarnStock->id]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="form_id" value="yarnPurchaseOrder-form">
        <input type="hidden" name="yarn_purchase_order_id" value="{{ $yarn_po->id }}">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="delivery-from-input" class="form-label">Received From</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select class="form-control select2" id="from-type-input"
                                                value="{{ old('delivery_from_type') }}" required name="delivery_from_type">
                                                <option value="">Select</option>
                                                <option value="company" {{ $yarnStock->delivery_from_type === 'company' ? 'selected' : '' }}>Company</option>
                                                <option value="departments" {{$yarnStock->delivery_from_type === 'departments' ? 'selected' : '' }}>Department</option>
                                                <option value="knitting" {{$yarnStock->delivery_from_type === 'knitting' ? 'selected' : '' }}>Knitting House</option>
                                                <option value="dyeing" {{$yarnStock->delivery_from_type === 'dyeing' ? 'selected' : '' }}>Dyeing House</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid received from type.</div>
                                        </div>
                                        <div class="col-lg-8" id="delivery-from-div">
                                            <select class="form-control select2" id="delivery-from-input"
                                                value="{{ old('delivery_from_id') }}" required name="delivery_from_id">
                                                <option value="">Select</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid received from option.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="deliver-to-input" class="form-label">Deliver To</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select class="form-control select2" id="to-type-input"
                                                value="{{ old('delivery_to_type') }}" required name="delivery_to_type">
                                                <option value="">Select</option>
                                                <option value="departments" {{ $yarnStock->delivery_to_type === 'departments' ? 'selected' : '' }}>Department</option>
                                                <option value="knitting" {{ $yarnStock->delivery_to_type === 'knitting' ? 'selected' : '' }}>Knitting House</option>
                                                <option value="dyeing" {{ $yarnStock->delivery_to_type === 'dyeing' ? 'selected' : '' }}>Dyeing House</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid deliver to type.</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-control select2" id="delivery-to-input"
                                                value="{{ old('delivery_to_id') }}" required name="delivery_to_id">
                                                <option value="">Select</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid deliver to option.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="total_qty" class="form-label">Total Qty</label>
                                    <input type="number" class="form-control"
                                        id="total_qty" placeholder="Enter Qty"  max="{{$yarn_po->kgs}}" step="0.01" value="{{ $yarnStock->total_qty ?:  old('total_qty') }}" required
                                        name="total_qty">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid total qty.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="received_qty" class="form-label">Received Qty</label>
                                    <input type="number" class="form-control" id="received_qty" placeholder="Enter Received Qty In Kgs"
                                        value="{{ $yarnStock->received_qty ?: old('received_qty') }}" step="0.01" max="{{ $yarn_po->kgs }}" required name="received_qty">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid received qty.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 border-end">
                                <div class="mb-3 ">
                                    <label for="remaining_qty" class="form-label">Remaining Qty</label>
                                        <input type="number" class="form-control" id="remaining_qty" readonly
                                            placeholder="Enter Remaining Qty In Kgs" step="0.01" value="{{ $yarnStock->remaining_qty ?: old('remaining_qty') }}" required
                                            name="remaining_qty">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid remaining qty.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="status-input" class="form-label">Status</label>
                                    <select class="form-control select2" id="status-input" value="{{ old('status') }}"
                                        required name="status">
                                        <option value="">Select</option>
                                        <option value="Received" {{ $yarnStock->status == 'Received' ? 'selected' : '' }}>Received</option>
                                        <option value="Pending" {{ $yarnStock->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Delivered" {{ $yarnStock->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="Not Delivered" {{ $yarnStock->status == 'Not Delivered' ? 'selected' : '' }}>Not Delivered</option>
                                        <option value="Not Received" {{ $yarnStock->status == 'Not Received' ? 'selected' : '' }}>Not Received</option>
                                        <option value="Missing" {{ $yarnStock->status == 'Missing' ? 'selected' : '' }}>Missing</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid status.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="type-input" class="form-label">Type</label>
                                    <select class="form-control select2" id="type-input" value="{{ old('type') }}"
                                        required name="type">
                                        <option value="">Select</option>
                                        <option value="Normal" {{ $yarnStock->type === 'Normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="Shortfall" {{ $yarnStock->type === 'Shortfall' ? 'selected' : '' }}>Shortfall</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a valid type.</div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea type="number" placeholder="Enter remarks" name="remarks" class="form-control" id="remarks">{{ $yarnStock->remarks ?: old('remarks') }}</textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid remarks.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('#received_qty').on('keyup focusout', function(event) {
            var receivedQty = parseFloat($(this).val()) || 0; // Convert to float and handle empty input
            var totalQty = parseFloat($('#total_qty').val()) || 0; // Convert to float and handle empty input
            var maxQty = parseFloat($(this).attr('max')) || totalQty; // Get max attribute value or default to totalQty

            // Check if receivedQty exceeds max and adjust if necessary
            if (receivedQty > maxQty) {
                receivedQty = maxQty;
                $(this).val(receivedQty.toFixed(2)); // Set to max value
            }

            $('#remaining_qty').val((totalQty - receivedQty).toFixed(2));
        });
        $(document).ready(function () {
            $("#from-type-input").trigger('change');
            $("#to-type-input").trigger('change');
        });

        $('#from-type-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            $.ajax({
                url: "/admin/fetch-data-by-type",
                type: 'GET',
                dataType: 'json',
                data: {
                    "type": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#delivery-from-input').html(
                        '<option value="">Select delivery from</option>');
                    if (selected == "departments") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-from-input").append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });
                    } else if (selected == "knitting") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-from-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    } else if (selected == "dyeing") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-from-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    }
                    if(selected == 'company') {
                        $('#delivery-from-div').hide();
                        $('#delivery-from-input').removeAttr('required');
                    } else {
                        var selectedValues = {!! json_encode(explode(',', $yarnStock->delivery_from_id)) !!};
                        $('#delivery-to-input').val(selectedValues).trigger('change');
                        $('#delivery-from-div').show();
                    }

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        $('#to-type-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            $.ajax({
                url: "/admin/fetch-data-by-type",
                type: 'GET',
                dataType: 'json',
                data: {
                    "type": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#delivery-to-input').html(
                        '<option value="">Select delivery to</option>');
                    if (selected == "departments") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-to-input").append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });
                    } else if (selected == "knitting") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-to-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    } else if (selected == "dyeing") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-to-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    }
                    
                    var selectedValues = {!! json_encode(explode(',', $yarnStock->delivery_to_id)) !!};
                    $('#delivery-to-input').val(selectedValues).trigger('change');

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
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
