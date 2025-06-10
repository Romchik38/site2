'use strict';

import { default as Component } from '/media/js/modules/components/component.js';
import { default as Page } from './common/page.js';
import { default as SelectLimit } from './common/select-limit.js';
import { default as SelectOrderBy } from './common/select-orderby.js';
import { default as SelectOrderByDirection } from './common/select-orderbydirection.js';
import { default as AuthorContainer } from './author/author-container.js';
import { default as filter } from './common/make-request.js';
import { default as FilterRequest } from './common/filter-request.js';

var bf = Component.fromClass('author-button-filter');
var me = Component.fromClass('author-message-error');
var p = Page.fromClass('author-page');
var sl = SelectLimit.fromClass('author-select-limit');
var so = SelectOrderBy.fromClass('author-select-orderby');
var sod = SelectOrderByDirection.fromClass('author-select-orderbydirection');
var c = AuthorContainer.fromClass('author-container');

/* Author Filter App for admin article page. 
   Components:
author-button-filter             bf              filter authors
author-message                   m               display message to user
author-message-error             me              display error message
author-page                      p               page input filed
author-select-limit              sl              limit select
author-select-orderby            so              order by select
author-select-orderbydirection   sod             order direction select
author-container                 c               rows container
*/

// Make filter
bf.onEvent('click', () => {
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

    var path = ['root', 'admin', 'author'];
    filter(path, filterRequest, (err, data) => {
        if (err !== null) {       
            me.text('Request error. See more details in the console')
            me.show();
            console.log(err);                    
        } else {
            var entities = data['author_list'];          
            if (typeof entities !== 'object') {
                me.text('Data not resieved. See more details in the console');
                me.show();
                console.error('Field author_list not found in recieved data');
                console.log({ data });
            } else {
                c.fill(entities);
            }
        }
    });
});
