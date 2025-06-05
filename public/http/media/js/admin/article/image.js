'use strict';

import { default as ibc } from './image/image-button-change.js';
import { default as ibcl } from './image/image-button-clear.js';
import { default as ibf } from './image/image-button-filter.js';
import { default as im } from './image/image-message.js';
import { default as ime } from './image/image-message-error.js';
import { default as ip } from './image/image-page.js';
import { default as isl } from './image/image-select-limit.js';
import { default as iso } from './image/image-select-orderby.js';
import { default as isod } from './image/image-select-orderbydirection.js';
import imageFilter from './image/image-filter.js';
import { default as ic } from './image/image-container.js';
import { default as filter } from './image/make-request.js';
import { default as FilterRequest } from './image/filter-request.js';

/* Image Filter App for admin article page. 
   Components:
image-button-change             ibc             show/hide filter block
image-button-clear              ibcl            discard selected image
image-message                   im              display message to user
image-message-error             ime             display error message
image-filter                    imageFilter     filter block
image-container                 ic              images
image-page                      ip              page input filed
image-select-limit              isl             limit select
image-select-orderby            iso             order by select
image-select-orderbydirection   isod            order direction select
image-button-filter             ibf             filter images

*/

// Show filter
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

// Make filter
ibf.onEvent('click', () => {
    ic.clear();
    im.text('');
    im.hide();
    ime.hide();
    ibcl.hide();

    var filterRequest = new FilterRequest(
        isl.getDataName(),
        isl.getValue(),
        iso.getDataName(),
        iso.getValue(),
        isod.getDataName(),
        isod.getValue(),
        ip.getDataName(),
        ip.getValue()
    );

    filter(filterRequest, (err, data) => {
        if (err !== null) {       
            ime.text('Request error. See more details in the console')
            ime.show();
            console.log(err);                    
        } else {
            var images = data['image_list'];          
            if (typeof images !== 'object') {
                ime.text('Data not resieved. See more details in the console');
                ime.show();
                console.error('Field image_list not found in recieved data');
                console.log({ data });
            } else {
                ic.fill(images);
            }
        }
    });
});

// Display message on image select
ic.onSelect = function (e) {
    var imageId = e.target.value;
    
    im.text(`Change article image to selected with id ${imageId}`);
    im.show();
    ibcl.show();
    ibcl.discard = () => {
        e.target.checked = false;
    }
};

// Discard selected row
ibcl.onEvent('click', () => {
    ibcl.discard();
    ibcl.hide();
    im.text('');
    im.hide();
});

