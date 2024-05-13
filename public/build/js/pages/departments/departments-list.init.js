/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: contact user list Js File
*/


var url = "/";
var departmentListData = '';
var editList = false;

//contact user list by json
var getJSON = function (jsonurl, callback) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

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
getJSON("admin/departments", function (err, data) {
    if (err !== null) {
        console.log("Something went wrong: " + err);
    } else {
        departmentListData = data.result;
        loadUserList(departmentListData)
    }
});

// load table list data
function loadUserList(datas) {
    $('#userList-table').DataTable({
        data: datas.data,
        "bLengthChange": false,
        order: [[0, 'desc']],
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
                data: "name",
            },
            {
                data: "logo",
                render: function (data, type, full) {
                    var isDepartmentLogo = full.logo ? '<img src="' + full.logo.image_path + '" alt="" class="rounded-circle header-profile-user" />'
                        : '<div class="avatar-title rounded-circle text-uppercase">' + full.name[0] + '</div>';
                    return '<div class="d-none">' + full.id + '</div><div class="avatar-xs img-fluid rounded-circle">' + isDepartmentLogo + '</div';
                }
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
                render: function (data, type, full) {
                    if (full.slug != null) {
                        return '<a href="/admin/department/' + full.slug + '/dashboard" class="badge badge-soft-success"><i class="bx bx-link-external"></i></a>';
                    }
                }
            },
            {
                data: null,
                'bSortable': false,
                render: function (data, type, full) {
                    var hasEditPermission = datas.permissions.some(permission => permission.name === 'departments-edit');
                    var hasDeletePermission = datas.permissions.some(permission => permission.name === 'departments-delete');
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
                            actions += '<li><a href="#newDepartmentModal" data-bs-toggle="modal" class="dropdown-item edit-list" data-edit-id="' + full.id + '"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>';
                        }

                        if (hasDeletePermission) {
                            actions += '<li><a href="#removeItemModal" data-bs-toggle="modal" class="dropdown-item remove-list" data-remove-id="' + full.id + '"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>';
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
            removeItem();
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
var createContactForms = document.querySelectorAll('.createDepartment-form')
Array.prototype.slice.call(createContactForms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();

            var logoImg = document.getElementById("logo-input").src;
            var logoImgValue = logoImg.substring(
                logoImg.indexOf("/as") + 1
            );

            var logoImg
            if (logoImgValue == "build/images/users/user-dummy-img.jpg") {
                logoImgValue = ""
            } else {
                logoImgValue = logoImg
            }

            var name = document.getElementById('name-input').value;
            var slug = document.getElementById('slug-input').value;
            var status = document.getElementById('switch6').checked ? 1 : 0;

            if (name !== "" && status !== "" && !editList) {
                console.log(departmentListData);
                var newUserId = findNextId();

                var newList = {
                    "id": newUserId,
                    "name": name,
                    "status": status,
                    'slug': slug,
                    'logo': logoImgValue
                };

                departmentListData.data.push(newList);

            } else if (name !== "" && status !== "" && editList) {
                var getEditid = 0;
                getEditid = document.getElementById('departmentid-input').value;
                departmentListData.data = departmentListData.data.map(function (item) {
                    if (item.id == getEditid) {
                        var editObj = {
                            'id': getEditid,
                            "name": name,
                            "status": status,
                            'slug': slug,
                            'logo': logoImgValue
                        }

                        return editObj;
                    }
                    return item;
                });
                editList = false;
            }

            if ($.fn.DataTable.isDataTable('#userList-table')) {
                $('#userList-table').DataTable().destroy();
            }
            loadUserList(departmentListData)
            form.submit();
            $("#newContactModal").modal("hide");
        }
        form.classList.add('was-validated');
    }, false)
});


function fetchIdFromObj(member) {
    return parseInt(member.id);
}

function findNextId() {
    if (departmentListData.data.length === 0) {
        return 0;
    }
    var lastElementId = fetchIdFromObj(departmentListData.data[departmentListData.data.length - 1]),
        firstElementId = fetchIdFromObj(departmentListData.data[0]);
    return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
}

// edit list event
function editContactList() {
    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');
            editList = true;
            document.getElementById("createDepartment-form").classList.remove("was-validated");
            departmentListData.data = departmentListData.data.map(function (item) {
                if (item.id == getEditid) {
                    document.getElementById("newContactModalLabel").innerHTML = "Edit Department";
                    document.getElementById("addContact-btn").innerHTML = "Update";
                    document.getElementById("departmentid-input").value = item.id;
                    document.getElementById("name-input").value = item.name;
                    document.getElementById('switch6').checked = item.status == 1 ? 1 : 0;
                    document.getElementById('slug-input').value = item.slug;

                    if (item.logo == "") {
                        document.getElementById("logo-input").src = "build/images/users/user-dummy-img.jpg";
                    } else {
                        document.getElementById("logo-input").src = item.logo;
                    }

                    var form = document.getElementById('createDepartment-form');
                    var currentAction = form.action;

                    // Append the value to the current action
                    var newAction = currentAction + '/' + item.id; // Replace 'your-value' with the value you want to append

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
                return item;
            });
        });
    });
}


// add list event
Array.from(document.querySelectorAll(".addContact-modal")).forEach(function (elem) {
    elem.addEventListener('click', function (event) {
        editList = false;
        document.getElementById("createDepartment-form").classList.remove("was-validated");
        document.getElementById("newContactModalLabel").innerHTML = "Add Department";
        document.getElementById("addContact-btn").innerHTML = "Add";
        document.getElementById("departmentid-input").value = "";
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

// remove item
function removeItem() {
    var getid = 0;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (item) {
        item.addEventListener('click', function (event) {
            getid = item.getAttribute('data-remove-id');
            document.getElementById("remove-item").addEventListener("click", function () {
                function arrayRemove(arr, value) {
                    return arr.filter(function (ele) {
                        return ele.id != value;
                    });
                }
                var filtered = arrayRemove(departmentListData.data, getid);

                departmentListData.data = filtered;

                $.ajax({
                    url: "../admin/departments/" + getid + "/delete",
                    type: "GET",
                    dataType: 'json',
                    success: function (resonse) {

                    }
                });

                if ($.fn.DataTable.isDataTable('#userList-table')) {
                    $('#userList-table').DataTable().destroy();
                }
                loadUserList(departmentListData);
                $("#removeItemModal").modal("hide");
            });
        });
    });
}
