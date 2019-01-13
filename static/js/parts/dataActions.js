let parser = require('./parserActions.js');

module.exports.actions = {};

module.exports.blockRemove = function (e, h) {
    $(h).closest('[data-editor-item]').remove();
};

module.exports.blockAdd = function (e, h) {
    e.preventDefault();

    let type = $(h).data('type');
    let obj = $($('#' + type).html());

    let before = $(h).closest('[data-editor-item]');
    if (before.length > 0) {
        obj.insertBefore(before);
    } else {
        $('[data-editable]').append(obj);
    }

    $(document).trigger('blockAdded', [type, obj]);
};

module.exports.logout = function (e, h) {
    e.preventDefault();
    window.request(window.api, { method: 'logout' }, function (res) {
        location.href = res;
    });
};

module.exports.create = function (e, h) {
    window.request(window.api, { method: 'create' }, function (res) {
        location.href = res;
    });
};

module.exports.remove = function (e, h) {
    let id = $(h).data('id');
    let msg = $(template('alert', { id: id, action: 'restore' }));
    msg.appendTo('body');

    window.request(window.api, { method: 'setActive', id: id, to: 0 }, function (res) {
        msg.addClass('visible');
        $('[data-post-id="'+id+'"]').fadeOut(300);
        setTimeout(function () {
            msg.removeClass('visible');
            setTimeout(function () {
                msg.remove();
            }, 200);
        }, 7000);
    });
};

module.exports.restore = function (e, h) {
    let id = $(h).data('id');
    $(h).closest('[data-alert]').removeClass('visible');

    window.request(window.api, { method: 'setActive', id: id, to: 1 }, function (res) {
        $('[data-post-id="'+id+'"]').fadeIn(300);
    });
};

module.exports.save = function (e, h) {
    let content = [];
    let title = $('[data-name="post-title"]').html();

    $('[data-editable] > *').each(function () {
        let name = this.dataset['name'];
        let data = parser[name] ? parser[name]($(this)) : parser['default']($(this));
        content.push({
            'type': name,
            'data': data
        });
    });

    window.request(null, {title: title, content: content}, function (url) {
        location.href = url;
    });
};

