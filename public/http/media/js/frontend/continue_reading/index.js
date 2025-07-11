'use strict';

import { default as Data } from './data.js';
import { default as RequestData } from '/media/js/modules/utils/make-request/request-data.js';
import { default as makeRequest } from '/media/js/modules/utils/make-request/make-post-request.js';

var path = ['root', 'api', 'article_continue_reading'];

document.addEventListener('DOMContentLoaded', ()=>{
    try {
        var data = Data.fromClass('api-continue-reading-data');
        var requestData = new RequestData();
        requestData.addData(data.getDataIdField(), data.getDataId());
        requestData.addData(data.getTokenField(), data.getToken());

        makeRequest(path, requestData, (err, data) => {
            if (err !== null) {       
                console.log({ 'article-continue-reading': err});
            } else {
                console.log(data);
            }
        });
    } catch (e) {
        console.error('Article continue reading does not work correctly');
        console.error(e);
    }
});