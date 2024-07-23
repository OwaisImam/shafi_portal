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
            New @lang('translation.KnittingProgram')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="repeater needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="{{ route('admin.departments.yarn_program.store', ['slug' => $department->slug]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="job_id" class="form-label">Job No</label>
                                    <select name="job_id" id="job-id-input" class="form-control select2" required>
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="moobile_no" class="form-label">Name</label>
                                    <input type="text" name="name" placeholder="Enter name" class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid name
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="orders-row">
                            <div id="repeater-container"></div>
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

        function calculateQnty(input) {
            var total = 0;
            var definedQty = parseInt($('#order_quantity').val());

            $('[data-repeater-item]').each(function() {
                var qty = parseFloat($(this).find('[name^="group-a"][name$="[qty]"]').val()) || 0;
                total += qty;
            });

            $('#total_qty').text(total);

        }

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
                    $('#repeater-container').html('');
                    var TotalQty = 0;
                    var mainTableHtml = `<table class="table main_table">
                                <thead>
                                    <tr>
                                        <th>Fabric Content</th>
                                        <th>Body Fabric</th>
                                        <th>Color</th>
                                        <th>Order Qty</th>
                                        <th>Body Fabric Dozen</th>
                                        <th>Fabric Detail Kgs</th>
                                        <th>Total In Kgs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>` + data.result[0].job.number + `</td>
                                        <td><input type="number" name="" class="form-control" placeholder="Enter body fabric"></td>
                                        <td><div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter color" readonly value="`+data.result[0].+`" required="" name="amount">
                                        <span class="input-group-text" style="background-color: #000;"></span>
                                    </div></td>
                                    </tr>
                                </tbody>
                            </table>`;

                    $('#repeater-container').append(mainTableHtml);
                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        function indexToAlphabet(index) {
            // The ASCII code for 'a' is 97
            return String.fromCharCode(97 + index);
        }

        function getData(elem, index1) {
            var selected = $(elem).val();
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
                    $('#title-' + index1).html(
                        '<option value="">Select title</option>');
                    $.each(data.result, function(key, value) {
                        $('#title-' + index1).append('<option value="' +
                            value.id + '">' + value.name + '</option>');
                    });

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        }

        function calculateKgs(elem, index) {
            var percentage = $(elem).val();

            if (percentage > 100) {
                toastr['error']('Percentage limit exceded.');
                $(elem).val(100);
            }

            var total = $('#required_kgs_' + index + '').val();

            if (total == 0) {
                toastr['error']('Pkease define the required qty first.');
            }

            var calculatedKgs = total * (percentage / 100);

            $(elem).closest('[data-repeater-item]').find('[name$="[kgs]"]').val(calculatedKgs.toFixed(2));

            var calculatedBags = calculatedKgs / 45.36;
            $(elem).closest('[data-repeater-item]').find('[name$="[bags]"]').val(calculatedBags.toFixed(2));

            var totalKgs = 0;
            var totalBags = 0;

            $('[data-repeater-item]').each(function() {
                var kgs = parseFloat($(this).find('[name$="[kgs]"]').val()) || 0;
                totalKgs += kgs;

                var bags = parseFloat($(this).find('[name$="[bags]"]').val()) || 0;
                totalBags += bags;
            });
            $('#sum_kgs').text(totalKgs.toFixed(2) + " Kgs");
            $('#sum_bags').text(totalBags.toFixed(2) + " Bags");
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
