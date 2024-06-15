@extends('layouts.departments.master')

@section('title')
    @lang('translation.Orders')
@endsection

@section('css')
    <!-- select2 css -->
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/toastr/build/toastr.min.css') }}">

    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/toastr/build/toastr.min.css') }}">

    <meta name="department" content="{{ $department->slug }}">
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box me-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="searchTableList" placeholder="Search...">
                                    <i class="bx bx-search-alt search-icon"></i>
                                </div>
                            </div>
                        </div>
                        @can('orders-create')
                            <div class="col-sm-8">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.departments.orders.create', ['slug' => $department->slug]) }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addOrder-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Order</a>
                                </div>
                            </div>
                        @endcan
                    </div>
                    <!-- end row -->
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100"
                            id="userList-table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 40px;">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">PO Receive Date</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Order Quantity</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- end table -->
                    </div>
                    <!-- end table responsive -->
                </div>
            </div>
        </div>
    </div>

    <!-- removeOrderModal -->
    <div class="modal fade" id="removeOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body px-4 py-5 text-center">
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <div class="avatar-sm mb-4 mx-auto">
                        <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </div>
                    </div>
                    <p class="text-muted font-size-16 mb-4">Are you Sure You want to Remove this Record ?</p>

                    <div class="hstack gap-2 justify-content-center mb-0">
                        <button type="button" class="btn btn-danger" id="remove-order">Remove Now</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateOrderStatusModal" tabindex="-1" aria-labelledby="updateOrderStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateOrderStatusModalLabel">Add Cartage Slip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" method="POST" class="needs-validation updateOrder-form"
                        enctype="multipart/form-data" id="updateOrder-form"
                        action="{{ route('admin.departments.range.store', ['slug' => $department->slug]) }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" class="form-control" id="rangeId-input">
                                <div class="mb-3">
                                    <label for="slip-input" class="form-label">Slip No</label>
                                    <input type="text" name="slip_no" id="slip-input" class="form-control"
                                        placeholder="Enter slip no" required />
                                    <div class="invalid-feedback">Please enter a slip no.</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="items-input" class="form-label">Item</label>
                                    <select class="select2 form-control select2-multiple" name="items[]" id="items-input"
                                        data-placeholder="Choose ..." required multiple="multiple">
                                        <option>Select</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a valid item.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="delivery-from-input" class="form-label">Delivery From</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select class="form-control select2" id="from-type-input"
                                                value="{{ old('from_type') }}" required name="from_type">
                                                <option value="">Select</option>
                                                <option value="department">Department</option>
                                                <option value="knitting">Knitting House</option>
                                                <option value="dyeing">Dyeing House</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid deliver from type.</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="delivery-from-input"
                                                value="{{ old('delivery_from') }}" required name="delivery_from">
                                                <option value="">Select</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid delivery from option.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="deliver-to-input" class="form-label">Delivery To</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select class="form-control select2" id="to-type-input"
                                                value="{{ old('to_type') }}" required name="to_type">
                                                <option value="">Select</option>
                                                <option value="department">Department</option>
                                                <option value="knitting">Knitting House</option>
                                                <option value="dyeing">Dyeing House</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid deliver to type.</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="delivery-to-input"
                                                value="{{ old('deliver_to') }}" required name="deliver_to">
                                                <option value="">Select</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid delivery to option.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="driver-name-input" class="form-label">Driver Name</label>
                                    <input type="text" name="driver_name" id="driver-name-input" class="form-control"
                                        placeholder="Enter driver name" required />
                                    <div class="invalid-feedback">Please enter a valid diver name.</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="driver-cell-no-input" class="form-label">Driver's Cell No</label>
                                    <input type="text" name="driver_cell_no" id="driver-cell-no-input"
                                        class="form-control" placeholder="Enter driver cell no" required />
                                    <div class="invalid-feedback">Please enter a valid driver cell no.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="vehicle-no-input" class="form-label">Vehicle No</label>
                                    <input type="text" name="vehicle_no" id="vehicle-no-input" class="form-control"
                                        placeholder="Enter vehicle no" required />
                                    <div class="invalid-feedback">Please enter a valid vehicle no.</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="vehicle-type-input" class="form-label">Vehicle Type</label>
                                    <input type="text" name="vehicle_type" id="vehicle-type-input"
                                        class="form-control" placeholder="Enter vehicle type" required />
                                    <div class="invalid-feedback">Please enter a slip no.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="amount-input" class="form-label">Amount</label>
                                    <input type="text" name="amount" id="amount-input" class="form-control"
                                        placeholder="Enter amount" required />
                                    <div class="invalid-feedback">Please enter a valid amount.</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="amount-in-words-input" class="form-label">Amount In Words</label>
                                    <input type="text" name="amount_in_words" id="amount-in-words-input"
                                        class="form-control" placeholder="Enter amount in words" required />
                                    <div class="invalid-feedback">Please enter a valid amount in words.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name-input" class="form-label">File</label>
                                    <div>
                                        <input type="file" required name="attachment" id="attachment"
                                            class="form-control" />
                                        <div class="invalid-feedback">Please enter a valid file.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name-input" class="form-label">Status</label>
                                    <div>
                                        <input type="checkbox" name="status" value="1" id="switch6"
                                            switch="primary" />
                                        <label for="switch6" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" id="addRange-btn" class="btn btn-success">Update Status</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end modal body -->
            </div>
            <!-- end modal-content -->
        </div>
        <!-- end modal-dialog -->
    </div>

    <!-- end removeOrderModal -->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/inputmask/inputmask.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/inputmask/jquery.inputmask.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-mask.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/orders/orders-list.init.js') }}"></script>

    <!-- toastr plugin -->
    <script src="{{ URL::asset('build/libs/toastr/build/toastr.min.js') }}"></script>
    <!-- toastr init -->
    <script src="{{ URL::asset('build/js/pages/toastr.init.js') }}"></script>

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
