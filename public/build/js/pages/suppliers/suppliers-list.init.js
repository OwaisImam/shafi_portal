/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: contact user list Js File
*/


var url = "/";
var itemListData = '';
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

$('#newSupplierModal').on('shown.bs.modal', function () {
    $('#items-input').select2({
        dropdownParent: $("#newSupplierModal")
    });

    $('#category-input').select2({
        dropdownParent: $("#newSupplierModal")
    });
});

// get json
getJSON("admin/department/" + department + "/suppliers", function (err, data) {
    if (err !== null) {
        console.log("Something went wrong: " + err);
    } else {
        itemListData = data.result;
        loadUserList(itemListData)
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
                data: "code",
            },
            {
                data: "name",
            },
            {
                data: "contact_person",
            },
            {
                data: "items",
                render: function (data, type, full) {
                    var items = full.items;
                    var tagHtml = '';
                    var tabShowSize = 2;
                    Array.from(items.slice(0, tabShowSize)).forEach(function (tag, index) {
                        tagHtml += '<a href="javascript: void(0);" class="badge badge-soft-primary font-size-11 m-1">' + tag.name + '</a>';
                    });
                    if (items.length > tabShowSize) {
                        var tabsLength = items.length - tabShowSize;
                        tagHtml += '<a href="javascript: void(0);" class="badge badge-soft-primary font-size-11 m-1">' + tabsLength + ' more</a>';
                    }

                    return tagHtml;
                },
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
                    var hasEditPermission = datas.permissions.some(permission => permission.name === 'suppliers-edit');
                    var hasDeletePermission = datas.permissions.some(permission => permission.name === 'suppliers-delete');
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
                            actions += '<li><a href="#newSupplierModal" data-bs-toggle="modal" class="dropdown-item edit-list" data-edit-id="' + full.id + '"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>';
                        }

                        if (hasDeletePermission) {
                            actions += '<li><a href="#removeSupplierModal" data-bs-toggle="modal" class="dropdown-item remove-list" data-remove-id="' + full.id + '"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>';
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
var createContactForms = document.querySelectorAll('.createSupplier-form')
Array.prototype.slice.call(createContactForms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();

            var name = document.getElementById('name-input').value;
            var status = document.getElementById('switch6').checked ? 1 : 0;
            var contact_person = document.getElementById("contact-person-input").value;
            var contact_number = document.getElementById("contact-number-input").value;
            var items = document.getElementById('items-input').value;
            var category = document.getElementById('category-input').value;

            if (name !== "" && status !== "" && !editList) {
                console.log(itemListData);
                var newUserId = findNextId();

                var newList = {
                    "id": newUserId,
                    "name": name,
                    "status": status,
                    "contact_person": contact_person,
                    "contact_number": contact_number,
                    "category": category,
                    "items": items,
                    "code": null
                };

                itemListData.data.push(newList);

            } else if (name !== "" && status !== "" && editList) {
                var getEditid = 0;
                getEditid = document.getElementById('supplierId-input').value;
                itemListData.data = itemListData.data.map(function (item) {
                    if (item.id == getEditid) {
                        var editObj = {
                            'id': getEditid,
                            "name": name,
                            "status": status,
                            "contact_person": item.contact_person,
                            "contact_number": item.contact_number,
                            "category": item.category_id,
                            "items": item.items,
                            "code": item.code
                        }
                        console.log("edit obj:", editObj);
                        return editObj;
                    }
                    return item;
                });
                editList = false;
            }

            if ($.fn.DataTable.isDataTable('#userList-table')) {
                $('#userList-table').DataTable().destroy();
            }
            console.log(itemListData);
            loadUserList(itemListData)
            form.submit();
            $("#newCategoryModal").modal("hide");
        }
        form.classList.add('was-validated');
    }, false)
});


function fetchIdFromObj(member) {
    return parseInt(member.id);
}

function findNextId() {
    if (itemListData.data.length === 0) {
        return 0;
    }
    var lastElementId = fetchIdFromObj(itemListData.data[itemListData.data.length - 1]),
        firstElementId = fetchIdFromObj(itemListData.data[0]);
    return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
}

// edit list event
function editContactList() {
    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');
            editList = true;
            document.getElementById("createSupplier-form").classList.remove("was-validated");
            itemListData.data = itemListData.data.map(function (item) {
                if (item.id == getEditid) {
                    document.getElementById("newSupplierModalLabel").innerHTML = "Edit Supplier";
                    document.getElementById("addSupplier-btn").innerHTML = "Update";
                    document.getElementById("supplierId-input").value = item.id;
                    document.getElementById("name-input").value = item.name;
                    document.getElementById("contact-person-input").value = item.contact_person;
                    document.getElementById("contact-number-input").value = item.contact_number;
                    document.getElementById('switch6').checked = item.status == 1 ? 1 : 0;

                    var selectedItems = [];
                    item.items.forEach(function (item) {
                        selectedItems.push(item.id);
                    });

                    $('#items-input').val(selectedItems).trigger('change');
                    $('#category-input').val(item.category_id).trigger('change');

                    var form = document.getElementById('createSupplier-form');
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
Array.from(document.querySelectorAll(".addSupplier-modal")).forEach(function (elem) {
    elem.addEventListener('click', function (event) {
        editList = false;
        document.getElementById("createSupplier-form").classList.remove("was-validated");
        document.getElementById("newSupplierModalLabel").innerHTML = "Add Supplier";
        document.getElementById("addSupplier-btn").innerHTML = "Add";
        document.getElementById("switch6").checked = false;
        document.getElementById("supplierId-input").value = "";
        document.getElementById("name-input").value = "";
        document.getElementById("contact-person-input").value = "";
        document.getElementById("contact-number-input").value = "";
        document.getElementById("items-input").value = "";


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
                var filtered = arrayRemove(itemListData.data, getid);

                itemListData.data = filtered;

                $.ajax({
                    url: "./suppliers/" + getid + "/delete",
                    type: "GET",
                    dataType: 'json',
                    success: function (resonse) {
                        toastr["success"](resonse.message);

                    }
                });

                if ($.fn.DataTable.isDataTable('#userList-table')) {
                    $('#userList-table').DataTable().destroy();
                }
                loadUserList(itemListData);
                $("#removeSupplierModal").modal("hide");
            });
        });
    });
}
