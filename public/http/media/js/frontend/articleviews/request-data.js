'use strict';

export default class RequestData {
    constructor(
        idField,
        id,
        tokenField,
        token
    ) {
        this.idField = this._checkParm(idField);
        this.id = this._checkParm(id);
        this.tokenField = this._checkParm(tokenField);
        this.token = this._checkParm(token);
    }

    _checkParm(param) {
        if(typeof param !== 'string' || param === '') {
            throw new Error('Param filter request is invalid');
        }
        return param;
    }
}