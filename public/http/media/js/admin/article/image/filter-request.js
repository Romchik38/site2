'use strict';

export default class FilterRequest {
    constructor(
        limitField,
        limitValue,
        orderByField,
        orderByValue,
        orderByDirectionField,
        orderByDirectionValue
    ) {
        this.limitField = this._checkParm(limitField);
        this.limitValue = this._checkParm(limitValue);
        this.orderByField = this._checkParm(orderByField);
        this.orderByValue = this._checkParm(orderByValue);
        this.orderByDirectionField = this._checkParm(orderByDirectionField);
        this.orderByDirectionValue = this._checkParm(orderByDirectionValue);
    }

    _checkParm(param) {
        if(typeof param !== 'string' || param === '') {
            throw new Error('Param filter request is invalid');
        }
        return param;
    }
}