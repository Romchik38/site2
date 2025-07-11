'use strict';

import { default as target } from '/media/js/modules/urlbuilder/dynamicTarget.js';
import { default as urlbuilder } from '/media/js/modules/urlbuilder/urlbuilder.js';
import { default as RequestData } from './request-data.js';

var t = target(currentLanguage);
var u = urlbuilder(t);

export default function(path, requestData, callback) {
    if (typeof path  !== 'object') {
        throw new Error('Param path is invalid');
    } else if (path.length === 0) {
        throw new Error('Param path is empty');
    }
    if (!requestData instanceof RequestData) {
        throw new Error('Param requestData is invalid');
    }
    var url = u(path);

    var formData = new FormData();
    var keys = requestData.getKeys();
    for (var key of keys) {
        formData.append(key, requestData.getData(key));
    }

    var request = new Request(url, {
        method: "POST",
        headers: {
          "Accept": "application/json;q=1.0",
        },
        body: formData
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
