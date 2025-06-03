'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ImageSelectOrderByDirection extends Component {
    getDataName() {
        return this.node.dataset.name;
    }
}

var imageSelectOrderByDirection = ImageSelectOrderByDirection.fromClass('image-select-orderbydirection');

export default imageSelectOrderByDirection;
