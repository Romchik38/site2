'use strict';

import { default as Item } from '/media/js/modules/nodes/Item.js';

/* Image Filter App for admin article page

image-button-change (ibc)       show/hide filter block

image-init                      holds image id if exist
image-message                   display message to user
image-error-message             display error message

image-filter                    filter block
image-filters                   filter select, button
image-container                 images
image-pages                     page buttons

image-select-limit              limit select
image-select-orderby            order by select
image-select-orderbydirection   order direction select
image-button-filter             filter images

*/

var ibc = Item.fromClass('image-button-change');
