'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

class VisitorData extends Component {
    getUsername() {
        return this.node.dataset.username;
    }
    getCsrfToken() {
        return this.node.dataset.csrftoken;
    }
    getCsrfTokenField() {
        return this.node.dataset.csrftokenfield;
    }
    getIsAcceptedTerm() {
        return this.node.dataset.isacceptedterm;
    }
};

try {
    var vd = VisitorData.fromClass('visitor-data');
} catch (e) {
    console.error('failed to instantiate a Visitor: ');
    throw Error(e); 
}

export {vd as VisitorData};

