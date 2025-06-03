'use strict';

import { default as ibc } from './classes/image-button-change.js';
import { default as ibf } from './classes/image-button-filter.js';
import { default as isl } from './classes/image-select-limit.js';
import { default as iso } from './classes/image-select-orderby.js';
import { default as isod } from './classes/image-select-orderbydirection.js';
import imageFilter from './classes/image-filter.js';
import { default as ic } from './classes/image-container.js';

/* Image Filter App for admin article page

image-button-change             ibc             show/hide filter block

image-init                                      holds image id if exist
image-message                                   display message to user
image-error-message                             display error message

image-filter                    imageFilter     filter block
image-filters                                   filter select, button
image-container                                 images
image-pages                                     page buttons

image-select-limit              isl             limit select
image-select-orderby            iso             order by select
image-select-orderbydirection   isod            order direction select
image-button-filter             ibf             filter images

*/

// show filter
var isFilterOpen = false;
ibc.onEvent('click', () => {
    if (isFilterOpen === false) {
        imageFilter.show();
        ibc.text('Hide');
        isFilterOpen = true;
    } else {
        imageFilter.hide();
        ibc.text('Change');
        isFilterOpen = false;
    }
});

// make filter
ibf.onEvent('click', () => {
    // clear rows
    console.log('clear rows');
    // make a request
    console.log('make a request');
    
    console.log(isl.getValue());
    console.log(iso.getValue());
    console.log(isod.getValue())
    // fill rows;
    ic.fill();
});