'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ImageSelectLimit extends Component {
    getDataName() {
        return this.node.dataset.name;
    }
}

var imageSelectLimit = ImageSelectLimit.fromClass('image-select-limit');

export default imageSelectLimit;
