'use strict';

import { default as EE } from '/media/js/modules/utils/eventEmitter.js';
import { default as Component } from '/media/js/modules/components/component.js';
import { default as Page } from './common/page.js';
import { default as SelectLimit } from './common/select-limit.js';
import { default as SelectOrderBy } from './common/select-orderby.js';
import { default as SelectOrderByDirection } from './common/select-orderbydirection.js';
import { default as ImageContainer } from './image/image-container.js';
import { default as filter } from './common/make-request.js';
import { default as FilterRequest } from './common/filter-request.js';

var ee = new EE();
var bf = Component.fromClass('image-button-filter');
var me = Component.fromClass('image-message-error');
var p = Page.fromClass('image-page');
var sl = SelectLimit.fromClass('image-select-limit');
var so = SelectOrderBy.fromClass('image-select-orderby');
var sod = SelectOrderByDirection.fromClass('image-select-orderbydirection');
var c = ImageContainer.fromClass('image-container');

/* image Filter App for admin article page. 
   Components:
image-button-filter             bf              filter images
image-message                   m               display message to user
image-message-error             me              display error message
image-page                      p               page input filed
image-select-limit              sl              limit select
image-select-orderby            so              order by select
image-select-orderbydirection   sod             order direction select
image-container                 c               rows container
*/

// Make filter
var filterFn = () => {
    c.clear();
    me.hide();

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
            ee.emit('error', 'image');
        } else {
            var entities = data['image_list'];          
            if (typeof entities !== 'object') {
                me.text('Data not resieved. See more details in the console');
                me.show();
                console.error('Field image_list not found in recieved data');
                console.log({ data });
                ee.emit('error', 'image');
            } else {
                c.fill(entities);
                ee.emit('success', 'image');
            }
        }
    });
};
bf.onEvent('click', filterFn);
filterFn();
export { ee };
