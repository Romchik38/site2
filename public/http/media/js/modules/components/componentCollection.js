'use strict';

/**
 * Class ComponentCollection is a part of the Site2 Project https://github.com/Romchik38/site2
 * Please read the license before use https://github.com/Romchik38/site2/blob/main/LICENSE.md
 */

import { default as Component } from '/media/js/modules/components/component.js';

class ComponentCollection {
    constructor(nodes) {
        if (! nodes instanceof HTMLCollection ) {
            throw new Error('Param nodes is invalid. Expected HTMLCollection');
        }
        this.components = [];
        for (var node of nodes) {
            this.components.push(new Component(node));
        }
        
    }

    static fromClass(className) {
        if (typeof className !== 'string') {
            throw new Error('Param className is invalid');
        }
        return new this(document.getElementsByClassName(className));
    }

    disable() {
        for (var component of this.components) {
            component.disable();
        }
    }

    enable() {
        for (var component of this.components) {           
            component.enable();
        }
    }

    onEvent(name, callback) {
        for (var component of this.components) {
            component.onEvent(name, callback);
        }
    }

    show(type) {
        for (var component of this.components) {
            component.show(type);
        }
    }

    /** test it before usage */
    text(newText) {       
        for (var component of this.components) {
            component.text(newText);
        }
    }
};

export default ComponentCollection;