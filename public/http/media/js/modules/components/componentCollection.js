'use strict';

/**
 * Class ComponentCollection is a part of the Site2 Project https://github.com/Romchik38/site2
 * Please read the license before use https://github.com/Romchik38/site2/blob/main/LICENSE.md
 */

import { default as Component } from '/media/js/modules/components/component.js';

class ComponentCollection {
    constructor(components) {
        for (var component of components) {
            if (! component instanceof Component ) {
                throw new Error('Param components is invalid. Expected Component');
            }
        }
        this.components = components;
    }

    static fromClass(className) {
        if (typeof className !== 'string') {
            throw new Error('Param className is invalid');
        }
        var nodes = document.getElementsByClassName(className);
        if (! nodes instanceof HTMLCollection ) {
            throw new Error('Param className is invalid. Expected HTMLCollection');
        }
        var components = [];
        for (var node of nodes) {
            components.push(new Component(node));
        }
        return new this(components);
    }

    static fromTag(tagName) {
        if (typeof tagName !== 'string') {
            throw new Error('Param tagName is invalid');
        }
        var nodes = document.getElementsByTagName(tagName);
        if (! nodes instanceof HTMLCollection ) {
            throw new Error('Param tagName is invalid. Expected HTMLCollection');
        }
        var components = [];
        for (var node of nodes) {
            components.push(new Component(node));
        }
        return new this(components);
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