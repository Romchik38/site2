'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class SelectOrderByDirection extends Component {
    getDataName() {
        return this.node.dataset.name;
    }
}

export default SelectOrderByDirection;
