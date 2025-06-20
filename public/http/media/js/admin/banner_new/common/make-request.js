'use strict';

import { default as target } from '/media/js/modules/urlbuilder/dynamicTarget.js';
import { default as urlbuilder } from '/media/js/modules/urlbuilder/urlbuilder.js';
import { default as Query } from '/media/js/modules/urlbuilder/query.js';

var t = target(currentLanguage);
var u = urlbuilder(t);

export default function(path, filterRequest, callback) {
    if (typeof path  !== 'object') {
        throw new Error('Param path is invalid');
    } else if (path.length === 0) {
        throw new Error('Param path is empty');
    }
    var url = u (
        path,
        [
            new Query(filterRequest.limitField, filterRequest.limitValue),
            new Query(filterRequest.orderByField, filterRequest.orderByValue),
            new Query(filterRequest.orderByDirectionField, filterRequest.orderByDirectionValue),
            new Query(filterRequest.pageField, filterRequest.pageValue),
        ]
    );

    var request = new Request(url, {
        method: "GET",
        headers: {
          "Accept": "application/json;q=1.0",
        },
      });

    fetch(request).then(function (response) {
        if (response.status === 200) {
            response.json().then((data) => {
                var dataKeys = Object.keys(data);
                if (dataKeys.indexOf('status') > -1) {
                    if(data['status'] === 'success') {
                        var result = data['result'];
                        if (result !== undefined && result !== '') {
                            callback(null, result);
                        } else {                            
                            callback(new Error('Response result not found'), null);
                        }
                    } else {
                        console.error(data);
                        callback(new Error('Response status not success'), null);
                    }
                } else {
                    callback(new Error('Response status not found'), null);
                }   
            }, (err) => {
                callback(err, null);
            })
        } else {
            var statusError = new Error(`Server response with status: ${response.status}`);
            callback(statusError, null);
        }
    }, function (error) {
        callback(error, null);
    });
};
