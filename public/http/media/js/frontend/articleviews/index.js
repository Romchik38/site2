'use strict';

import { default as Data } from './data.js';
import { default as RequestData } from './request-data.js';
import { default as makeRequest } from './make-request.js';
import { VisitorData as vd } from '/media/js/frontend/visitor/visitorData.js';

var path = ['root', 'api', 'articleviews'];

document.addEventListener('DOMContentLoaded', ()=>{
    try {
        var data = Data.fromClass('api-articleviews-data');
        var requestData = new RequestData(
            data.getDataIdField(),
            data.getDataId(),
            vd.getCsrfTokenField(),
            vd.getCsrfToken()
        );

        makeRequest(path, requestData, (err, data) => {
            if (err !== null) {       
                console.log(err);
            } else {
                console.log({ 'article-views-api-response': data});
            }
        });
    } catch (e) {
        console.error('Article views does not work correctly');
        console.error(e);
    }
});