'use strict';

/**
 * Class ComponentCollection is a part of the Site2 Project https://github.com/Romchik38/site2
 * Please read the license before use https://github.com/Romchik38/site2/blob/main/LICENSE.md
 */

import { default as Form } from '/media/js/modules/components/form.js';
import { default as ComponentCollection } from '/media/js/modules/components/componentCollection.js';

class FormCollection extends ComponentCollection {
    constructor(nodes) {
        super(nodes);
        if (! nodes instanceof HTMLCollection ) {
            throw new Error('Param nodes is invalid. Expected HTMLCollection');
        }
        this.components = [];
        for (var node of nodes) {
            this.components.push(new Form(node));
        }
    }

    submit() {
        for (var component of this.components) {
            component.submit();
        }
    }
};

export default FormCollection;