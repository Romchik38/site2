'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

export class Map extends Component {
    render() {
        var mapContainer = this._createElement(
            'iframe', 
            { 
                'src': 'https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d4659.571479832518!2d30.525446258527236!3d50.44763831105447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1z0LrQuNC10LIg0L_RgNC40LrQu9Cw0LTQvdCwIDEw!5e0!3m2!1suk!2sua!4v1759758313288!5m2!1suk!2sua',
                'width': '100%',
                'height': '450',
                'style': 'border:0;',
                'allowfullscreen': '',
                'loading': 'lazy',
                'referrerpolicy': 'no-referrer-when-downgrade'
            }
        );

        this.node.appendChild(mapContainer);
    }
};

export default Map;