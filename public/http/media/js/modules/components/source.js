'use strict';

/**
 * Class Source is a part of the Site2 Project https://github.com/Romchik38/site2
 * Please read the license before use https://github.com/Romchik38/site2/blob/main/LICENSE.md
 */

import { default as Component } from '/media/js/modules/components/component.js';

class Source extends Component {
    swapSrcset() {
        var dataSrcset = this.node.dataset.srcset;
        if (
            typeof dataSrcset === 'string' & 
            dataSrcset !== ''
            
        ) {
            this.node.srcset = dataSrcset;
        }
    }
};

export default Source;
