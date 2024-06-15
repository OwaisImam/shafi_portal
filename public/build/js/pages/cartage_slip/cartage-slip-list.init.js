/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: contact user list Js File
*/


var url = "/";
var cartageSlipListData = '';
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
getJSON("admin/department/" + department + "/cartage_slip", function (err, data) {
    if (err !== null) {
        console.log("Something went wrong: " + err);
    } else {
        rangeListData = data.result;
        loadUserList(rangeListData)
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
                data: "slip_no",
            },
            {
                data: "job.number",
            },
            {
                data: "delivery_from",
                render: function (data, type, full, meta) {
                    return full.delivery_from?.company_name ? full.delivery_from.company_name : full.delivery_from.name;
                }
            },
            {
                data: "delivery_to.company_name"
            },
            {
                data: "driver_name"
            },
            {
                data: "driver_cell_no"
            },
            {
                data: "amount"
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
                data: null,
                'bSortable': false,
                render: function (data, type, full) {
                    var hasEditPermission = datas.permissions.some(permission => permission.name === 'cartage_slip-edit');
                    var hasDeletePermission = datas.permissions.some(permission => permission.name === 'cartage_slip-delete');
                    if (hasDeletePermission || hasEditPermission) {

                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        var actions = '<ul class="list-inline font-size-20 contact-links mb-0">\
                        <li class="list-inline-item">\
                        <div class="dropdown">\
                        <a href="javascript: void(0);" class="dropdown-toggle card-drop px-2" data-bs-toggle="dropdown" aria-expanded="false">\
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>\
                        </a>\
                        <ul class="dropdown-menu dropdown-menu-end">';

                        if (hasEditPermission) {
                            actions += '<li><a href="./cartage_slip/' + full.id + '/edit" class="dropdown-item edit-list" data-edit-id="' + full.id + '"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>';
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
            removeRange();
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
var createContactForms = document.querySelectorAll('.createRange-form')
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
                console.log(rangeListData);
                var newUserId = findNextId();

                var newList = {
                    "id": newUserId,
                    "name": name,
                    "status": status,
                };

                rangeListData.data.push(newList);

            } else if (name !== "" && status !== "" && editList) {
                var getEditid = 0;
                getEditid = document.getElementById('rangeId-input').value;
                rangeListData.data = rangeListData.data.map(function (cartage_slip) {
                    if (cartage_slip.id == getEditid) {
                        var editObj = {
                            'id': getEditid,
                            "name": name,
                            "status": status,
                        }

                        return editObj;
                    }
                    return cartage_slip;
                });
                editList = false;
            }

            if ($.fn.DataTable.isDataTable('#userList-table')) {
                $('#userList-table').DataTable().destroy();
            }
            loadUserList(rangeListData)
            form.submit();

            $("#newRangeModal").modal("hide");
        }
        form.classList.add('was-validated');
    }, false)
});


function fetchIdFromObj(member) {
    return parseInt(member.id);
}

function findNextId() {
    if (rangeListData.data.length === 0) {
        return 0;
    }
    var lastElementId = fetchIdFromObj(rangeListData.data[rangeListData.data.length - 1]),
        firstElementId = fetchIdFromObj(rangeListData.data[0]);
    return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
}

// edit list event
function editContactList() {
    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');
            editList = true;
            document.getElementById("createRange-form").classList.remove("was-validated");
            rangeListData.data = rangeListData.data.map(function (cartage_slip) {
                if (cartage_slip.id == getEditid) {
                    document.getElementById("newRangeModalLabel").innerHTML = "Edit Department";
                    document.getElementById("addRange-btn").innerHTML = "Update";
                    document.getElementById("rangeId-input").value = cartage_slip.id;
                    document.getElementById("name-input").value = cartage_slip.name;
                    document.getElementById('switch6').checked = cartage_slip.status == 1 ? 1 : 0;


                    var form = document.getElementById('createRange-form');
                    var currentAction = form.action;

                    // Append the value to the current action
                    var newAction = currentAction + '/' + cartage_slip.id; // Replace 'your-value' with the value you want to append

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
                return cartage_slip;
            });
        });
    });
}


// add list event
Array.from(document.querySelectorAll(".addRange-modal")).forEach(function (elem) {
    elem.addEventListener('click', function (event) {
        editList = false;
        document.getElementById("createRange-form").classList.remove("was-validated");
        document.getElementById("newRangeModalLabel").innerHTML = "Add Range";
        document.getElementById("addRange-btn").innerHTML = "Add";
        document.getElementById("rangeId-input").value = "";
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

// remove cartage_slip
function removeRange() {
    var getid = 0;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (cartage_slip) {
        cartage_slip.addEventListener('click', function (event) {
            getid = cartage_slip.getAttribute('data-remove-id');
            document.getElementById("remove-cartage_slip").addEventListener("click", function () {
                function arrayRemove(arr, value) {
                    return arr.filter(function (ele) {
                        return ele.id != value;
                    });
                }
                var filtered = arrayRemove(rangeListData.data, getid);

                rangeListData.data = filtered;

                $.ajax({
                    url: "./cartage_slip/" + getid + "/delete",
                    type: "GET",
                    dataType: 'json',
                    success: function (resonse) {
                        toastr["success"](resonse.message);
                    }
                });

                if ($.fn.DataTable.isDataTable('#userList-table')) {
                    $('#userList-table').DataTable().destroy();
                }
                loadUserList(rangeListData);
                $("#removeRangeModal").modal("hide");
            });
        });
    });
}
