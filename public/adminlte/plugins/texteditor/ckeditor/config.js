/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.contentCss="fonts.css";
	config.font_names='Amiri;' + 'Almarai;' +'El Messiri;' +'Reem Kufi;' + 'Aref Ruqaa;' + CKEDITOR.config.font_names;
};
