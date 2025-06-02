'use strict';

export default class Component {
    
    constructor(node) {
        // Node
        if (! node instanceof HTMLElement) {
            throw new Error('Wrong node type. Expected HtmlElement');
        } else {
            this.node = node;
        }
        // user functions
        this.fnHide = null;
        this.fnShow = null;

        // events
        this.events = ['click'];
        this.registeredEvents = [];
    }

    onEvent(name, callback) {
        if (typeof name !== 'string') {
            throw new Error('Param event name is invalid');
        } else {
            if (!this.events.find((v) => v === name)) {
                throw new Error('Param event name has non expected value: ' + name);
            }
        }
        if (typeof callback !== 'function') {
            throw new Error('Param event callback is invalid');
        }

        var existingEvents = this.registeredEvents[name] || [];
        if (existingEvents.length === 0) {
            this.node.addEventListener(name, (...params) => {
                this._event(name, ...params);
            });
        }
        existingEvents.push(callback);
        this.registeredEvents[name] = existingEvents;
        return this;
    }
    
    hide() {
        if (this.fnHide !== null) {
            this.fnHide(this.node);
        } else {
            this.node.style.display = 'none';
        }
    }

    show(type) {
        if (this.fnShow !== null) {
            this.fnShow(this.node);
        } else {
            if (typeof type === 'string') {
                this.node.style.display = type;
            } else {
                this.node.style.display = '';
            }
        }
    }

    text(newText) {
        if (typeof newText !== 'string') {
            throw new Error('Param text is invalid');
        }
        this.node.innerText = newText;
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

    getValue() {
        return this.node.value;
    }

    setValue(val) {
        this.node.value = val;
    }

    static fromClass(className) {
        if (typeof className !== 'string') {
            throw new Error('Param className is invalid');
        }
        var collection = document.getElementsByClassName(className);
        var len = collection.length;
        if ( len === 0) {
            throw new Error(`element ${className} not found`);
        } else if (len > 1) {
            throw new Error(`element ${className} is more than one`);
        }
        var node = collection[0];
        return new this(node);
    }

    // Run registered events
    _event(name, ...params) {
        var existingEvents = this.registeredEvents[name] || [];
        
        if (existingEvents.length === 0) {
            throw new Error(`Event with name ${name} is not registered`);
        }
        for (var callback of existingEvents) {
            callback(...params);
        }
    }
};