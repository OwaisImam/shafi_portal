/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: contact user list Js File
*/


var url = "/";
var knitting_programListData = '';
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
getJSON("admin/department/" + department + "/knitting_program", function (err, data) {
    if (err !== null) {
        console.log("Something went wrong: " + err);
    } else {
        knitting_programListData = data.result;
        loadUserList(knitting_programListData)
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
                data: "job.number",
            },
            {
                data: "order.code",
                render: function (data, type, full, meta) {
                    return '<a href="javascript: void(0);" class="badge badge-soft-primary font-size-11 m-1">' + data + '</a>';

                }
            },
            {
                data: "description",
            },
            {
                data: null,
                'bSortable': false,
                render: function (data, type, full) {
                    var hasEditPermission = datas.permissions.some(permission => permission.name === 'knitting_program-edit');
                    var hasDeletePermission = datas.permissions.some(permission => permission.name === 'knitting_program-delete');
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
                            actions += '<li><a href="./knitting_program/' + full.id + '/edit" class="dropdown-item edit-list" data-edit-id="' + full.id + '"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>';
                        }

                        if (hasDeletePermission) {
                            actions += '<li><a href="#removeKnittingProgramModal" data-bs-toggle="modal" class="dropdown-item remove-list" data-remove-id="' + full.id + '"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>';
                        }

                        actions += '<li><a href="./knitting_program/' + full.id + '/" class="dropdown-item remove-list"><i class="mdi mdi-trash-can font-size-16 text-primary me-1"></i> View</a></li>';

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
            removeKnittingProgram();
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
var createContactForms = document.querySelectorAll('.createKnittingProgram-form')
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
                console.log(knitting_programListData);
                var newUserId = findNextId();

                var newList = {
                    "id": newUserId,
                    "name": name,
                    "status": status,
                };

                knitting_programListData.data.push(newList);

            } else if (name !== "" && status !== "" && editList) {
                var getEditid = 0;
                getEditid = document.getElementById('knitting_programId-input').value;
                knitting_programListData.data = knitting_programListData.data.map(function (knitting_program) {
                    if (knitting_program.id == getEditid) {
                        var editObj = {
                            'id': getEditid,
                            "name": name,
                            "status": status,
                        }

                        return editObj;
                    }
                    return knitting_program;
                });
                editList = false;
            }

            if ($.fn.DataTable.isDataTable('#userList-table')) {
                $('#userList-table').DataTable().destroy();
            }
            loadUserList(knitting_programListData)
            form.submit();

            $("#newKnittingProgramModal").modal("hide");
        }
        form.classList.add('was-validated');
    }, false)
});


function fetchIdFromObj(member) {
    return parseInt(member.id);
}

function findNextId() {
    if (knitting_programListData.data.length === 0) {
        return 0;
    }
    var lastElementId = fetchIdFromObj(knitting_programListData.data[knitting_programListData.data.length - 1]),
        firstElementId = fetchIdFromObj(knitting_programListData.data[0]);
    return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
}

// edit list event
function editContactList() {
    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');
            editList = true;
            document.getElementById("createKnittingProgram-form").classList.remove("was-validated");
            knitting_programListData.data = knitting_programListData.data.map(function (knitting_program) {
                if (knitting_program.id == getEditid) {
                    document.getElementById("newKnittingProgramModalLabel").innerHTML = "Edit Yarn Program";
                    document.getElementById("addKnittingProgram-btn").innerHTML = "Update";
                    document.getElementById("knitting_programId-input").value = knitting_program.id;
                    document.getElementById("name-input").value = knitting_program.name;
                    document.getElementById('switch6').checked = knitting_program.status == 1 ? 1 : 0;


                    var form = document.getElementById('createKnittingProgram-form');
                    var currentAction = form.action;

                    // Append the value to the current action
                    var newAction = currentAction + '/' + knitting_program.id; // Replace 'your-value' with the value you want to append

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
                return knitting_program;
            });
        });
    });
}


// add list event
Array.from(document.querySelectorAll(".addKnittingProgram-modal")).forEach(function (elem) {
    elem.addEventListener('click', function (event) {
        editList = false;
        document.getElementById("createKnittingProgram-form").classList.remove("was-validated");
        document.getElementById("newKnittingProgramModalLabel").innerHTML = "Add Yarn Program";
        document.getElementById("addKnittingProgram-btn").innerHTML = "Add";
        document.getElementById("knitting_programId-input").value = "";
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

// remove knitting_program
function removeKnittingProgram() {
    var getid = 0;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (knitting_program) {
        knitting_program.addEventListener('click', function (event) {
            getid = knitting_program.getAttribute('data-remove-id');
            document.getElementById("remove-knitting-program").addEventListener("click", function () {
                function arrayRemove(arr, value) {
                    return arr.filter(function (ele) {
                        return ele.id != value;
                    });
                }
                var filtered = arrayRemove(knitting_programListData.data, getid);

                knitting_programListData.data = filtered;

                $.ajax({
                    url: "./knitting_program/" + getid + "/delete",
                    type: "GET",
                    dataType: 'json',
                    success: function (resonse) {
                        toastr["success"](resonse.message);
                    }
                });

                if ($.fn.DataTable.isDataTable('#userList-table')) {
                    $('#userList-table').DataTable().destroy();
                }
                loadUserList(knitting_programListData);
                $("#removeKnittingProgramModal").modal("hide");
            });
        });
    });
}
