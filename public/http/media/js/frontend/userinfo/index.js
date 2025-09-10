'use strict';

import { default as Component } from '/media/js/modules/components/component.js';
import { default as ComponentCollection } from '/media/js/modules/components/componentCollection.js';
import { default as makeRequest } from '/media/js/modules/utils/make-request/make-post-request.js';
import { default as RequestData } from '/media/js/modules/utils/make-request/request-data.js';
import { VisitorData as vd } from '/media/js/frontend/visitor/visitorData.js';
import { default as FormLogout } from './form.js';

/**
 * @var flo - Form logout
 */

var notloggedinElems = ComponentCollection.fromClass('header-user-notloggedin');
var loggedinElem = Component.fromClass('header-user-loggedin');
var usernameElem = Component.fromClass('user-name-field');
var ab = Component.fromClass('api-userinfo-accept-btn');
var flo = FormLogout.fromClass('header-user-form-logout');

flo.onEvent('click', ()=> {
    flo.markAsVisited();
    flo.submit();
});

var path = ['root', 'api', 'userinfo'];

var atm = new bootstrap.Modal('#accept-terms-modal', {
  keyboard: false,
  backdrop: 'static'
})

var proccessUsername = function() {
    var username = vd.getUsername();
    if (username === '') {
        notloggedinElems.show('flex');
    } else {
        usernameElem.text(username);
        loggedinElem.show('flex');
    }
};

var proccessAcceptedTerms = function() {
    var isAccepted = vd.getIsAcceptedTerm();  
    if (isAccepted === '1') {
        return;
    } else if(isAccepted === '0') {
        atm.show();
    } else {
        throw new Error('Visitor isAccepted is invalid');
    }
}

ab.onEvent('click', () => {
    atm.hide();
    var requestData = new RequestData();
    requestData.addData(vd.getCsrfTokenField(), vd.getCsrfToken());
    makeRequest(path, requestData, (err, data) => {
        if (err !== null) {       
            console.log({ 'userinfo': err});
        } else {
            console.log({ 'userinfo': data });
        }
    });                
});

document.addEventListener('DOMContentLoaded', ()=>{
    try {
        try {
            proccessUsername();
            proccessAcceptedTerms();
        } catch (e) {
            console.log({'userinfo': e});
        }
    } catch (e) {
        console.error('Userinfo does not work correctly');
        console.error(e);
    }
});



