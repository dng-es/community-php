/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
config.language = 'es';
config.uiColor = '##F5F5F5';
config.skin = 'kama';
config.enterMode = CKEDITOR.ENTER_BR;
config.colorButton_colors = '4A5A73,c54747,00773d,555555';
config.height        = '400px';
config.contentsCss = 'js/libs/ckeditor/contents.css';
config.toolbar_Full = [
['Styles','Format','Font','FontSize'],
['JustifyLeft','JustifyCenter','JustifyRight','Just ifyFull','TextColor','BGColor','Bold','Italic','Underline'],
['Link','Unlink'],
['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
['Source'],
['Image','Flash'],['Table','HorizontalRule','Smiley','SpecialChar']
];
};
