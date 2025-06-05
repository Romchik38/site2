'use strict';

import { default as Component } from '/media/js/modules/components/component.js';
import { default as ButtonClear } from './common/button-clear.js';
import { default as Page } from './common/page.js';
import { default as SelectLimit } from './common/select-limit.js';
import { default as SelectOrderBy } from './common/select-orderby.js';
import { default as SelectOrderByDirection } from './common/select-orderbydirection.js';
import { default as ImageContainer } from './image/image-container.js';
import { default as FilterRequest } from './common/filter-request.js';

// @todo replace with new
//import { default as filter } from './image/make-request.js';
import { default as filter } from './common/make-request.js';

var bc = Component.fromClass('image-button-change');
var bcl = ButtonClear.fromClass('image-button-clear');
var bf = Component.fromClass('image-button-filter');
var m = Component.fromClass('image-message');
var me = Component.fromClass('image-message-error');
var p = Page.fromClass('image-page');
var sl = SelectLimit.fromClass('image-select-limit');
var so = SelectOrderBy.fromClass('image-select-orderby');
var sod = SelectOrderByDirection.fromClass('image-select-orderbydirection');
var f = Component.fromClass('image-filter');
var c = ImageContainer.fromClass('image-container');

/* Image Filter App for admin article page. 
   Components:
image-button-change             bc             show/hide filter block
image-button-clear              bcl            discard selected image
image-message                   m              display message to user
image-message-error             me             display error message
image-filter                    mageFilter     filter block
image-container                 c              images
image-page                      p              page input filed
image-select-limit              sl             limit select
image-select-orderby            so             order by select
image-select-orderbydirection   sod            order direction select
image-button-filter             bf             filter images

*/

// Show filter
var isFilterOpen = false;
bc.onEvent('click', () => {
    if (isFilterOpen === false) {
        f.show();
        bc.text('Hide');
        isFilterOpen = true;
    } else {
        f.hide();
        bc.text('Change');
        isFilterOpen = false;
    }
});

// Make filter
bf.onEvent('click', () => {
    c.clear();
    m.text('');
    m.hide();
    me.hide();
    bcl.hide();

    var filterRequest = new FilterRequest(
        sl.getDataName(),
        sl.getValue(),
        so.getDataName(),
        so.getValue(),
        sod.getDataName(),
        sod.getValue(),
        p.getDataName(),
        p.getValue()
    );

    var path = ['root', 'admin', 'image'];
    filter(path, filterRequest, (err, data) => {
        if (err !== null) {       
            me.text('Request error. See more details in the console')
            me.show();
            console.log(err);                    
        } else {
            var images = data['image_list'];          
            if (typeof images !== 'object') {
                me.text('Data not resieved. See more details in the console');
                me.show();
                console.error('Field image_list not found in recieved data');
                console.log({ data });
            } else {
                c.fill(images);
            }
        }
    });
});

// Display message on image select
c.onSelect = function (e) {
    var imageId = e.target.value;
    
    m.text(`Change article image to selected with id ${imageId}`);
    m.show();
    bcl.show();
    bcl.discard = () => {
        e.target.checked = false;
    }
};

// Discard selected row
bcl.onEvent('click', () => {
    bcl.discard();
    bcl.hide();
    m.text('');
    m.hide();
});

