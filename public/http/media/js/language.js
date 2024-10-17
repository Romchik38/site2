'use strict';

/** 
 * This file is loaded on all pages.
 * It is responsible to redirect user when other language was selected
 */

(() => {

    addEventListener("DOMContentLoaded", (event) => {

        var className = 'language';
        var elems = document.getElementsByClassName(className);

        if (elems.length === 0) {
            console.error('userinfo script started, but some of the elements not found on the page, pls check it: [header-user-notloggedin, header-user-loggedin, user-name-field]');
            return;
        }
        
        for (var i = 0; i < elems.length; i++) {
            var elem = elems[i];
            elem.addEventListener('click', (e) => {
                if (e.target.value.length !== 0) {
                    document.location.assign(e.target.value)
                }
            });
        }
        
    });
})();
