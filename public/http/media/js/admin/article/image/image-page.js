'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ImagePage extends Component {
    getDataName() {
        return this.node.dataset.name;
    }
};

var imagePage = ImagePage.fromClass('image-page');

export default imagePage;
