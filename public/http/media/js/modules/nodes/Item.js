'use strict';

export default class Item{
    
    constructor(nodes) {
        this.nodes = [];

        if (!nodes instanceof Array) {
            throw new Error('Param nodes is invalid');
        }    
        if (nodes.length === 0) {
            throw new Error('Param nodes is epmty');
        }
        nodes.forEach(elem => {
            if (! elem instanceof HTMLElement) {
                throw new Error('Wrong node type. Expected Html element');
            } else {
                this.nodes.push(elem);
            }
        });
    }
    
    static fromClass(className) {
        if (typeof className !== 'string') {
            throw new Error('Param className is invalid');
        }
        var collection = document.getElementsByClassName(className);
        if (collection.length === 0) {
            throw new Error(`element ${className} not found on the page`);
        }
    }
};