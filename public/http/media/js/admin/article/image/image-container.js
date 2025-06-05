'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class ImageContainer extends Component {
    constructor(node) {
        super(node);
        this.children = [];
        this.onSelect = null;
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
            var imageId = i['image_id'];
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
                    'value': imageId
                }
            );
            if (typeof this.onSelect === 'function') {
                radio.addEventListener('change', this.onSelect, 1);
            }
            var imgContainer = this._createElement(
                'div', 
                {
                    'class': 'col-2'
                }
            );
            var img = this._createElement(
                'img', 
                {
                    'class': 'img-fluid',
                    'src': `/img.php?id=${imageId}&type=webp&width=200&height=100`
                }
            );            
            var id = this._createElement(
                'div', 
                {
                    'class': 'col-1'
                }, 
                imageId
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
            imgContainer.appendChild(img);
            child.appendChild(imgContainer);
            child.appendChild(id);
            child.appendChild(name);
            child.appendChild(author);
            this.node.appendChild(child);
            this.children.push(child);
        }
    }
}

export default ImageContainer;