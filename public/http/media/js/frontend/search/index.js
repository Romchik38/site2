'use strict';

/*
    Components:
        - api-search-btn
        - api-search-form
        - api-search-query
*/

import { default as Component } from '/media/js/modules/components/component.js';
import { default as Form } from '/media/js/modules/components/form.js';

var f = Form.fromClass('api-search-form');
var t = Component.fromClass('api-search-query');
var b = Component.fromClass('api-search-btn');

b.onEvent('click', (e) => {
    e.preventDefault();
    var searchLine = t.getValue();
    if (searchLine === '') {
        return;
    }
    f.submit();
});