'use strict';

import { default as SourceCollection } from '/media/js/modules/components/sourceCollection.js';

document.addEventListener('DOMContentLoaded', ()=>{
    SourceCollection.fromTag().swapSrcset();
});