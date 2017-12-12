/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    //config.extraPlugins = 'uploadimage';
    //config.uploadUrl = '/ckeditor/upload-image';
    config.extraPlugins = 'widget,lineutils,fontawesome';
    config.contentsCss = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css';
    config.allowedContent = true;
    /*config.toolbar = [
        { name: 'insert', items: [ 'FontAwesome', 'Source' ] }
    ];*/
};