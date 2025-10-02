'use strict';

import { default as ComponentCollection } from './videoCollection.js';

var videos = ComponentCollection.fromTag('video');
var started = false;

document.addEventListener('scroll', ()=>{
    try {
        if (started === false) {
            started = true;
            videos.displayPosters();
        }
    } catch (e) {
        console.error('Video collection does not work correctly');
        console.error(e);
    }
});

