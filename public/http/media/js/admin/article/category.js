'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

var bc = Component.fromClass('category-button-change');
var s = Component.fromClass('category-select');
var h = Component.fromClass('category-hint');

/* Category Components:
    category-button-change              bc              button change
    category-select                     s               select
*/

// Show filter
var isSelectOpen = false;
bc.onEvent('click', () => {
    if (isSelectOpen === false) {
        s.show();
        h.show();
        bc.text('Hide');
        isSelectOpen = true;
    } else {
        s.hide();
        h.hide();
        bc.text('Change');
        isSelectOpen = false;
    }
});
