/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: contact user list Js File
*/


var url = "/";
var yarn_purchase_orderListData = '';
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
getJSON("admin/department/" + department + "/pre_production_plans", function (err, data) {
    if (err !== null) {
        console.log("Something went wrong: " + err);
    } else {
        yarn_purchase_orderListData = data.result;
        loadUserList(yarn_purchase_orderListData)
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
                data: "order.job.number",
            },
            {
                data: "order.code",
            },
            {
                data: "status",
                render: function (data, type, full) {
                    if (full.status == 1) {
                        return '<a href="javascript: void (0);" class="badge badge-soft-success font-size-11 m-1">Active</a>';
                    } else {
                        return '<a href="javascript: void (0);" class="badge badge-soft-danger font-size-11 m-1">Inactive</a>';
                    }
                }
            },
            {
                data: "processes",
                render: function (data, type, full) {
                    return full.processes.length;
                }
            },
            {
                data: "accessories",
                render: function (data, type, full) {
                    return full.accessories.length;
                }
            },
            {
                data: "yarn_purchase_orders",
                render: function (data, type, full) {
                    let totalKgs = 0;

                    if (Array.isArray(full.yarn_purchase_orders)) {
                        full.yarn_purchase_orders.forEach(item => {
                            totalKgs += item.kgs || 0; // Ensure kgs is a number and not undefined
                        });
                    }

                    return totalKgs;
                }
            },
            {
                data: null,
                'bSortable': false,
                render: function (data, type, full) {
                    var hasEditPermission = datas.permissions.some(permission => permission.name === 'pre_production_plan-edit');
                    var hasDeletePermission = datas.permissions.some(permission => permission.name === 'pre_production_plan-delete');
                    var hasViewPermission = datas.permissions.some(permission => permission.name === 'pre_production_plan-view');
                    if (hasDeletePermission || hasEditPermission || hasViewPermission) {

                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        var actions = '<ul class="list-inline font-size-20 contact-links mb-0">\
                        <li class="list-inline-item">\
                        <div class="dropdown">\
                        <a href="javascript: void(0);" class="dropdown-toggle card-drop px-2" data-bs-toggle="dropdown" aria-expanded="false">\
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>\
                        </a>\
                        <ul class="dropdown-menu dropdown-menu-end">';

                        if (hasEditPermission) {
                            actions += '<li><a href="./pre_production_plans/' + full.id + '/edit?order_id=' + full.order_id + '" class="dropdown-item edit-list" data-edit-id="' + full.id + '"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>';
                        }

                        if (hasViewPermission) {
                            actions += '<li><a href="./pre_production_plans/' + full.id + '?order_id=' + full.order_id + '" class="dropdown-item edit-list" data-edit-id="' + full.id + '"><i class="mdi mdi-eye font-size-16 text-primary me-1"></i> Edit</a></li>';
                        }

                        if (hasDeletePermission) {
                            actions += '<li><a href="#removePreProductionPlanModal" data-bs-toggle="modal" class="dropdown-item remove-list" data-remove-id="' + full.id + '"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>';
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
            editContactList();
            removePreProductionPlan();
        },
    });

    $('#searchTableList').keyup(function () {
        $('#userList-table').DataTable().search($(this).val()).draw();
    });
    $(".dataTables_length select").addClass('form-select form-select-sm');
    $('.dataTables_paginate').addClass('pagination-rounded');
    $(".dataTables_filter").hide();
}


// create user modal form
var createContactForms = document.querySelectorAll('.createPreProductionPlan-form')
Array.prototype.slice.call(createContactForms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();

            var name = document.getElementById('name-input').value;
            var status = document.getElementById('switch6').checked ? 1 : 0;

            if (name !== "" && status !== "" && !editList) {
                console.log(yarn_purchase_orderListData);
                var newUserId = findNextId();

                var newList = {
                    "id": newUserId,
                    "name": name,
                    "status": status,
                };

                yarn_purchase_orderListData.data.push(newList);

            } else if (name !== "" && status !== "" && editList) {
                var getEditid = 0;
                getEditid = document.getElementById('yarn_purchase_orderId-input').value;
                yarn_purchase_orderListData.data = yarn_purchase_orderListData.data.map(function (yarn_purchase_order) {
                    if (yarn_purchase_order.id == getEditid) {
                        var editObj = {
                            'id': getEditid,
                            "name": name,
                            "status": status,
                        }

                        return editObj;
                    }
                    return yarn_purchase_order;
                });
                editList = false;
            }

            if ($.fn.DataTable.isDataTable('#userList-table')) {
                $('#userList-table').DataTable().destroy();
            }
            loadUserList(yarn_purchase_orderListData)
            form.submit();

            $("#newPreProductionPlanModal").modal("hide");
        }
        form.classList.add('was-validated');
    }, false)
});


function fetchIdFromObj(member) {
    return parseInt(member.id);
}

function findNextId() {
    if (yarn_purchase_orderListData.data.length === 0) {
        return 0;
    }
    var lastElementId = fetchIdFromObj(yarn_purchase_orderListData.data[yarn_purchase_orderListData.data.length - 1]),
        firstElementId = fetchIdFromObj(yarn_purchase_orderListData.data[0]);
    return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
}

// edit list event
function editContactList() {
    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');
            editList = true;
            document.getElementById("createPreProductionPlan-form").classList.remove("was-validated");
            yarn_purchase_orderListData.data = yarn_purchase_orderListData.data.map(function (yarn_purchase_order) {
                if (yarn_purchase_order.id == getEditid) {
                    document.getElementById("newPreProductionPlanModalLabel").innerHTML = "Edit Yarn Purchase Order";
                    document.getElementById("addPreProductionPlan-btn").innerHTML = "Update";
                    document.getElementById("yarn_purchase_orderId-input").value = yarn_purchase_order.id;
                    document.getElementById("name-input").value = yarn_purchase_order.name;
                    document.getElementById('switch6').checked = yarn_purchase_order.status == 1 ? 1 : 0;


                    var form = document.getElementById('createPreProductionPlan-form');
                    var currentAction = form.action;

                    // Append the value to the current action
                    var newAction = currentAction + '/' + yarn_purchase_order.id; // Replace 'your-value' with the value you want to append

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
                return yarn_purchase_order;
            });
        });
    });
}


// add list event
Array.from(document.querySelectorAll(".addPreProductionPlan-modal")).forEach(function (elem) {
    elem.addEventListener('click', function (event) {
        editList = false;
        document.getElementById("createPreProductionPlan-form").classList.remove("was-validated");
        document.getElementById("newPreProductionPlanModalLabel").innerHTML = "Add Yarn Purchase Order";
        document.getElementById("addPreProductionPlan-btn").innerHTML = "Add";
        document.getElementById("yarn_purchase_orderId-input").value = "";
        document.getElementById("name-input").value = "";
        document.getElementById("switch6").checked = false;

    });
});

function generateSlug() {
    // Get the value from the title field
    const title = document.getElementById('name-input').value;

    // Generate a slug from the title
    const slug = title.toLowerCase().replace(/\s+/g, '-');

    // Set the slug value in the slug field
    document.getElementById('slug-input').value = slug;
}

// remove yarn_purchase_order
function removePreProductionPlan() {
    var getid = 0;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (yarn_purchase_order) {
        yarn_purchase_order.addEventListener('click', function (event) {
            getid = yarn_purchase_order.getAttribute('data-remove-id');
            document.getElementById("remove-yarn_purchase_order").addEventListener("click", function () {
                function arrayRemove(arr, value) {
                    return arr.filter(function (ele) {
                        return ele.id != value;
                    });
                }
                var filtered = arrayRemove(yarn_purchase_orderListData.data, getid);

                yarn_purchase_orderListData.data = filtered;

                $.ajax({
                    url: "./pre_production_plans/" + getid + "/delete",
                    type: "GET",
                    dataType: 'json',
                    success: function (resonse) {
                        toastr["success"](resonse.message);
                    }
                });

                if ($.fn.DataTable.isDataTable('#userList-table')) {
                    $('#userList-table').DataTable().destroy();
                }
                loadUserList(yarn_purchase_orderListData);
                $("#removePreProductionPlanModal").modal("hide");
            });
        });
    });
}
