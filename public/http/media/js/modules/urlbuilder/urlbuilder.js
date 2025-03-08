'use strict';

export default function(target){
    return function(parts){
        return window.location.origin + target(parts);
    }
};