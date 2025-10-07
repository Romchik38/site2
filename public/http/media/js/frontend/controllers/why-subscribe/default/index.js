'use strict';

import { default as Form } from '/media/js/modules/components/form.js';

var f = Form.fromClass('api-why-subscribe-form');


document.addEventListener('DOMContentLoaded', ()=>{
    try {
        f.appendByClass('api-why-subscribe-form-container');
        f.show();
    } catch (e) {
        console.error('Why subscribe does not work correctly');
        console.error(e);
    }
});

