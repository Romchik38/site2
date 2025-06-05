'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ButtonClear extends Component {
    constructor(node) {
        super(node);
        this.discard = () => {};
    }
};

export default ButtonClear;
