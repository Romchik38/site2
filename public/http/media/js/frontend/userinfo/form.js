'use strict';

import { default as Form } from '/media/js/modules/components/form.js';

class FormLogout extends Form {
    markAsVisited() {
        this.node.style['text-decoration'] = 'underline';
    }
};

export default FormLogout;