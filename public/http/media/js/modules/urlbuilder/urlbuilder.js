'use strict';

export default function(target){
    // @todo implement fragment
    return function(parts, queries = [], fragment = ''){
        var queryPart = '';
        var queryItems = [];
        for (var query of queries) {
            queryItems.push(`${query.name}=${query.value}`);
        }
        if (queryItems.length > 0) {
            queryPart = '?' + queryItems.join('&');
        }
        return window.location.origin + target(parts) + queryPart;
    }
};