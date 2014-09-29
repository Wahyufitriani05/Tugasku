/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	//config.uiColor = '#EEEEFF';
	config.uiColor = '#F0F0FF';
        config.toolbar = 'MyToolbar';

        config.toolbar_MyToolbar =
        [
            ['NewPage','Preview'],
            ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Scayt'],
            ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
            ['Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak'],
            '/',
            ['Styles','Format'],
            ['Bold','Italic','Strike'],
            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
            ['Link','Unlink','Anchor']
        ];

};
