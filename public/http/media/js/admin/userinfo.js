'use strict';

import { default as target } from '/media/js/modules/urlbuilder/dynamicTarget.js';
import { default as urlbuilder } from '/media/js/modules/urlbuilder/urlbuilder.js';

var t = target(currentLanguage);
var u = urlbuilder(t);

var result = u(['root', 'hello']);

addEventListener("DOMContentLoaded", (event) => {
    var loggedinElems = document.getElementsByClassName('header-user-loggedin');
    var usernameElems = document.getElementsByClassName('user-name-field');

    if (loggedinElems.length === 0 || usernameElems.length === 0) {
        console.error('userinfo script started, but some of the elements not found on the page, pls check it: [header-user-loggedin, user-name-field]');
        return;
    }

    var url = u (['root', 'admin', 'api', 'userinfo']);
    const request = new Request(url, {
        method: "POST"
      });

    fetch(request).then(function (response) {

        if (response.status === 200) {
            response.json().then((data) => {
                console.log({ data })
                // var dataKeys = Object.keys(data);
                // if (dataKeys.indexOf('status') > -1) {
                //     if(data['status'] === 'success') {
                //         var result = data['result'];
                //         var resultKeys = Object.keys(result);
                //         if (resultKeys.indexOf('username') > -1) {
                //             var username = result['username'];
                //             for (var elem of usernameElems) {
                //                 elem.innerText = username;
                //             }
                //             for (var elem of notloggedinElems) {
                //                 elem.style.display = 'none';
                //             }
                //             for (var elem of loggedinElems) {
                //                 elem.style.display = 'flex';
                //             }
                //         }
                //     }
                // } else {
                //     // Unauthorized reques
                // }   
            }, (err) => {
                console.log(err);
            })
        }
    }, function (error) {
        console.log(error);
    });
});