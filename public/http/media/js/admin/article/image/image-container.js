'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ImageContainer extends Component {
    constructor(node) {
        super(node);
        this.children = [];
    }
    clear() {
        for (var child of this.children) {       
            this.node.removeChild(child);
        }
        this.children = [];
    }
    fill(images) {
        if (typeof images !== 'object') {
            throw new Error('Param images is invalid');
        }
        // @todo escape attr and text
        for (var i of images) {
            var child = this._createElement(
                'div', 
                {
                    'class': 'row p-2'
                }
            );
            var radioContainer = this._createElement(
                'div', 
                {
                    'class': 'col-1'
                }
            );
            var radio = this._createElement(
                'input', 
                {
                    'type': 'radio',
                    'name': 'image_row',
                    'value': i['image_id']
                }
            );
            var id = this._createElement(
                'div', 
                {
                    'class': 'col-1'
                }, 
                i['image_id']
            );
            var name = this._createElement(
                'div', 
                {
                    'class': 'col'
                }, 
                i['image_name']
            );
            var author = this._createElement(
                'div', 
                {
                    'class': 'col'
                }, 
                i['image_author_name']
            );
            radioContainer.appendChild(radio);
            child.appendChild(radioContainer);
            child.appendChild(id);
            child.appendChild(name);
            child.appendChild(author);
            this.node.appendChild(child);
            this.children.push(child);
        }
    }
}

var imageContainer = ImageContainer.fromClass('image-container');

export default imageContainer;