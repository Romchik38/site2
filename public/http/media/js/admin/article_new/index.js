'use strict';

import { default as Component } from '/media/js/modules/components/component.js';
import { ee as authorEe } from './author.js';

var bc = Component.fromClass('index-button-create');

var reportSuccess = (name) => {
    if (name === 'author') {
        bc.show();
    }
};

var reportError = (name) => {
    if (name === 'author') {
        bc.hide();
    }
};

authorEe.on('error', reportError);
authorEe.on('success', reportSuccess);