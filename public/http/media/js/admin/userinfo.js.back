'use strict';

/** 
 * This file is loaded on all pages.
 * It is responsible to render  username | Logout
 */

(() => {
    function escapeHTML(str) {

        return str.replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    addEventListener("DOMContentLoaded", (event) => {
        var loggedinElems = document.getElementsByClassName('header-user-loggedin');
        var usernameElems = document.getElementsByClassName('user-name-field');

        if (loggedinElems.length === 0 || usernameElems.length === 0) {
            console.error('userinfo script started, but some of the elements not found on the page, pls check it: [header-user-loggedin, user-name-field]');
            return;
        }

        var url = window.location.origin + '/uk/admin/api/userinfo';
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
})();