'use strict';

import { default as ComponentCollection } from './videoCollection.js';

var videos = ComponentCollection.fromTag('video');

document.addEventListener('DOMContentLoaded', ()=>{
    try {
        videos.displayPosters();
    } catch (e) {
        console.error('Video collection does not work correctly');
        console.error(e);
    }
});
