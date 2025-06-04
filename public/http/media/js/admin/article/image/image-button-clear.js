'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ImageButtonClear extends Component {
    constructor(node) {
        super(node);
        this.discard = () => {};
    }
};

var imageButtonClear = ImageButtonClear.fromClass('image-button-clear');

export default imageButtonClear;
