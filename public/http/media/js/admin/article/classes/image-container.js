'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ImageContainer extends Component {
    constructor(node) {
        super(node);
        this.children = [];
    }
    clear() {

    }
    fill() {
        // @todo escape attr and text
        var child = this._createElement (
            'div', 
            {
                'hello': 'world'
            }, 
            'some text'
        );
        this.node.appendChild(child);
        this.children.push(child);
    }
}

var imageContainer = ImageContainer.fromClass('image-container');

export default imageContainer;