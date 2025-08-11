'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class VisitorData extends Component {
    getUsername() {
        return this.node.dataset.username;
    }
    getCsrfToken() {
        return this.node.dataset.csrftoken;
    }
    getCsrfTokenField() {
        return this.node.dataset.csrftokenfield;
    }
};

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



