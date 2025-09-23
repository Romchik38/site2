'use strict';

import { default as FormCollection } from '/media/js/modules/components/formCollection.js';


class FormCollectionLogout extends FormCollection {
    markAsVisited() {
        for (var component of this.components) {
            component.node.style['text-decoration'] = 'underline';
        }
    }
};

export default FormCollectionLogout;