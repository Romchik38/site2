'use strict';

import { default as Component } from '/media/js/modules/components/component.js';
import { ee as imageEe } from './image.js';

var bc = Component.fromClass('index-button-create');

var reportSuccess = (name) => {
    if (name === 'image') {
        bc.show();
    }
};

var reportError = (name) => {
    if (name === 'image') {
        bc.hide();
    }
};

imageEe.on('error', reportError);
imageEe.on('success', reportSuccess);