'use strict';

import { default as Component } from '/media/js/modules/components/component.js';
import { VisitorData } from './visitor.js';

var loggedinElem = Component.fromClass('header-user-loggedin');
var usernameElem = Component.fromClass('user-name-field');
var vd = VisitorData.fromClass('visitor-data');

var proccessUsername = function() {
    var username = vd.getUsername();
    if (username === '') {
        throw new Error('Can not proccess empty username');
    } else {
        usernameElem.text(username);
        loggedinElem.show('flex');
    }
};

document.addEventListener('DOMContentLoaded', ()=>{
    try {
        proccessUsername();
    } catch (e) {
        console.log({'admin userinfo': e});
    }
});



