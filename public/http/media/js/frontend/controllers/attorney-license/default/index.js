'use strict';

import { default as Form } from '/media/js/modules/components/form.js';

var f = Form.fromClass('api-attorney-license-form');


document.addEventListener('DOMContentLoaded', ()=>{
    try {
        f.appendByClass('api-attorney-license-form-container');
        f.show();
    } catch (e) {
        console.error('Training does not work correctly');
        console.error(e);
    }
});

