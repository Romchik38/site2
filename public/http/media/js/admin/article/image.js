'use strict';

import { default as ibc } from './image/image-button-change.js';
import { default as ibf } from './image/image-button-filter.js';
import { default as isl } from './image/image-select-limit.js';
import { default as iso } from './image/image-select-orderby.js';
import { default as isod } from './image/image-select-orderbydirection.js';
import imageFilter from './image/image-filter.js';
import { default as ic } from './image/image-container.js';
import { default as Query } from '/media/js/modules/request/query.js';

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
    ic.clear();
    // make a request
    // @todo implement a page
    var limit = new Query(isl.getDataName(), isl.getValue());
    var orderBy = new Query(iso.getDataName(), iso.getValue());
    var orderByDirection = new Query(isod.getDataName(), isod.getValue());

    var images = [
        {
            'image_id': 85,
            'image_name': 'some name',
            'image_author_name': 'Some author name'
        }
    ];
    // fill rows;
    ic.fill(images);
});
