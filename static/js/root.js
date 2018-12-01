require('../scss/root.scss');

import sizes from "../scss/_settings/_settings.scss";

window.sizes = sizes;
window.hljs = require('highlight.js');
window.Quill = require('../components/quill.min.js');
window.Template = require('../components/Template.js');
window.request = require('../components/request.js');


let imageComposer = require('./parts/imageComposer.js');
let fileComposer = require('./parts/fileComposer.js');

$(function () {
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
            if (match && match[1]) return obj.html(Template('video-youtube', {id: match[1]}));

            // Vimeo Parser
            $.ajax({
                url: 'https://vimeo.com/api/oembed.json?url=' + url,
                success: function(res) {
                    obj.html(Template('video-vimeo', {id: res.video_id + '', caption: res.title}));
                }
            });
        }).focus();
    };


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

    function save() {
        let page = [];
        $('[data-editable] > *').each(function () {
            let nm = this.dataset['name'];
            if (parser[nm]) return page.push({
                'type': nm,
                'data': parser[nm]($(this))
            });

            let item = {};
            $(this).find('[data-name]').each(function () {
                item[this.dataset['name']] = $(this).attr('src') || this.innerHTML;
            });
            page.push({
                'type': nm,
                'data': item
            });
        });

        console.log(page);

        window.request(null, {
            title: $('[data-name="post-title"]').html(),
            content: page
        });
    }


    $(document).on('paste', '[data-clean]', function(e) {
        e.preventDefault();
        let pd = e.originalEvent.clipboardData.getData('text');
        document.execCommand("insertHTML", false, pd);
    });

    $(document).on('keypress', '[data-clean]', function(e) {
        if (e.which !== 13) return ;
        e.preventDefault();
        return false;
    });

    $(document).on('click', '[data-action="block-remove"]', function (e) {
        $(this).closest('[data-editor-item]').remove();
    });

    $(document).on('click', '[data-w-buttons] a', function (e) {
        e.preventDefault();
        let type = $(this).data('type');
        let tpl = $('#' + type);
        if (tpl.length === 0) return ;

        let obj = $(tpl.html());

        let before = $(this).closest('[data-editor-item]');
        if (before.length > 0) {
            obj.insertBefore(before);
        } else {
            $('[data-editable]').append(obj);
        }

        if (after[type]) (after[type])(obj);
    });

    $(document).on('click', '[data-save]', save);

    $(document).on('click', '[data-create]', function () {
        window.request(window._route.create, {}, function (res) {
            location.href = res;
        });
    });

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
 * ! Несохранение до загруузки всех файлов
 * Отображение страницы
 * Мобильная версия редактора
 * Мобильная версия просмотра поста
 * Парсинг иньекций
 * Авторизация
 * Статичные страницы и меню (?)
 * Пользовательска страница (?)
 * Выпилить лишние зависимости
 * Инструкция по развертке
 *
 * */

