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
getJSON("admin/users", function (err, data) {
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
                    var isUserProfile = full.profile_picture ? '<img src="' + full.profile_picture.image_path + '" alt="" class="rounded-circle header-profile-user" />'
                        : '<div class="avatar-title rounded-circle text-uppercase">' + full.name.charAt(0) + '</div>';
                    return '<div class="d-none">' + full.id + '</div><div class="avatar-xs img-fluid rounded-circle">' + isUserProfile + '</div';
                }

            },
            {
                data: null,
                render: function (data, type, full) {
                    return '<div>\
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">'+ full.name + '</a></h5>\
                    <p class="text-muted mb-0"></p>\
                    </div>';
                },
            },
            { data: "email" },
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
            // {
            //     data: "tags",
            //     render: function (data, type, full) {
            //         var tags = full.tags;
            //         var tagHtml = '';
            //         var tabShowSize = 2;
            //         Array.from(tags.slice(0, tabShowSize)).forEach(function (tag, index) {
            //             tagHtml += '<a href="javascript: void(0);" class="badge badge-soft-primary font-size-11 m-1">' + tag + '</a>';
            //         });
            //         if (tags.length > tabShowSize) {
            //             var tabsLength = tags.length - tabShowSize;
            //             tagHtml += '<a href="javascript: void(0);" class="badge badge-soft-primary font-size-11 m-1">' + tabsLength + ' more</a>';
            //         }

            //         return tagHtml;
            //     },
            // },
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
                    var hasEditPermission = datas.permissions.some(permission => permission.name === 'users-edit');
                    var hasDeletePermission = datas.permissions.some(permission => permission.name === 'users-delete');
                    var hasViewPermission = datas.permissions.some(permission => permission.name === 'users-view');
                    var hasEditPermissionsPermission = datas.permissions.some(permission => permission.name === 'permissions-edit');
                    if (hasDeletePermission || hasEditPermission || hasEditPermissionsPermission || hasViewPermission) {

                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        var actions = '<ul class="list-inline font-size-20 contact-links mb-0">\
                        <li class="list-inline-item">\
                        <div class="dropdown">\
                        <a href="javascript: void(0);" class="dropdown-toggle card-drop px-2" data-bs-toggle="dropdown" aria-expanded="false">\
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>\
                        </a>\
                        <ul class="dropdown-menu dropdown-menu-end">';

                        if (hasEditPermission) {
                            actions += '<li><a href="users/' + full.id + '/edit" class="dropdown-item edit-list"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>';
                        }

                        if (hasDeletePermission) {
                            actions += '<form action="users/' + full.id + '" method="POST">';
                            actions += '<input type="hidden" name="_token" value="' + csrfToken + '">';
                            actions += '<input type="hidden" name="_method" value="DELETE">';
                            actions += '<li><button type="submit" class="dropdown-item remove-list"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</button></li>';
                            actions += '</form>';
                        }

                        if (hasViewPermission) {
                            actions += '<li><a href="users/' + full.id + '/show" class="dropdown-item remove-list"><i class="mdi mdi-eye font-size-16 text-warning me-1"></i> View</a></li>';
                        }

                        if (hasEditPermissionsPermission) {
                            actions += '<li><a href="permissions/' + full.id + '" class="dropdown-item remove-list" data-remove-id="' + full.id + '"><i class="mdi mdi-lock font-size-16 text-warning me-1"></i> Permissions</a></li>';
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

            var userName = document.getElementById('username-input').value;
            var str = userName;
            var matches = str.match(/\b(\w)/g);
            var acronym = matches.join(''); // JSON
            var nicknameValue = acronym.substring(0, 2)

            var designationInput = document.getElementById('designation-input').value;
            var emailInput = document.getElementById('email-input').value;
            var tagInputFieldValue = $("#tag-input").val();

            if (userName !== "" && designationInput !== "" && emailInput !== "" && !editList) {
                var newUserId = findNextId();

                var newList = {
                    "id": newUserId,
                    "memberImg": memberImageValue,
                    "nickname": nicknameValue,
                    "userName": userName,
                    "designation": designationInput,
                    "email": emailInput,
                    "tags": tagInputFieldValue,
                    "projects": "--"
                };

                userListData.push(newList)
            } else if (userName !== "" && designationInput !== "" && emailInput !== "" && editList) {
                var getEditid = 0;
                getEditid = document.getElementById("userid-input").value;
                userListData = userListData.map(function (item) {
                    if (item.id == getEditid) {
                        var editObj = {
                            'id': getEditid,
                            "memberImg": memberImageValue,
                            "nickname": nicknameValue,
                            "userName": userName,
                            "designation": designationInput,
                            "email": emailInput,
                            'tags': tagInputFieldValue,
                            "projects": item.projects
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
            loadUserList(userListData)
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
function editContactList() {
    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');
            editList = true;
            document.getElementById("createContact-form").classList.remove("was-validated")
            userListData = userListData.map(function (item) {
                if (item.id == getEditid) {
                    document.getElementById("newContactModalLabel").innerHTML = "Edit Profile";
                    document.getElementById("addContact-btn").innerHTML = "Update";
                    document.getElementById("userid-input").value = item.id;
                    if (item.memberImg == "") {
                        document.getElementById("member-img").src = "build/images/users/user-dummy-img.jpg";
                    } else {
                        document.getElementById("member-img").src = item.memberImg;
                    }
                    document.getElementById("username-input").value = item.userName;
                    document.getElementById("designation-input").value = item.designation;
                    document.getElementById("email-input").value = item.email;

                    $("#tag-input").select2({
                        multiple: true,
                    });
                    $('#tag-input').val(item.tags).trigger('change');
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
        document.getElementById("createContact-form").classList.remove("was-validated");
        document.getElementById("newContactModalLabel").innerHTML = "Add Contact";
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
                function arrayRemove(arr, value) {
                    return arr.filter(function (ele) {
                        return ele.id != value;
                    });
                }
                var filtered = arrayRemove(userListData, getid);

                userListData = filtered;
                if ($.fn.DataTable.isDataTable('#userList-table')) {
                    $('#userList-table').DataTable().destroy();
                }
                loadUserList(userListData);
                $("#removeItemModal").modal("hide");
            });
        });
    });
}
