'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class Data extends Component {
    getDataId() {
        return this.node.dataset.id;
    }
    getDataIdField() {
        return this.node.dataset.idfield;
    }
};

export default Data;
