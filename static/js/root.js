require('../scss/root.scss');

import sizes from "../scss/_settings/_settings.scss";

window.sizes = sizes;
window.hljs = require('highlight.js');
window.Quill = require('../components/quill.min.js');
window.template = require('../components/template.js');
window.request = require('../components/request.js');

let imageComposer = require('./parts/imageComposer.js');
let fileComposer = require('./parts/fileComposer.js');

$(function () {
    /* --------------------------------------------------------------------- */

    let after = {};

    after['file'] = function (obj) {
        obj.click().get(0).onchange = function (e) {
            let files = [];
            for (let i = 0; i < e.target.files.length; i++) files.push(e.target.files[i]);
            $(fileComposer(files)).insertAfter(obj);
            obj.remove();
        };
    };

    after['text'] = function (obj) {
        new Quill(obj.find('.text').get(0), {
            modules: {
                syntax: true,
                toolbar: [
                    [{'header': 2}],
                    ['blockquote', 'bold', 'italic', 'underline', 'strike', 'link'],
                    [{'list':'ordered'}, {'list':'bullet'}], ['code-block']
                ]
            },
            placeholder: obj.find('[data-hepler]').data('hepler') || "",
            theme: 'bubble'
        }).focus();
    };

    after['image'] = function (obj) {
        obj.click().get(0).onchange = function (e) {
            let files = [];
            for (let i = 0; i < e.target.files.length; i++) files.push(e.target.files[i]);
            $(imageComposer(files)).insertAfter(obj);
            obj.remove();
        };
    };

    after['video'] = function (obj) {
        obj.find('.text').on('keypress', function (e) {
            if (e.which !== 13) return ;
            e.preventDefault();

            let obj = $(this);
            let url = $(this).html();

            // Youtube Parser
            let match = url.match(/^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/);
            if (match && match[1]) return obj.html(template('video-youtube', {id: match[1]}));

            // Vimeo Parser
            $.ajax({
                url: 'https://vimeo.com/api/oembed.json?url=' + url,
                success: function(res) {
                    obj.html(template('video-vimeo', {id: res.video_id + '', caption: res.title}));
                }
            });
        }).focus();
    };

    /* --------------------------------------------------------------------- */

    let parser = {};

    parser['text'] = function (obj) {
        return obj.find('.ql-editor').html();
    };

    parser['image'] = function (obj) {
        let lines = [];
        obj.find('[data-line]').each(function () {
            let images = [];
            $(this).find('img').each(function () {
                images.push({
                    src: this.attributes.src.value,
                    code: this.dataset['code']
                });
            });
            lines.push({
                images: images,
                type: images.length === 1 ? this.dataset['type'] : ""
            });
        });
        return {
            lines: lines,
            helper: obj.find('[data-hepler]').html()
        };
    };

    parser['file'] = function (obj) {
        return obj.find('a[data-code]').attr('data-code');
    };

    parser['default'] = function (obj) {
        let item = {};
        obj.find('[data-name]').each(function () {
            item[this.dataset['name']] = $(this).attr('src') || this.innerHTML;
        });
        return item;
    };

    /* --------------------------------------------------------------------- */

    // let actions = require('./parts/editorActions.js');

    let actions = {};

    actions['block-remove'] = function (e, h) {
        $(h).closest('[data-editor-item]').remove();
    };

    actions['block-add'] = function (e, h) {
        e.preventDefault();

        let type = $(h).data('type');
        let obj = $($('#' + type).html());

        let before = $(h).closest('[data-editor-item]');
        if (before.length > 0) {
            obj.insertBefore(before);
        } else {
            $('[data-editable]').append(obj);
        }

        if (after[type]) (after[type])(obj);
    };

    actions['logout'] = function (e, h) {
        e.preventDefault();
        window.request(h.href, {}, function (res) {
            location.href = res;
        });
    };

    actions['create'] = function (e, h) {
        window.request(window._route.create, {}, function (res) {
            location.href = res;
        });
    };

    actions['post-remove'] = function (e, h) {
        let id = $(h).data('id');
        let msg = $(template('alert', { id: id, action: 'post-restore' }));
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

    actions['post-restore'] = function (e, h) {
        let id = $(h).data('id');
        $(h).closest('[data-alert]').removeClass('visible');

        window.request(window.api, { method: 'setActive', id: id, to: 1 }, function (res) {
            $('[data-post-id="'+id+'"]').fadeIn(300);
        });
    };

    actions['save'] = function (e, h) {
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

    $(document).on('click', '[data-action]', function (e) {
        if ($(this).hasClass('disabled')) return false;
        let action = $(this).data('action');
        if (actions[action]) actions[action](e, this);
    });

    /* --------------------------------------------------------------------- */

    $(document).on('paste', '[data-clean]', function(e) {
        e.preventDefault();
        let data = e.originalEvent.clipboardData.getData('text');
        document.execCommand("insertHTML", false, data);
    });

    $(document).on('keypress', '[data-clean]', function(e) {
        if (e.which !== 13) return ;
        e.preventDefault();
        return false;
    });

    $(window).on('load keyup upload-trigger', function() {
        let i = parseInt($('body').data('images-loading') || 0);
        let f = parseInt($('body').data('files-loading') || 0);
        let t = $('[data-name="post-title"]').text().length == 0;

        console.log('Total uploading items: ' + (i + f));

        if (t || i + f > 0) {
            $('[data-action="save"]').addClass('disabled');
        } else {
            $('[data-action="save"]').removeClass('disabled');
        }
    });

    /* --------------------------------------------------------------------- */

    $('[data-editable] > [data-name="text"]').each(function () {
        after['text']($(this));
    });
});

/*
 * + Описания под фото
 * + Сохранение фото
 * + Удаление картиник
 * + Стили - отсупы и ховеры редактора
 * + Сохранение страницы
 * + Авторизация
 * + Блокировка сохранения поста до загрузки всех файлов
 * + Неперетаскивать правой кнопкой
 * + Отображение страницы
 * + Реакция на сохранение
 * + Модалька
 * + Удаление поста
 * Просмотрщик картинок
 * Мобильная версия редактора
 * Мобильная версия просмотра поста
 * Метаданные поста
 * Пагинация на главной
 * Темы оформления
 * Настройки
 * Статистика
 * Теги и страница поиска по тегу
 * Парсинг иньекций
 * Статичные страницы и меню (?)
 * Пользовательска страница (?)
 * Выпилить лишние зависимости
 * Инструкция по развертке
 * */

