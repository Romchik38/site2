'use strict';

import { default as Component } from '/media/js/modules/components/component.js';
import { default as ButtonClear } from './common/button-clear.js';
import { default as Page } from './common/page.js';
import { default as SelectLimit } from './common/select-limit.js';
import { default as SelectOrderBy } from './common/select-orderby.js';
import { default as SelectOrderByDirection } from './common/select-orderbydirection.js';
import { default as AudioContainer } from './audio/audio-container.js';
import { default as filter } from './common/make-request.js';
import { default as FilterRequest } from './common/filter-request.js';

var bc = Component.fromClass('audio-button-change');
var bcl = ButtonClear.fromClass('audio-button-clear');
var bf = Component.fromClass('audio-button-filter');
var m = Component.fromClass('audio-message');
var me = Component.fromClass('audio-message-error');
var p = Page.fromClass('audio-page');
var sl = SelectLimit.fromClass('audio-select-limit');
var so = SelectOrderBy.fromClass('audio-select-orderby');
var sod = SelectOrderByDirection.fromClass('audio-select-orderbydirection');
var f = Component.fromClass('audio-filter');
var c = AudioContainer.fromClass('audio-container');

/* Audio Filter App for admin article page. 
   Components:
audio-button-change             bc              show/hide filter block
audio-button-clear              bcl             discard selected audio
audio-button-filter             bf              filter audio tracks
audio-message                   m               display message to user
audio-message-error             me              display error message
audio-page                      p               page input filed
audio-select-limit              sl              limit select
audio-select-orderby            so              order by select
audio-select-orderbydirection   sod             order direction select
audio-filter                    f               filter block
audio-container                 c               rows container
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

    var path = ['root', 'admin', 'audio'];
    filter(path, filterRequest, (err, data) => {
        if (err !== null) {       
            me.text('Request error. See more details in the console')
            me.show();
            console.log(err);                    
        } else {
            var entities = data['audio_list'];          
            if (typeof entities !== 'object') {
                me.text('Data not resieved. See more details in the console');
                me.show();
                console.error('Field audio_list not found in recieved data');
                console.log({ data });
            } else {
                c.fill(entities);
            }
        }
    });
});

// Display message on row select
c.onSelect = function (e) {
    var audioId = e.target.value;
    
    m.text(`Change article audio to selected with id ${audioId}`);
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

