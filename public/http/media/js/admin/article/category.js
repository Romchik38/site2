'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

var bc = Component.fromClass('category-button-change');
var s = Component.fromClass('category-select');

/* Category Components:
    category-button-change              bc              button change
    category-select                     s               select
*/

// Show filter
var isSelectOpen = false;
bc.onEvent('click', () => {
    if (isSelectOpen === false) {
        s.show();
        bc.text('Hide');
        isSelectOpen = true;
    } else {
        s.hide();
        bc.text('Change');
        isSelectOpen = false;
    }
});
