'use strict';

export default class Item{
    
    constructor(nodes) {
        // Nodes
        this.nodes = [];
        if (!nodes instanceof Array) {
            throw new Error('Param nodes is invalid');
        }    
        if (nodes.length === 0) {
            throw new Error('Param nodes is epmty');
        }
        for (var item of nodes) {
            if (! item instanceof HTMLElement) {
                throw new Error('Wrong node type. Expected Html element');
            } else {
                this.nodes.push(item);
            }
        }
        // user functions
        this.fnHide = null;
        this.fnShow = null;
    }
    
    hide() {
        for (var node of this.nodes) {
            if (this.fnHide !== null) {
                this.fnHide(node);
            } else {
                node.style.display = 'none';
            }
        }
    }

    show() {
        for (var node of this.nodes) {
            if (this.fnShow !== null) {
                this.fnShow(node);
            } else {
                node.style.display = '';
            }
        }
    }

    onHide(callback) {      
        if  (typeof callback === 'function') {
            this.fnHide = callback;
            return this;
        } else {
            throw new Error('Param hide is invalid');
        }
    }

    onShow(callback) {      
        if  (typeof callback === 'function') {
            this.fnShow = callback;
            return this;
        } else {
            throw new Error('Param show is invalid');
        }
    }

    static fromClass(className) {
        if (typeof className !== 'string') {
            throw new Error('Param className is invalid');
        }
        var collection = document.getElementsByClassName(className);
        if (collection.length === 0) {
            throw new Error(`element ${className} not found on the page`);
        }
        return new Item(collection);
    }
};