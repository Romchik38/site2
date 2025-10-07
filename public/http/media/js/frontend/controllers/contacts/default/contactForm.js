'use strict';

import { default as Form } from '/media/js/modules/components/form.js';

class ContactForm extends Form {
    render(className) {
        var collection = document.getElementsByClassName(className);
        var len = collection.length;
        if (len === 0) {
            throw new Error(`Form container with class ${className} not found`);
        } else if (len > 1) {
            throw new Error(`element ${className} is more than one`);
        }
        var container = collection[0];
        container.appendChild(this.node);
        this.show();
    }
};

export default ContactForm;
