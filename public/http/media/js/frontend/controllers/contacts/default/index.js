'use strict';

import { default as Map } from './map.js';
import { default as ContactForm } from './contactForm.js';

var started = false;
var m = Map.fromClass('api-contacts-map');
var f = ContactForm.fromClass('api-contacts-form');

document.addEventListener('scroll', ()=>{
    try {
        if (started === false) {
            started = true;
            m.render();
            f.render('api-contacts-form-container');
        }
    } catch (e) {
        console.error('Contacts map does not work correctly');
        console.error(e);
    }
});

