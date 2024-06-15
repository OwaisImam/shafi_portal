/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: contact user list Js File
*/


var url = "/";
var orderListData = '';
var editList = false;
var csrfToken = $('meta[name="csrf-token"]').attr('content');
var department = $('meta[name="department"]').attr('content');


//contact user list by json
var getJSON = function (jsonurl, callback) {

    $.ajax({
        url: url + jsonurl,
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (data, status, xhr) {
            callback(null, data);
        },
        error: function (xhr, status, error) {
            callback(xhr.status, xhr.responseJSON);
        }
    });
};

// get json
getJSON("admin/department/" + department + "/orders", function (err, data) {
    if (err !== null) {
        console.log("Something went wrong: " + err);
    } else {
        orderListData = data.result;
        loadUserList(orderListData)
    }
});

// load table list data
function loadUserList(datas) {
    $('#userList-table').DataTable({
        data: datas.data,
        "bLengthChange": false,
        order: [[1, 'asc']],
        language: {
            oPaginate: {
                sNext: '<i class="mdi mdi-chevron-right"></i>',
                sPrevious: '<i class="mdi mdi-chevron-left"></i>',
            }
        },
        columns: [
            {
                data: "id",
                render: function (data, type, full, meta) {
                    // Use meta.row + 1 to get the row number (adding 1 to make it 1-based)
                    return meta.row + 1;
                }
            },
            {
                data: "code",
            },
            {
                data: "customer_id",
                render: function (data, type, full) {
                    return full.client.name;
                }
            },
            {
                data: "po_receive_date",
            },
            {
                data: "delivery_date",
            },
            {
                data: "order_quantity"
            },
            {
                data: "status",
                render: function (data, type, full) {
                    if (full.status != "Pending") {
                        return '<a href="javascript: void (0);" class="badge badge-soft-success font-size-11 m-1">' + full.status + '</a>';
                    } else {
                        return '<a href="javascript: void (0);" class="badge badge-soft-danger font-size-11 m-1">' + full.status + '</a>';
                    }
                }
            },
            {
                data: null,
                'bSortable': false,
                render: function (data, type, full) {
                    var hasEditPermission = datas.permissions.some(permission => permission.name === 'orders-edit');
                    var hasDeletePermission = datas.permissions.some(permission => permission.name === 'orders-delete');
                    var hasViewPermission = datas.permissions.some(permission => permission.name === 'orders-view');
                    var hasUpdateOrderStatus = datas.permissions.some(permission => permission.name === 'orders-update-status');
                    var hasPreProdoctionPlanCreatePermission = datas.permissions.some(permission => permission.name === 'orders-delete');
                    if (hasDeletePermission || hasEditPermission || hasViewPermission || hasUpdateOrderStatus) {

                        var actions = '<ul class="list-inline font-size-20 contact-links mb-0">\
                        <li class="list-inline-item">\
                        <div class="dropdown">\
                        <a href="javascript: void(0);" class="dropdown-toggle card-drop px-2" data-bs-toggle="dropdown" aria-expanded="false">\
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>\
                        </a>\
                        <ul class="dropdown-menu dropdown-menu-end">';

                        if (hasEditPermission) {
                            actions += '<li><a href="./orders/' + full.id + '/edit" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>';
                        }

                        if (hasDeletePermission) {
                            actions += '<li><a href="#removeOrderModal" data-bs-toggle="modal" class="dropdown-item remove-list" data-remove-id="' + full.id + '"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>';
                        }

                        if (hasDeletePermission) {
                            actions += '<li><a href="./orders/' + full.id + '" class="dropdown-item remove-list" data-view-id="' + full.id + '"><i class="mdi mdi-eye font-size-16 text-primary me-1"></i> View</a></li>';
                        }

                        if (hasPreProdoctionPlanCreatePermission) {
                            actions += '<li><a href="./pre_production_plans/create?order_id=' + full.id + '" class="dropdown-item remove-list"><i class="mdi mdi-trash-can font-size-16 text-warning me-1"></i> Pre Production Plan</a></li>';
                        }

                        if (hasUpdateOrderStatus) {
                            actions += '<li><a href="#updateOrderStatusModal" data-order-id="' + full.id + '" data-bs-toggle="modal" class="dropdown-item update-order-status"><i class="bx bxs-ship font-size-16 text-pink me-1"></i> Update Status</a></li>';
                        }

                        actions += '</ul>\
                    </div>\
                        </li>\
                    </ul>';
                    } else {
                        actions = "";
                    }

                    return actions;
                },
            },
        ],
        drawCallback: function (oSettings) {
            removeOrder();
            updateOrderStatus();
        },
    });

    $('#searchTableList').keyup(function () {
        $('#userList-table').DataTable().search($(this).val()).draw();
    });
    $(".dataTables_length select").addClass('form-select form-select-sm');
    $('.dataTables_paginate').addClass('pagination-rounded');
    $(".dataTables_filter").hide();
}


function fetchIdFromObj(member) {
    return parseInt(member.id);
}

function findNextId() {
    if (orderListData.data.length === 0) {
        return 0;
    }
    var lastElementId = fetchIdFromObj(orderListData.data[orderListData.data.length - 1]),
        firstElementId = fetchIdFromObj(orderListData.data[0]);
    return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
}

function generateSlug() {
    // Get the value from the title field
    const title = document.getElementById('name-input').value;

    // Generate a slug from the title
    const slug = title.toLowerCase().replace(/\s+/g, '-');

    // Set the slug value in the slug field
    document.getElementById('slug-input').value = slug;
}

function updateOrderStatus() {
    var getOrderid = 0;
    Array.from(document.querySelectorAll(".update-order-status")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getOrderid = elem.getAttribute('data-order-id');
            editList = true;
            $('#items-input').empty();
            document.getElementById("updateOrder-form").classList.remove("was-validated");
            orderListData.data = orderListData.data.map(function (order) {
                if (order.id == getOrderid) {
                    $.ajax({
                        url: url + "admin/department/" + department + "/orders/" + getOrderid + "/details",
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (data, status, xhr) {
                            $.each(data.result.order_items, function (key, value) {
                                $("#items-input").append('<option selected value="' +
                                    value.id + ' ">' + value.article_style_no + '</option>');
                            });

                            $('#items-input').select2();
                        },
                        error: function (xhr, status, error) {
                            // callback(xhr.status, xhr.responseJSON);
                        }
                    });

                    var form = document.getElementById('updateOrder-form');
                    var currentAction = form.action;

                    // Append the value to the current action
                    var newAction = currentAction + '/' + order.id; // Replace 'your-value' with the value you want to append

                    // Update the form action with the new value
                    form.action = newAction;

                    // Create a hidden input element for the _method field
                    var methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';

                    // Append the _method field to the form
                    form.appendChild(methodField);
                }
                return order;
            });
        });
    });
}


// remove order
function removeOrder() {
    var getid = 0;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (order) {
        order.addEventListener('click', function (event) {
            getid = order.getAttribute('data-remove-id');
            document.getElementById("remove-order").addEventListener("click", function () {
                function arrayRemove(arr, value) {
                    return arr.filter(function (ele) {
                        return ele.id != value;
                    });
                }
                var filtered = arrayRemove(orderListData.data, getid);

                orderListData.data = filtered;

                $.ajax({
                    url: "./orders/" + getid + "/delete",
                    type: "GET",
                    dataType: 'json',
                    success: function (resonse) {
                        toastr["success"](resonse.message);
                    }
                });

                if ($.fn.DataTable.isDataTable('#userList-table')) {
                    $('#userList-table').DataTable().destroy();
                }
                loadUserList(orderListData);
                $("#removeOrderModal").modal("hide");
            });
        });
    });
}
