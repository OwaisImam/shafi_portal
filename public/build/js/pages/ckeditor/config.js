/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';

    config.extraPlugins = 'autocomplete';
    config.extraPlugins = 'ajax';
    config.extraPlugins = 'textwatcher';
    config.extraPlugins = 'textmatch';
    config.extraPlugins = 'xml';
    config.extraPlugins = 'panelbutton';
    config.extraPlugins = 'emoji';
    config.extraPlugins = 'floatpanel';
    config.extraPlugins = 'button';
    config.extraPlugins = 'lineheight';
    config.toolbarCanCollapse = true;
    config.fileUpload = false;
    config.removePlugins = 'easyimage';
    config.allowedContent = true;
    // config.removePlugins = 'link';
};
