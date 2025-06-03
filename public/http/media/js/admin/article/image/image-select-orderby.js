'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ImageSelectOrderBy extends Component {
    getDataName() {
        return this.node.dataset.name;
    }
}

var imageSelectOrderBy = ImageSelectOrderBy.fromClass('image-select-orderby');

export default imageSelectOrderBy;
