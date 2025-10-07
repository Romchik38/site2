'use strict';

import { default as Map } from './map.js';
import { default as Form } from '/media/js/modules/components/form.js';

var started = false;
var m = Map.fromClass('api-contacts-map');
var f = Form.fromClass('api-contacts-form');

document.addEventListener('scroll', ()=>{
    try {
        if (started === false) {
            started = true;
            m.render();
            f.appendByClass('api-contacts-form-container');
            f.show();
        }
    } catch (e) {
        console.error('Contacts map does not work correctly');
        console.error(e);
    }
});

