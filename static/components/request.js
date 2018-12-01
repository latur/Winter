module.exports = function (url, data, after) {
    if (!after) after = function(){};

    if (!data.append) {
        $.post(url, Object.assign(data, window._token), after, 'json');
        return;
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
