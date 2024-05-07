/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: contact user list Js File
*/

var url = "/";
var userListData = '';
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
getJSON("admin/clients  ", function (err, data) {
    if (err !== null) {
        console.log("Something went wrong: " + err);
    } else {
        userListData = data.result;
        loadUserList(userListData)
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
                data: null,
                render: function (data, type, full) {
                    var isUserProfile = full.logo ? '<img src="' + full.logo.image_path + '" alt="" class="rounded-circle header-profile-user" />'
                        : '<div class="avatar-title rounded-circle text-uppercase">' + full.name[0] + '</div>';
                    return '<div class="d-none">' + full.id + '</div><div class="avatar-xs img-fluid rounded-circle">' + isUserProfile + '</div';
                }

            },
            {
                data: "name",
                render: function (data, type, full) {
                    return '<div>\
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">'+ full.name + '</a></h5>\
                    <p class="text-muted mb-0"></p>\
                    </div>';
                },
            },
            { data: "email" },

            {
                data: "city",
                render: function (data, type, full) {
                    return full.city.name;
                }
            },
            {
                data: "postal_code",
                render: function (data, type, full) {
                    return full.postal_code;
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
                },
            },
            {
                data: "created_at",
                render: function (data, type, full) {
                    return moment(data).format('DD-MM-YYYY');
                }
            },

            {
                data: null,
                'bSortable': false,
                render: function (data, type, full) {
                    var hasEditPermission = datas.permissions && datas.permissions.some(permission => permission.name === 'clients-edit');
                    var hasDeletePermission = datas.permissions && datas.permissions.some(permission => permission.name === 'clients-delete');
                    var hasViewPermission = datas.permissions && datas.permissions.some(permission => permission.name === 'clients-view');
                    var hasGenerateCredentialsPermission = datas.permissions && datas.permissions.some(permission => permission.name === 'clients-generate-credentials');
                    if (hasDeletePermission || hasEditPermission || hasViewPermission || hasGenerateCredentialsPermission) {

                        var actions = '<ul class="list-inline font-size-20 contact-links mb-0">\
                        <li class="list-inline-item">\
                        <div class="dropdown">\
                        <a href="javascript: void(0);" class="dropdown-toggle card-drop px-2" data-bs-toggle="dropdown" aria-expanded="false">\
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>\
                        </a>\
                        <ul class="dropdown-menu dropdown-menu-end">';

                        if (hasEditPermission) {
                            actions += '<li><a href="#newClientModal" data-bs-toggle="modal" class="dropdown-item edit-list" data-edit-id="' + full.id + '"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>';
                        }

                        if (hasDeletePermission) {
                            actions += '<li><a href="#removeItemModal" data-bs-toggle="modal" class="dropdown-item remove-list" data-remove-id="' + full.id + '"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>';
                        }

                        if (hasViewPermission) {
                            actions += '<li><a href="clients/' + full.id + '/show" class="dropdown-item"><i class="mdi mdi-eye font-size-16 text-warning me-1"></i> View</a></li>';
                        }

                        if (hasViewPermission) {
                            actions += '<li><a href="clients/' + full.id + '/generate_credentials" class="dropdown-item"><i class="mdi mdi-lock font-size-16 text-warning me-1"></i> Generate Credentials</a></li>';
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
            editClientList();
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

// Select2
$("#tag-input").select2();

// create user modal form
var createContactForms = document.querySelectorAll('.createContact-form')
Array.prototype.slice.call(createContactForms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();
            var memberImg = document.getElementById("member-img").src;
            var memberImgValue = memberImg.substring(
                memberImg.indexOf("/as") + 1
            );

            var memberImageValue
            if (memberImgValue == "build/images/users/user-dummy-img.jpg") {
                memberImageValue = ""
            } else {
                memberImageValue = memberImg
            }

            var name = document.getElementById('username-input').value;
            var emailInput = document.getElementById('email-input').value;
            var addressInput = document.getElementById('address-input').value;
            var countryInput = document.getElementById("country").value;
            var stateInput = document.getElementById("state").value;
            var cityInput = document.getElementById("city").value;
            var phoneInput = document.getElementById("phone-input").value;
            var websiteInput = document.getElementById("website-input").value;
            var postalcodeInput = document.getElementById("postalcode-input").value;

            if (name !== "" && addressInput !== "" && emailInput !== "" && !editList) {
                var newUserId = findNextId();

                var newList = {
                    "id": newUserId,
                    "memberImg": memberImageValue,
                    "name": name,
                    "phone": phoneInput,
                    "address": addressInput,
                    "email": emailInput,
                    "country": countryInput,
                    "state": stateInput,
                    "city": cityInput,
                    "wesbite": websiteInput,
                    "postalcode": postalcodeInput,
                };
                userListData.push(newList)
            } else if (name !== "" && phoneInput !== "" && emailInput !== "" && editList) {
                var getEditid = 0;
                getEditid = document.getElementById("userid-input").value;
                userListData = userListData.map(function (item) {
                    if (item.id == getEditid) {

                        var editObj = {
                            'id': getEditid,
                            "memberImg": memberImageValue,
                            "name": name,
                            "phone": phoneInput,
                            "address": addressInput,
                            "email": emailInput,
                            "country": countryInput,
                            "state": stateInput,
                            "city": cityInput,
                            "wesbite": websiteInput,
                            "postalcode": postalcodeInput,
                        };
                        return editObj;
                    }
                    return item;
                });
                editList = false;
            }
            form.submit();
        }
        form.classList.add('was-validated');
    }, false)
});


function fetchIdFromObj(member) {
    return parseInt(member.id);
}

function findNextId() {
    if (userListData.length === 0) {
        return 0;
    }
    var lastElementId = fetchIdFromObj(userListData[userListData.length - 1]),
        firstElementId = fetchIdFromObj(userListData[0]);
    return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
}

// member image
document.querySelector("#member-image-input").addEventListener("change", function () {
    var preview = document.querySelector("#member-img");
    var file = document.querySelector("#member-image-input").files[0];
    var reader = new FileReader();
    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);
    if (file) {
        reader.readAsDataURL(file);
    }
});


// edit list event
function editClientList() {
    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');
            editList = true;

            document.getElementById("createContact-form").classList.remove("was-validated")
            userListData = userListData.data.map(function (item) {
                if (item.id == getEditid) {
                    document.getElementById("newClientModalLabel").innerHTML = "Edit Profile";
                    document.getElementById("addContact-btn").innerHTML = "Update";
                    document.getElementById("userid-input").value = item.id;

                    var form = document.getElementById('createContact-form');
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

                    if (item.memberImg == "") {
                        document.getElementById("member-img").src = "build/images/users/user-dummy-img.jpg";
                    } else {
                        document.getElementById("member-img").src = item?.logo?.image_path;
                    }

                    console.log(item);
                    document.getElementById('username-input').value = item.name;
                    document.getElementById('email-input').value = item.email;
                    document.getElementById('address-input').value = item.address;
                    document.getElementById("country").value = item.country;
                    document.getElementById("state").value = item.state;
                    document.getElementById("city").value = item.city;
                    document.getElementById("phone-input").value = item.phone_number;
                    document.getElementById("website-input").value = item.website;
                    document.getElementById("postalcode-input").value = item.postal_code;
                    if (item.type == 'indirect') {
                        document.getElementById('indirect').checked = true;
                    } else if (item.type == 'direct') {
                        document.getElementById('direct').checked = true;

                    }
                    document.getElementById("country").value = item.city.state.country.id;

                    selectState(item);
                    selectCity(item);

                }
                return item;
            });
        });
    });
}
function selectState(item) {

    var idCountry = document.getElementById('country').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $("#seachable-select-state").html('');
    $.ajax({
        url: "../admin/fetch-states",
        type: "POST",
        data: {
            country_id: idCountry,
            _token: csrfToken
        },
        dataType: 'json',
        success: function (result) {
            $('#state').html(
                '<option value="">Select State</option>');
            $.each(result.states, function (key, value) {
                $("#state").append('<option value="' +
                    value.id + '">' + value.name + '</option>');
            });
            $('#seachable-select-city').html(
                '<option value="">Select City</option>');

            let selectedStateId = item.city.state.id;
            $('#state').val(selectedStateId);

        }
    });
}

function selectCity(item) {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $("#seachable-select-state").html('');
    $.ajax({
        url: "../admin/fetch-cities",
        type: "POST",
        data: {
            state_id: item.city.state.id,
            _token: csrfToken
        },
        dataType: 'json',
        success: function (result) {
            $('#city').html(
                '<option value="">Select City</option>');
            $.each(result.cities, function (key, value) {
                $("#city").append('<option value="' + value
                    .id + '">' + value.name + '</option>');
            });

            let selectedCityID = item.city.id;
            $('#city').val(selectedCityID);

        }
    });
}

// add list event
Array.from(document.querySelectorAll(".addContact-modal")).forEach(function (elem) {
    elem.addEventListener('click', function (event) {
        editList = false;
        document.getElementById("createContact-form").classList.remove("was-validated");
        document.getElementById("newClientModalLabel").innerHTML = "Add Contact";
        document.getElementById("addContact-btn").innerHTML = "add";
        document.getElementById("userid-input").value = "";
        document.getElementById("username-input").value = "";
        document.getElementById("email-input").value = "";
        document.getElementById("designation-input").value = "";
        document.getElementById("member-img").src = "build/images/users/user-dummy-img.jpg";
        $("#tag-input").select2({
            multiple: true,
        });
        $('#tag-input').val("").trigger('change');
    });
});

// remove item

function removeItem() {
    var getid = 0;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (item) {
        item.addEventListener('click', function (event) {
            getid = item.getAttribute('data-remove-id');
            document.getElementById("remove-item").addEventListener("click", function () {
                $.ajax({
                    url: "../admin/clients/" + getid + "/delete",
                    type: "GET",
                    dataType: 'json',
                    success: function (resonse) {
                        userListData = resonse.result;

                        if ($.fn.DataTable.isDataTable('#userList-table')) {
                            $('#userList-table').DataTable().destroy();
                        }
                        loadUserList(userListData);
                        $("#removeItemModal").modal("hide");
                    }
                });
            });
        });
    });
}
