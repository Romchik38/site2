'use strict';

import { default as ComponentCollection } from '/media/js/modules/components/componentCollection.js';

class VideoCollection extends ComponentCollection {
    displayPosters() {
        for (var component of this.components) {         
            component.node.poster = component.node.dataset.poster;
        }
    }
}

export default VideoCollection;