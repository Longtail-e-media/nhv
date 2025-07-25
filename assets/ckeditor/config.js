﻿/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};

CKEDITOR.stylesSet.add('default', [
    {name: 'Blue Title', element: 'h3', styles: {color: 'Blue'}},
    {
        name: 'Red Title',
        element: 'h3',
        styles: {color: 'Red'}
    }, {name: 'Marker: Yellow', element: 'span', styles: {'background-color': 'Yellow'}}, {
        name: 'Marker: Green',
        element: 'span',
        styles: {'background-color': 'Lime'}
    }, {name: 'Big', element: 'big'}, {name: 'Small', element: 'small'}, {name: 'Typewriter', element: 'tt'}, {
        name: 'Computer Code',
        element: 'code'
    }, {name: 'Keyboard Phrase', element: 'kbd'}, {name: 'Sample Text', element: 'samp'}, {
        name: 'Variable',
        element: 'var'
    }, {name: 'Deleted Text', element: 'del'}, {name: 'Inserted Text', element: 'ins'}, {
        name: 'Cited Work',
        element: 'cite'
    }, {name: 'Inline Quotation', element: 'q'}, {name: 'Language: RTL', element: 'span', attributes: {dir: 'rtl'}}, {
        name: 'Language: LTR',
        element: 'span',
        attributes: {dir: 'ltr'}
    }, {
        name: 'Image on Left',
        element: 'img',
        attributes: {style: 'padding: 5px; margin-right: 5px', border: '2', align: 'left'}
    }, {
        name: 'Image on Right',
        element: 'img',
        attributes: {style: 'padding: 5px; margin-left: 5px', border: '2', align: 'right'}
    }, {
        name: 'Borderless Table',
        element: 'table',
        styles: {'border-style': 'hidden', 'background-color': '#E6E6FA'}
    }, {name: 'Square Bulleted List', element: 'ul', styles: {'list-style-type': 'square'}},
    {name: 'Unordered List', element: 'ul', attributes: {'class': 'ul'}},
    {name: 'Ordered List', element: 'ol', attributes: {'class': 'ol'}}
]);