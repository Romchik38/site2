'use strict';

import { default as Form } from '/media/js/frontend/articleviews/form.js';

try {
    var form = Form.fromClass('api-articleviews-form');
    document.addEventListener('DOMContentLoaded', ()=>{
        var res = form.submit();
        console.log({ res });
    });
} catch (e) {
    console.error('Article views does not work correctly');
    console.error(e);
}