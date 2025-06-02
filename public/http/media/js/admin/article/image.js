'use strict';

import { default as ibc } from './classes/image-button-change.js';
import imageFilter from './classes/image-filter.js';

/* Image Filter App for admin article page

image-button-change             ibc             show/hide filter block

image-init                                      holds image id if exist
image-message                                   display message to user
image-error-message                             display error message

image-filter                    imageFilter     filter block
image-filters                                   filter select, button
image-container                                 images
image-pages                                     page buttons

image-select-limit                              limit select
image-select-orderby                            order by select
image-select-orderbydirection                   order direction select
image-button-filter                             filter images

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
