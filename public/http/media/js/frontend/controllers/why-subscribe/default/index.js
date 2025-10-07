'use strict';

import { default as SubscribeForm } from './subscribeForm.js';

var f = SubscribeForm.fromClass('api-why-subscribe-form');


document.addEventListener('DOMContentLoaded', ()=>{
    try {
        f.render('api-why-subscribe-form-container');
        f.show();
    } catch (e) {
        console.error('Why subscribe does not work correctly');
        console.error(e);
    }
});

