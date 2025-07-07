'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class Data extends Component {
    getDataId() {
        return this.node.dataset.id;
    }
    getDataIdField() {
        return this.node.dataset.idfield;
    }
    getTokenField() {
        return this.node.dataset.tokenfield;
    }
    getToken() {
        return this.node.dataset.token;
    }          
};

export default Data;
