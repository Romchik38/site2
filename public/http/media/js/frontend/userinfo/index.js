'use strict';

import { default as Component } from '/media/js/modules/components/component.js';
import { default as ComponentCollection } from '/media/js/modules/components/componentCollection.js';
import { default as makeRequest } from '/media/js/modules/utils/make-request/make-post-request.js';
import { VisitorData } from './visitor.js';

var notloggedinElems = ComponentCollection.fromClass('header-user-notloggedin');
var loggedinElem = Component.fromClass('header-user-loggedin');
var usernameElem = Component.fromClass('user-name-field');

var path = ['root', 'api', 'userinfo'];

var atm = new bootstrap.Modal('#accept-terms-modal', {
  keyboard: false,
  backdrop: 'static'
})

var proccessUsername = function(visitorData) {
    if (visitorData.username !== null) {       
        usernameElem.text(visitorData.username);
        loggedinElem.show('flex');
    } else {
        notloggedinElems.show('flex');
    }
    if (visitorData.isAcceptedTerms === false) {
        // @todo uncomment when ready
        //atm.show();
    }
};

document.addEventListener('DOMContentLoaded', ()=>{
    try {
        makeRequest(path, null, (err, data) => {
            if (err !== null) {       
                console.log({ 'userinfo': err});
            } else {
                try {
                    var visitor = new VisitorData(data);
                    proccessUsername(visitor);
                } catch (e) {
                    console.log({'userinfo': e});
                }
            }
        });
    } catch (e) {
        console.error('Userinfo does not work correctly');
        console.error(e);
    }
});



