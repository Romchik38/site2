'use strict';

import { default as target } from '/media/js/modules/urlbuilder/dynamicTarget.js';
import { default as urlbuilder } from '/media/js/modules/urlbuilder/urlbuilder.js';

var t = target(currentLanguage);
var u = urlbuilder(t);

addEventListener("DOMContentLoaded", (event) => {
    var notloggedinElems = document.getElementsByClassName('header-user-notloggedin');
    var loggedinElems = document.getElementsByClassName('header-user-loggedin');
    var usernameElems = document.getElementsByClassName('user-name-field');

    if (notloggedinElems.length === 0 || loggedinElems.length === 0 || usernameElems.length === 0) {
        console.error('userinfo script started, but some of the elements not found on the page, pls check it: [header-user-loggedin, user-name-field, header-user-notloggedin]');
        return;
    }

    var url = u (['root', 'api', 'userinfo']);
    const request = new Request(url, {
        method: "POST"
      });

    fetch(request).then(function (response) {

        if (response.status === 200) {
            response.json().then((data) => {
                var dataKeys = Object.keys(data);
                if (dataKeys.indexOf('status') > -1) {
                    if(data['status'] === 'success') {
                        // 
                        var result = data['result'];
                        if (result !== undefined && result !== '') {

                            for (var elem of usernameElems) {
                                elem.innerText = result;
                            }

                            for (var elem of loggedinElems) {
                                elem.style.display = 'flex';
                            }
                        } else {
                            // show not loggen in
                            for (var elem of notloggedinElems) {
                                elem.style.display = 'flex';
                            }
                        }
                    } else {
                        // show not loggen in
                        for (var elem of notloggedinElems) {
                            elem.style.display = 'flex';
                        }
                    }

                } else {
                    // Unauthorized reques
                }   
            }, (err) => {
                console.log(err);
            })
        }
    }, function (error) {
        console.log(error);
    });
});