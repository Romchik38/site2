'use strict';

/**
 * Class FormCollection is a part of the Site2 Project https://github.com/Romchik38/site2
 * Please read the license before use https://github.com/Romchik38/site2/blob/main/LICENSE.md
 */

import { default as Form } from '/media/js/modules/components/form.js';
import { default as ComponentCollection } from '/media/js/modules/components/componentCollection.js';

class FormCollection extends ComponentCollection {
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
            components.push(new Form(node));
        }
        return new this(components);
    }

    static fromTag() {
        var nodes = document.getElementsByTagName('from');
        var components = [];
        for (var node of nodes) {
            components.push(new Form(node));
        }
        return new this(components);
    }

    submit() {
        for (var component of this.components) {
            component.submit();
        }
    }
};

export default FormCollection;