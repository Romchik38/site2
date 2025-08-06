'use strict';

export class VisitorData {
    constructor(data){      
        if (typeof data !== 'object') {
            throw new Error('Param visitor data is invalid');
        }

        this.username = this._checkUsernameParm(data['username']);
        this.isAcceptedTerms = this._checkBoolParm(data['accepted_terms']);
    }

    _checkParm(param) {
        if(typeof param !== 'string' || param === '') {
            console.log({param})
            throw new Error('Param visitor field data is invalid');
        }
        return param;
    }

    _checkUsernameParm(param) {
        if (param === null) {
            return param;
        }
        return this._checkParm(param);
    }

    _checkBoolParm(param) {
        if(typeof param !== 'boolean') {
            throw new Error('Param visitor field data is invalid');
        }
        return param;
    }
}
