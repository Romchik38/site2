'use strict';

import { urlbuilder as u } from '/media/js/modules/utils/urlbuilder.js'

export default function(path, requestData, callback) {
    if (typeof path  !== 'object') {
        throw new Error('Param path is invalid');
    } else if (path.length === 0) {
        throw new Error('Param path is empty');
    }
    var url = u(path);

    var formData = new FormData();
    formData.append(requestData.idField, requestData.id);
    formData.append(requestData.tokenField, requestData.token);    

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
