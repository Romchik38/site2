'use strict';

import { default as Form } from '/media/js/modules/components/form.js';

var f = Form.fromClass('api-commercial-offer-form');


document.addEventListener('DOMContentLoaded', ()=>{
    try {
        f.appendByClass('api-commercial-offer-form-container');
        f.show();
    } catch (e) {
        console.error('Why subscribe does not work correctly');
        console.error(e);
    }
});

