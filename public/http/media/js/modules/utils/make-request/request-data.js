'use strict';

export default class RequestData {
    constructor(
    ) {
        this._items = {};
    }

    addData(key, value) {
        if (typeof key !== 'string') {
            throw new Error('Param request data key is invalid');
        }
        if (key === '') {
            throw new Error('Param request data key is empty');
        }
        if (typeof value !== 'string') {
            throw new Error('Param request data value is invalid');
        }
        if (value === '') {
            throw new Error('Param request data value is empty');
        }
        this._items[key] = value;
        return this;
    }

    getData(key) {
        var item = this._items[key];
        if (item === undefined) {
            throw new Error('Param request data key is invalid');
        }
        return item;
    }

    getKeys() {
        var keys = Object.keys(this._items);
        if (keys.length === 0) {
            throw new Error('Param request data is empty');
        }
        return keys;
    }

    _checkParm(param) {
        if(typeof param !== 'string' || param === '') {
            throw new Error('Param filter request is invalid');
        }
        return param;
    }
}