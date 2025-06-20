'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class AudioContainer extends Component {
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
    fill(audios) {
        if (typeof audios !== 'object') {
            throw new Error('Param audios is invalid');
        }
        for (var item of audios) {
            var audioId = item['audio_id'];
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
                    'name': 'audio_row',
                    'value': audioId
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
                audioId
            );
            var name = this._createElement(
                'div', 
                {
                    'class': 'col'
                }, 
                item['audio_name']
            );
            var active = item['audio_active'];
            if (active === undefined) {
                throw new Error('Param article audio active is invalid');
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
            radioContainer.appendChild(radio);
            child.appendChild(radioContainer);
            child.appendChild(id);
            child.appendChild(name);
            child.appendChild(activeChild);
            this.node.appendChild(child);
            this.children.push(child);
        }
    }
}

export default AudioContainer;