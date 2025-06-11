'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class AuthorContainer extends Component {
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
    fill(authors) {
        if (typeof authors !== 'object') {
            throw new Error('Param authors is invalid');
        }
        // @todo escape attr and text
        for (var item of authors) {
            var authorId = item['author_id'];
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
                    'name': 'author_row',
                    'value': authorId
                }
            );
            if (typeof this.onSelect === 'function') {
                radio.addEventListener('change', this.onSelect, 1);
            }
            var id = this._createElement(
                'div', 
                {
                    'class': 'col-1'
                }, 
                authorId
            );
            var active = item['author_active'];
            if (active === undefined) {
                throw new Error('Param article author active is invalid');
            }
            var classActive = '';
            if (active === true) {
                classActive = 'text-success';
                active = 'active';
            } else {
                classActive = 'text-danger';
                active = 'not active';
            } 
            var activeChild = this._createElement(
                'div', 
                {
                    'class': `col ${classActive}`
                }, 
                active
            ); 
            var name = this._createElement(
                'div', 
                {
                    'class': 'col'
                }, 
                item['author_name']
            );
            radioContainer.appendChild(radio);
            child.appendChild(radioContainer);
            child.appendChild(id);
            child.appendChild(activeChild);
            child.appendChild(name);
            this.node.appendChild(child);
            this.children.push(child);
        }
    }
}

export default AuthorContainer;