/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Form repeater Js File
*/

$(document).ready(function () {
    'use strict';

    $('.repeater').repeater({
        defaultValues: {
            'textarea-input': 'foo',
            'text-input': 'bar',
            'select-input': 'B',
            'checkbox-input': ['A', 'B'],
            'radio-input': 'B'
        },
        show: function () {
            $(this).slideDown();
            $(this).find('[name^="group-a"][name$="[color]"]').each(function () {
                $(this).siblings('.sp-colorize-container').remove();
                $(this).spectrum({
                    color: "#556ee6"
                });
            });
            $(this).find('select').each(function () {
                if (typeof $(this).attr('id') === "undefined") {
                    // ...
                } else {
                    $('.select2').removeAttr("id").removeAttr("data-select2-id"); //some times id was not unique So select2 not working, so i remove id
                    $('.select2').select2({
                        placeholder: "Select"
                    });
                    $('.select2-container').css('width', '100%');
                    $('.select2').next().next().remove();
                }
            });

        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        ready: function (setIndexes) {

        }
    });

    window.outerRepeater = $('.outer-repeater').repeater({
        defaultValues: { 'text-input': 'outer-default' },
        show: function () {
            console.log('outer show');
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            console.log('outer delete');
            $(this).slideUp(deleteElement);
        },
        repeaters: [{
            selector: '.inner-repeater',
            defaultValues: { 'inner-text-input': 'inner-default' },
            show: function () {
                console.log('inner show');
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                console.log('inner delete');
                $(this).slideUp(deleteElement);
            }
        }]
    });
});
