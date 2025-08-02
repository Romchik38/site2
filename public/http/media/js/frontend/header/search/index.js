'use strict';

/*
    Components:
        - api-header-search-btn
        - api-header-search-form
        - api-header-search-query
*/

import { default as Component } from '/media/js/modules/components/component.js';
import { default as Form } from '/media/js/modules/components/form.js';

var f = Form.fromClass('api-header-search-form');
var t = Component.fromClass('api-header-search-query');
var b = Component.fromClass('api-header-search-btn');

b.onEvent('click', (e) => {
    e.preventDefault();
    var searchLine = t.getValue();
    if (searchLine === '') {
        return;
    }
    f.submit();
});
