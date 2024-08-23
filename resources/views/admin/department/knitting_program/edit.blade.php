@extends('layouts.departments.master')

@section('title')
    @lang('translation.KnittingProgram')
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
            New @lang('translation.KnittingProgram')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="repeater needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="{{ route('admin.departments.knitting_program.update', ['slug' => $department->slug, 'knitting_program' => $knittingProgram->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="job_id" class="form-label">Job No</label>
                                    <select name="job_id" id="job-id-input" class="form-control select2" required>
                                        <option>Select</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}" {{$knittingProgram->job_id === $job->id ? 'selected' : ''}}>{{ $job->number }}</option>
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

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="moobile_no" class="form-label">Orders</label>
                                    <select name="order_id" id="order-id-input" class="form-control select2" required>
                                        <option>Select order</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid order
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="moobile_no" class="form-label">Customer</label>
                                    <input type="text" value="" placeholder="Customer" readonly id="customer-input" class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid customer name
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="article_id" class="form-label">Article/Styles</label>
                                    <select name="article_id[]" id="article-id-input" multiple class="form-control select2 select2-multiple" required>
                                        <option>Select article</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid article no.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="article_id" class="form-label">Description</label>
                                    <input type="text" name="description" value="{{ $knittingProgram->description ? $knittingProgram->description : old('   ') }}" placeholder="description" class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid description.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="fabric_content" class="form-label">Fabric Content</label>
                                    <input type="text" id="fabric_content" value="{{ $knittingProgram->fabric_content ? $knittingProgram->fabric_content : old('fabric_content') }}" placeholder="Fabric Content" name="fabric_content" class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid description.
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="orders-row">
                            <div id="repeater-container"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="article_id" class="form-label">Required Finished Gsm</label>
                                    <input type="text" id="required-finished-gsm" value="{{ $knittingProgram->required_finished_gsm ? $knittingProgram->required_finished_gsm :  old('required_finished_gsm') }}" placeholder="Required Finished Gsm" name="required_finished_gsm" class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid required finished gsm.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="article_id" class="form-label">Required Finished Width</label>
                                    <input type="text" id="required-finished-width" value="{{ $knittingProgram->required_finished_width ? $knittingProgram->required_finished_width : old('required_finished_width') }}" placeholder="Required Finished Width" name="required_finished_width" class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid required finished width.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="article_id" class="form-label">Required Raising Quality</label>
                                    <input type="text" id="required-finished-quality" value="{{ $knittingProgram->required_finished_quality ? $knittingProgram->required_finished_quality : old('required_finished_quality') }}" placeholder="Required Raising Quality" name="required_finished_quality" class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid required finished quality.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="article_id" class="form-label">Shade Matching Light</label>
                                    <input type="text" name="shade_matching_light" value="{{ $knittingProgram->shade_matching_light ? $knittingProgram->shade_matching_light : old('shade_matching_light') }}" placeholder="Shade Matching Light" id="shade-matching-light" class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid shade matching light.
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
    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function () {
            $('#job-id-input').trigger('change');

        });
      
        $('#job-id-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            $.ajax({
                url: "/admin/fetch-orders-by-job-id",
                type: 'GET',
                dataType: 'json',
                data: {
                    "job_id": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#order-id-input').html(
                        '<option value="">Select order</option>');
                    $.each(data.result, function(key, value) {
                        var selectedValue = (value.id == {{$knittingProgram->order_id}}) ? 'selected' : '';
                        $('#order-id-input').append('<option value="' +
                            value.id + '" '+selectedValue+'>' + value.code + ' ('+value.customer_po_number+')</option>');
                    });
                    $('#order-id-input').trigger('change');

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        $('#order-id-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            $.ajax({
                url: "/admin/fetch-order-details-by-id",
                type: 'GET',
                dataType: 'json',
                data: {
                    "order_id": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#customer-input').val(data.result.client.name);
                    var selectedValues = {!! json_encode(explode(',', $knittingProgram->article_id)) !!};

                    $('#article-id-input').html(
                        '<option value="">Select article</option>');
                    $.each(data.result.order_items, function(key, value) {
                        
                        $('#article-id-input').append('<option value="' + value.article_style_no + '" >' + 
                            value.article_style_no + '</option>');
                    });
                    $('#article-id-input').val(selectedValues).trigger('change');

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        $('#article-id-input').on('change', function(event) {
            event.preventDefault();
            var articleIDs = $(this).val();
            var order_id = $('#order-id-input').val();
            console.log(articleIDs);
            $.ajax({
                url: "/admin/fetch-order-items-by-article-id",
                type: 'GET',
                dataType: 'json',
                data: {
                    "article_ids": articleIDs,
                    "order_id": order_id
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#repeater-container').html('');
                    var mainTableHtml = `<table class="table main_table">
                                <thead>
                                    <tr>
                                    <th>Body Fabric</th>
                                    <th>Color</th>
                                    <th>Body Fabric Dozen</th>
                                    <th>Fabric Detail Kgs</th>
                                    <th>Total In Kgs</th>
                                    <th>Order Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    `;
                                    $.each(data.result, function(key, value) {

                                        var knittingProgramItems = {!! json_encode($knittingProgram->items) !!};
                                        var bodyFabricValue = '';
                                        if (knittingProgramItems[key]) {
                                            bodyFabricValue = knittingProgramItems[key].body_fabric || '';
                                        }
                                        
                                        mainTableHtml += `
                                            <tr>
                                                <td width="10%"><input type="number" value="${bodyFabricValue}" step="0.01" id="body_fabric_`+key+`" onkeyup="calculateFabricDetail(this, `+key+`)" placeholder="Body Fabric" name="body_fabric[]" class="form-control"></td>
                                                <td> 
                                                    <div class="rounded overflow-hidden">
                                                        <div class="p-1" style="background-color: `+value.color+`">
                                                            <h5 class="my-1 text-white font-size-12 text-center">
                                                                `+value.color+`</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><input type="hidden" id="body_fabric`+key+`" name="body_fabric_dozen[]" value="`+(value.total_quantity/12).toFixed(2)+`">
                                                    `+(value.total_quantity/12).toFixed(2)+` DOZ</td>
                                                <td><input type="hidden" id="fabric_detail`+key+`" name="fabric_detail_kgs[]"> 
                                                    <span id="fabric_detail_value`+key+`"></span>
                                                    </td>
                                                <td><input type="hidden" id="total_in_kgs`+key+`" name"total_in_kgs[]">
                                                    <span id="total_in_kgs_value`+key+`"></span> 
                                                    </td>
                                                <td><input type="hidden" id="qty_`+key+`" value="`+value.total_quantity+`" name="order_qty[]">
                                                    `+value.total_quantity+` Pcs
                                                    </td>
                                                </tr>
                                           `;
                                    });
                                    mainTableHtml += ` </tbody>
                                    <tfoot>
                                        <tr>\
                                            <th colspan=2>Total</th>\
                                            <th id="sum_dozen">0</th>\
                                            <th id="sum_fabic_kgs">0</th>\
                                            <th id="sum_total_kgs">0</th>\
                                            <th id="sum_qty">0</th>\
                                        </tr>\
                                    </tfoot>
                                        </table>`;
                    $('#repeater-container').append(mainTableHtml);

                    $('input[name="body_fabric[]"]').trigger('keyup');

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        function calculateFabricDetail(elem, index)
        {
            value = $(elem).val();
            result = value * $('#body_fabric'+index).val();
            let tr = $(elem).closest('tr');

            $('#fabric_detail_value'+index).text(result.toFixed(2)); 
            $('#fabric_detail'+index).val(result.toFixed(2));

            $('#total_in_kgs_value'+index).text(result.toFixed(2));
            $('#total_in_kgs'+index).val(result.toFixed(2));

            updateSum();
        }

        function updateSum() {

            let totalDozen = 0;
            let orderQty = 0;
            let totalKgs = 0;
            let fabricKgs = 0;
            $('.main_table tr').each(function() {
                const bodyFabricDozen = $(this).find('input[name="body_fabric_dozen[]"]').val();
                const Qty = $(this).find('input[name="order_qty[]"]').val();
                const FabricDetailKgs = $(this).find('input[name="fabric_detail_kgs[]"]').val();
                const TotalInKgs = $(this).find('input[name="total_in_kgs[]"]').val();
                if (bodyFabricDozen) {
                    totalDozen += parseFloat(bodyFabricDozen);
                }
                if (Qty) {
                    orderQty += parseFloat(Qty);
                }

                if (TotalInKgs) {
                    totalKgs += parseFloat(TotalInKgs);
                }

                if (FabricDetailKgs) {
                    fabricKgs += parseFloat(FabricDetailKgs);
                }
            });

            $('#sum_dozen').text(totalDozen.toFixed(2)+ " Doz");
            $('#sum_qty').text(orderQty + " Pcs");
            $('#sum_total_kgs').text(fabricKgs+" Kgs");
            $('#sum_fabic_kgs').text(fabricKgs+ " Kgs");
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
