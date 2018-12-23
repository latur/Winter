module.exports = function (url, data, after) {
    after = after || function(){};

    if (!data.append) {
        data = Object.assign(data, window._token);
        return $.post(url, data, after, 'json');
    }

    let key = Object.keys(window._token)[0];
    data.append(key, window._token[key]);

    $.ajax({
        url: url,
        type: "POST",
        cache: false,
        data: data,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: after
    });
};
