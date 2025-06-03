'use strict';

import { default as target } from '/media/js/modules/urlbuilder/dynamicTarget.js';
import { default as urlbuilder } from '/media/js/modules/urlbuilder/urlbuilder.js';

var t = target(currentLanguage);
var u = urlbuilder(t);

var url = u (['root', 'admin', 'image']);

export default function(queries) {
    
};
