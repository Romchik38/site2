'use strict';

/**
 * Class SourceCollection is a part of the Site2 Project https://github.com/Romchik38/site2
 * Please read the license before use https://github.com/Romchik38/site2/blob/main/LICENSE.md
 */

import { default as ComponentCollection } from './componentCollection.js';
import { default as Source } from './source.js';

class SourceCollection extends ComponentCollection {
    swapSrcset() {
        for (var component of this.components) {         
            var dataSrcset = component.node.dataset.srcset;
            if (
                typeof dataSrcset === 'string' & 
                dataSrcset !== ''
                
            ) {
                component.node.srcset = dataSrcset;
            }
        }
    }

    static fromClass(className) {
        if (typeof className !== 'string') {
            throw new Error('Param className is invalid');
        }
        var nodes = document.getElementsByClassName(className);
        if (! nodes instanceof HTMLCollection ) {
            throw new Error('Param className is invalid. Expected HTMLCollection');
        }
        var components = [];
        for (var node of nodes) {
            components.push(new Source(node));
        }
        return new this(components);
    }

    static fromTag() {
        var nodes = document.getElementsByTagName('source');
        var components = [];
        for (var node of nodes) {
            components.push(new Source(node));
        }
        return new this(components);
    }    
}

export default SourceCollection;