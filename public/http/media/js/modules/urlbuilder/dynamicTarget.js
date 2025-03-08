'use strict';

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