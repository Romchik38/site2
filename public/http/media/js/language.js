'use strict';

/** 
 * This file is loaded on all pages.
 * It is responsible to redirect user when other language was selected
 */

(() => {

    //alert('before DOMContentLoaded');

    addEventListener("DOMContentLoaded", (event) => {
        //alert('after DOMContentLoaded');
        //temp
        var fon = document.getElementsByClassName('background-secondary')[0];
        // fon.addEventListener('click', (e) => {
        //     console.log(e.type);
        //     //alert(e.type);
        //     fon.style.backgroundColor = '#eee';
        // });
        

        var className = 'language';
        var elems = document.getElementsByClassName(className);

        if (elems.length === 0) {
            console.error('userinfo script started, but some of the elements not found on the page, pls check it: [header-user-notloggedin, header-user-loggedin, user-name-field]');
            return;
        }
        //alert('before for');
        for (var i = 0; i < elems.length; i++) {
            var elem = elems[i];
            
            elem.disabled = false;
            

            elem.addEventListener('click', (e) => {
                
                // alert('click before if');
                if (e.target.value.length !== 0) {
                    fon.style.backgroundColor = '#fff';
                    //alert('inside if');
                    //alert(e.target.value);
                    //window.location.href = e.target.value;
                    //document.location.assign(e.target.value)
                }
            });
        }
        
    });
})();
