/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Process Form Init Js File
*/

var updateid = '';
var selectedstatus = '';
var accessoriesid = '';
var i = 0;

$(document).ready(function () {
    'use strict';

    //Process Assign User Validation

    $("#NewaccessoriesForm").validate({
        rules: {
            'member[]': {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.is(':checkbox')) {
                error.insertAfter('#accessoriesassignee');
            } else {
                error.insertAfter(element);
            }
        }
    });

    //Add New Process

    $(".addAccessories-btn").click(function () {
        var id = $(this).attr('data-id');
        $('#updateaccessoriesdetail').css('display', 'none');
        $('#addaccessories').css('display', 'block');
        $('.update-accessories-title').css('display', 'none');
        $('.add-accessories-title').css('display', 'block');
        $('#accessoriesname').val('');
        accessoriesid = id;
    });

    $("select#ParentProcess").change(function () {
        selectedstatus = $(this).children("option:selected").val();
    });

    //Add New Process with Validation

    $("#addaccessories").click(function () {
        $('#updateaccessoriesdetail').css('display', 'none');
        $('#addaccessories').css('display', 'block');
        $('.update-accessories-title').css('display', 'none');
        $('.add-accessories-title').css('display', 'block');
        var newaccessoriesid = makeid(5);
        var accessorieSelected = $("#accessories option:selected").val();
        var accessorieSelectedText = $("#accessories option:selected").text();
        var requiredQty = $("#required_qty").val();
        var notes = $("#accessories_notes").val();
        var last_index = Number($("#accessories_last_index").val());

        if (accessorieSelected.length == 0 || requiredQty == 0) {
            $("#NewaccessoriesForm").validate().element("#accessories");
            $("#NewaccessoriesForm").validate().element("#required_qty");
        } else {
            $('#accessories_table > tbody:last-child').append(
                '<tr class="align-middle" id="' + newaccessoriesid + '">' +
                '<td><input type="hidden" name="accessories[' + (last_index + 1) + '][item_id]" value="' + accessorieSelected + '">' + accessorieSelectedText + '</td>' +
                '<td>' +
                '<div class="col-lg-12">' +
                '<div class="form-check form-check-primary">' +
                '<input type="number" placeholder="Required Qty"' +
                'name="accessories[' + (last_index + 1) + '][qty]" value="' + requiredQty + '" class="form-control">' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<textarea class="form-control" placeholder="Notes" name="accessories[' + (last_index + 1) + '][notes]">' + notes + '</textarea>' +
                '</td>' +
                ' <td>' +
                '<div class="dropdown float-end">' +
                '<a href="#" class="dropdown-toggle arrow-none"' +
                '   data-bs-toggle="dropdown" aria-expanded="false">' +
                '   <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>' +
                '</a>' +
                ' <div class="dropdown-menu dropdown-menu-end">' +
                ' <a class="dropdown-item editaccessories-details" href="#"' +
                '    id="accessoriesedit" data-id="#' + newaccessoriesid + '"' +
                '    data-bs-toggle="modal"' +
                '   data-bs-target=".bs-accessories-modal-lg">Edit</a>' +
                '<a class="dropdown-item deleteaccessories" href="#"' +
                ' data-id="#' + newaccessoriesid + '">Delete</a>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '</tr>'
            );
            $("#accessories_last_index").val(Number($("#accessories_last_index").val()) + 1);

            $('#accessoriesModalForm').modal('toggle');
        }
    });

    $('#accessoriesModalForm').on('hidden.bs.modal', function (e) {
        document.forms["NewaccessoriesForm"].reset();
        $('#accessories').removeClass('error').next('label.error').remove();
        $('#required_qty').removeClass('error').next('label.error').remove();
        $('#notes').removeClass('error').next('label.error').remove();
    });

    //Update Process Details with Validation

    $("#updateaccessoriesdetail").click(function () {
        var accessoriesname = $('#accessoriesname').val();
        var accessorieSelected = $("#accessories option:selected").val();
        var accessorieSelectedText = $("#accessories option:selected").text();
        var requiredQty = $("#required_qty").val();
        var notes = $("#accessories_notes").val();

        var last_index = Number($("#accessories_last_index").val());

        if (accessorieSelected.length == 0) {
            $("#NewaccessoriesForm").validate().element("#accessoriesname");
        } else {

            $(updateid).html(
                '<td><input type="hidden" name="accessories[' + (last_index + 1) + '][item_id]" value="' + accessorieSelected + '">' + accessorieSelectedText + '</td>' +
                '<td>' +
                '<div class="col-lg-12">' +
                '<div class="form-check form-check-primary">' +
                '<input type="number" placeholder="Required Qty"' +
                'name="accessories[' + (last_index + 1) + '][qty]" value="' + requiredQty + '" class="form-control">' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<textarea class="form-control" placeholder="Notes" name="accessories[' + (last_index + 1) + '][notes]">' + notes + '</textarea>' +
                '</td>' +
                ' <td>' +
                '<div class="dropdown float-end">' +
                '<a href="#" class="dropdown-toggle arrow-none"' +
                '   data-bs-toggle="dropdown" aria-expanded="false">' +
                '   <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>' +
                '</a>' +
                ' <div class="dropdown-menu dropdown-menu-end">' +
                ' <a class="dropdown-item editaccessories-details" href="#"' +
                '    id="accessoriesedit" data-id="' + updateid + '"' +
                '    data-bs-toggle="modal"' +
                '   data-bs-target=".bs-accessories-modal-lg">Edit</a>' +
                '<a class="dropdown-item deleteaccessories" href="#"' +
                ' data-id="' + updateid + '">Delete</a>' +
                '</div>' +
                '</div>' +
                '</td>'
            )
            $('#accessoriesModalForm').modal('hide');
        }
    });

    //Edit Process Details with Validation

    $('.main-content').on('click', '.editaccessories-details', function (event) {
        event.preventDefault();

        var id = $(this).attr('data-id');
        updateid = id;

        var validator = $("#NewaccessoriesForm").validate();
        validator.resetForm();

        $('#updateaccessoriesdetail').css('display', 'block');
        $('#addaccessories').css('display', 'none');
        $('.update-accessories-title').css('display', 'block');
        $('.add-accessories-title').css('display', 'none');

        // Extract values from the selected row
        var row = $(id);
        var item_id = row.find('input[name^="accessories"][name$="[item_id]"]').val();
        var qty = row.find('input[name^="accessories"][name$="[qty]"]').val();
        var notes = row.find('textarea[name^="accessories"][name$="[notes]"]').val();

        // Populate the form fields
        $('#accessories').val(item_id);
        $('#required_qty').val(qty);
        $('#notes').val(notes);
    });

    //Delete Process
    $('.main-content').on('click', '.deleteaccessories', function (event) {
        var id = $(this).attr('data-id');
        console.log('Process Deleted Successfully');
        $(id).remove();
    });
});

//Generate ID
function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
