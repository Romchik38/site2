'use strict';

/**
 * The file is a part of the Site2 Project https://github.com/Romchik38/site2
 * Please read the license before use https://github.com/Romchik38/site2/blob/main/LICENSE.md
 */

export default class Query {
    constructor(name, value) {
        if (typeof name !== 'string' || name === '') {
            throw new Error('Invalid param query name');
        }
        if (typeof value !== 'string' || value === '') {
            throw new Error('Invalid param query value');
        }
        this.name = name;
        this.value = value;
    }
};