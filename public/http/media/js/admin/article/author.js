'use strict';

import { default as Component } from '/media/js/modules/components/component.js';
import { default as ButtonClear } from './common/button-clear.js';
import { default as Page } from './common/page.js';
import { default as SelectLimit } from './common/select-limit.js';
import { default as SelectOrderBy } from './common/select-orderby.js';
import { default as SelectOrderByDirection } from './common/select-orderbydirection.js';
import { default as AuthorContainer } from './author/author-container.js';
import { default as filter } from './common/make-request.js';
import { default as FilterRequest } from './common/filter-request.js';

var bc = Component.fromClass('author-button-change');
var bcl = ButtonClear.fromClass('author-button-clear');
var bf = Component.fromClass('author-button-filter');
var m = Component.fromClass('author-message');
var me = Component.fromClass('author-message-error');
var p = Page.fromClass('author-page');
var sl = SelectLimit.fromClass('author-select-limit');
var so = SelectOrderBy.fromClass('author-select-orderby');
var sod = SelectOrderByDirection.fromClass('author-select-orderbydirection');
var f = Component.fromClass('author-filter');
var c = AuthorContainer.fromClass('author-container');

/* Author Filter App for admin article page. 
   Components:
author-button-change             bc              show/hide filter block
author-button-clear              bcl             discard selected author
author-button-filter             bf              filter authors
author-message                   m               display message to user
author-message-error             me              display error message
author-page                      p               page input filed
author-select-limit              sl              limit select
author-select-orderby            so              order by select
author-select-orderbydirection   sod             order direction select
author-filter                    f               filter block
author-container                 c               rows container
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

// Display message on row select
c.onSelect = function (e) {
    var authorId = e.target.value;
    
    m.text(`Change article author to selected with id ${authorId}`);
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

