'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ComponentCollection {
    constructor(nodes) {
        if (! nodes instanceof HTMLCollection ) {
            throw new Error('Param nodes is invalid. Expected HTMLCollection');
        }
        this.nodes = [];
        for (var node of nodes) {
            this.nodes.push(new Component(node));
        }
        
    }

    static fromClass(className) {
        if (typeof className !== 'string') {
            throw new Error('Param className is invalid');
        }
        return new this(document.getElementsByClassName(className));
    }

    start() {
        var first = this.nodes[0];
        first.show();
    }
};

export default ComponentCollection;