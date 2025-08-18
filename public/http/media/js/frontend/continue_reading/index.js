'use strict';

import { default as Data } from './data.js';
import { Article } from './article.js';
import { ArticleData } from './article.js';
import { default as RequestData } from '/media/js/modules/utils/make-request/request-data.js';
import { default as makeRequest } from '/media/js/modules/utils/make-request/make-post-request.js';
import { VisitorData as vd } from '/media/js/frontend/visitor/visitorData.js';

var path = ['root', 'api', 'article_continue_reading'];
var pathUpdate = ['root', 'api', 'article_continue_reading', 'update'];
var a = Article.fromClass('api-continue-reading-article');
var ad = Data.fromClass('api-continue-reading-data');

var processData = function(data) {
    if (! data instanceof Array) {
        console.error('Param data is invalid');
        return;
    }
    
    var articlesCount = data.length;
    var needUpdate = false;
    var display = false;
    var article = null;
    if (articlesCount === 0) {
        needUpdate = true;
    } else if (articlesCount === 1) {
        var first = new ArticleData(data[0]);
        if (ad.getDataId() !== first.id) {            
            display = true;
            article = first;
            needUpdate = true;
        }
    } else {
        var first = new ArticleData(data[0]);
        var second = new ArticleData(data[1]);
        if (ad.getDataId() !== first.id) {
            display = true;
            article = first;
            needUpdate = true;
        } else {
            display = true;
            article = second;
        }
        
    }

    if (needUpdate === true) {
        var requestData = new RequestData();
        requestData.addData(ad.getDataIdField(), ad.getDataId());
        requestData.addData(vd.getCsrfTokenField(), vd.getCsrfToken());        


        makeRequest(pathUpdate, requestData, (err, data) => {
            if (err !== null) {       
                console.log({ 'article-continue-reading': err});
            } else {
                if (article !== null) {
                    a.render(article);
                    a.show();                
                }
            }
        });
        return;
    } else {
        if (display === true) {
            a.render(article);
            a.show();
        }
    }
};

document.addEventListener('DOMContentLoaded', ()=>{
    try {
        var requestData = new RequestData();
        requestData.addData(vd.getCsrfTokenField(), vd.getCsrfToken()); 

        makeRequest(path, requestData, (err, data) => {
            if (err !== null) {       
                console.log({ 'article-continue-reading': err});
            } else {
                try {
                    processData(data);
                } catch (e) {
                    console.log({'article-continue-reading': e});
                }
            }
        });
    } catch (e) {
        console.error('Article continue reading does not work correctly');
        console.error(e);
    }
});