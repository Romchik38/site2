'use strict';

import { default as Map } from './map.js';

var started = false;
var m = Map.fromClass('api-contacts-map');

document.addEventListener('scroll', ()=>{
    try {
        if (started === false) {
            started = true;
            m.render();
            
        }
    } catch (e) {
        console.error('Contacts map does not work correctly');
        console.error(e);
    }
});

