'use strict';

/**
 * The file is a part of the Site2 Project https://github.com/Romchik38/site2
 * Please read the license before use https://github.com/Romchik38/site2/blob/main/LICENSE.md
 */

export default function(target){
    /** 
     * parts    - array of controller names like ['root', 'article']
     * queries  - array of objects { name: 'q1', value: 'v1' }
     * fragment - string without #
     * */
    return function(parts, queries = [], fragment = ''){
        var queryPart = '';
        var queryItems = [];
        for (var query of queries) {
            queryItems.push(`${query.name}=${query.value}`);
        }
        if (queryItems.length > 0) {
            queryPart = '?' + queryItems.join('&');
        }
        if (fragment.length > 0) {
            fragment = '#' + fragment;
        }
        return window.location.origin + target(parts) + queryPart + fragment;
    }
};