'use strict';

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

    show(type) {
        for (var node of this.components) {
            node.show(type);
        }
    }

    /** test it before usage */
    text(newText) {       
        for (var node of this.components) {
            node.text(newText);
        }
    }
};

export default ComponentCollection;