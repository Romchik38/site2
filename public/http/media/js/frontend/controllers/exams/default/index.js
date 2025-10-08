'use strict';

import { default as Form } from '/media/js/modules/components/form.js';

var f = Form.fromClass('api-exams-form');


document.addEventListener('DOMContentLoaded', ()=>{
    try {
        f.appendByClass('api-exams-form-container');
        f.show();
    } catch (e) {
        console.error('Exams does not work correctly');
        console.error(e);
    }
});

