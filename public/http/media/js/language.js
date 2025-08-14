'use strict';

import { default as ComponentCollection } from '/media/js/modules/components/componentCollection.js';

/** 
 * This file is loaded on all pages frontend and admin
 * It is responsible to redirect user when a language was selected
 */

/** select language collection */
var slc = ComponentCollection.fromClass('language');

var redirectCallback = (e) => {
    window.location.href = e.target.value;
};

(() => {

    addEventListener("DOMContentLoaded", () => {
        slc.onEvent('change', redirectCallback);
        slc.enable();
    });
})();
