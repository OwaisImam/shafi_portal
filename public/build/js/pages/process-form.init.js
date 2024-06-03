/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Process Form Init Js File
*/

var updateid = '';
var selectedstatus = '';
var processid = '';
var i = 0;

$(document).ready(function () {
    'use strict';

    //Process Assign User Validation

    $("#NewprocessForm").validate({
        rules: {
            'member[]': {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.is(':checkbox')) {
                error.insertAfter('#processassignee');
            } else {
                error.insertAfter(element);
            }
        }
    });

    //Add New Process

    $(".addProcess-btn").click(function () {
        var id = $(this).attr('data-id');
        $('#updateprocessdetail').css('display', 'none');
        $('#addprocess').css('display', 'block');
        $('.update-process-title').css('display', 'none');
        $('.add-process-title').css('display', 'block');
        $('#processname').val('');
        processid = id;
    });

    $("select#ParentProcess").change(function () {
        selectedstatus = $(this).children("option:selected").val();
    });

    //Add New Process with Validation

    $("#addprocess").click(function () {
        $('#updateprocessdetail').css('display', 'none');
        $('#addprocess').css('display', 'block');
        $('.update-process-title').css('display', 'none');
        $('.add-process-title').css('display', 'block');
        var newprocessid = makeid(5);
        var processname = $("#processname").val();
        var parentProcess = "#process_" + $("#ParentProcess option:selected").val();
        var parentProcessValue = $("#ParentProcess option:selected").val();
        var last_index = Number($("#last_index").val());

        if (processname.length == 0) {
            $("#NewprocessForm").validate().element("#processname");
        } else {

            $(processid).append(
                '<tr class="align-middle" id="' + newprocessid + '">' +
                '<th>' +
                '<input type="hidden" name="processes[' + (last_index + 1) + '][name]" value="' + processname + '"> ' +
                processname +
                '</th>' +
                '<td>' +
                '<div class="col-lg-12">' +
                ' <div class="form-check form-check-primary">' +
                '<input type="hidden" name="processes[' + (last_index + 1) + '][parent_process_id]" value="' + parentProcessValue + '" >' +
                '<input class="form-check-input" type="checkbox"' +
                'name="processes[' + (last_index + 1) + '][id]" id="label_' + newprocessid + '">' +
                '<label class="form-check-label" for="label_' + newprocessid + '">' +
                'Yes' +
                '</label>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<div class=" col-lg-12">' +
                '<input type="text" id="notes' + newprocessid + '"' +
                'name="processes[' + (last_index + 1) + '][notes]" class="form-control"' +
                'placeholder="Notes" />' +
                '</div>' +
                '</td>' +
                ' <td>' +
                '<div class="dropdown float-end">' +
                '<a href="#" class="dropdown-toggle arrow-none"' +
                '   data-bs-toggle="dropdown" aria-expanded="false">' +
                '   <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>' +
                '</a>' +
                ' <div class="dropdown-menu dropdown-menu-end">' +
                ' <a class="dropdown-item editprocess-details" href="#"' +
                '    id="taskedit" data-id="#' + newprocessid + '"' +
                '    data-bs-toggle="modal"' +
                '   data-bs-target=".bs-example-modal-lg">Edit</a>' +
                '<a class="dropdown-item deleteprocess" href="#"' +
                ' data-id="#' + newprocessid + '">Delete</a>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '</tr>'
            );


            $("#last_index").val(Number($("#last_index").val()) + 1);

            $('#modalForm').modal('toggle');
        }
    });

    $('#modalForm').on('hidden.bs.modal', function (e) {
        var validator = $("#NewprocessForm").validate();
        $('#processname').removeClass('error').next('label.error').remove();
        $('#ParentProcess').removeClass('error').next('label.error').remove();
        $('#processbudget').removeClass('error').next('label.error').remove();
        validator.resetForm();
    });

    //Update Process Details with Validation

    $("#updateprocessdetail").click(function () {
        var processname = $('#processname').val();
        var parentProcessValue = $("#ParentProcess option:selected").val();

        var last_index = Number($("#last_index").val());

        if (processname.length == 0) {
            $("#NewprocessForm").validate().element("#processname");
        } else {

            $(updateid).html(
                '<th>' +
                processname +
                '<input type="hidden" name="processes[' + (last_index + 1) + '][name]" value="' + processname + '"> ' +
                '</th>' +
                '<td>' +
                '<div class="col-lg-12">' +
                ' <div class="form-check form-check-primary">' +
                '<input type="hidden" name="processes[' + (last_index + 1) + '][parent_process_id]" value="' + parentProcessValue + '" >' +
                '<input class="form-check-input" type="checkbox"' +
                'name="processes[' + (last_index + 1) + '][id]" id="label_' + updateid + '">' +
                '<label class="form-check-label" for="label_' + updateid + '">' +
                'Yes' +
                '</label>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<div class=" col-lg-12">' +
                '<input type="text" id="notes' + updateid + '"' +
                'name="processes[' + (last_index + 1) + '][notes]" class="form-control"' +
                'placeholder="Notes" />' +
                '</div>' +
                '</td>' +
                ' <td>' +
                '<div class="dropdown float-end">' +
                '<a href="#" class="dropdown-toggle arrow-none"' +
                '   data-bs-toggle="dropdown" aria-expanded="false">' +
                '   <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>' +
                '</a>' +
                ' <div class="dropdown-menu dropdown-menu-end">' +
                ' <a class="dropdown-item editprocess-details" href="#"' +
                '    id="taskedit" data-id="#' + updateid + '"' +
                '    data-bs-toggle="modal"' +
                '   data-bs-target=".bs-example-modal-lg">Edit</a>' +
                '<a class="dropdown-item deleteprocess" href="#"' +
                ' data-id="#' + updateid + '">Delete</a>' +
                '</div>' +
                '</div>' +
                '</td>'
            )

            $('#modalForm').modal('hide');
        }
    });

    //Edit Process Details with Validation

    $('.main-content').on('click', '.editprocess-details', function (event) {
        var id = $(this).attr('data-id');
        updateid = id;
        var validator = $("#NewprocessForm").validate();
        validator.resetForm();
        $('#updateprocessdetail').css('display', 'block');
        $('#addprocess').css('display', 'none');
        $('.update-process-title').css('display', 'block');
        $('.add-process-title').css('display', 'none');
        var name = $(id).children('th:first').text();
        var desc = $(id).find('#process-desc').text();
        var budget = parseInt($(id).find('#process-budget').text().replace(/[^0-9.]/g, ""));
        var status = $(id).find('#process-status').text();
        $('#processassignee input').prop("checked", false);
        $(id).find('.process-assigne a').each(function () {
            var assigneusers = $(this).attr('value');
            $("#" + assigneusers).prop("checked", true);
        });
        $('#processname').val(name);
        $('#processdesc').val(desc);
        $('#processbudget').val(budget);
        $('#ParentProcess').val(status);
        selectedstatus = status;
    });

    //Delete Process
    $('.main-content').on('click', '.deleteprocess', function (event) {
        var id = $(this).attr('data-id');
        console.log(id);
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
