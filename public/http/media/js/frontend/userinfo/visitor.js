'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

export class VisitorData extends Component {
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
