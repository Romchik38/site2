'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class Form extends Component {
    submit() {
        return this.node.submit();
    }
};

export default Form;
