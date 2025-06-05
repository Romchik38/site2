'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class Page extends Component {
    getDataName() {
        return this.node.dataset.name;
    }
};

export default Page;
