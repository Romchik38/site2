'use strict';

/**
 * The file is a part of the Site2 Project https://github.com/Romchik38/site2
 * Please read the license before use https://github.com/Romchik38/site2/blob/main/LICENSE.md
 */

var rootName = 'root';

export default function(dynamicRoot){
    return function(parts){
        if(parts.length === 0) {
            throw new Error('parts is empty');
        }
        var firstPath = parts[0];
        if (firstPath === rootName) {
            parts[0] = dynamicRoot;
        }
        return '/' + parts.join('/');
    };
};