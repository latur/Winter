require('../scss/root.scss');

import sizes from "../scss/_settings/_settings.scss";

window.hljs = require('highlight.js');
window.Quill = require('../components/quill.min.js');
window.Template = require('../components/template.js');;

let imageComposer = (function () {
    let index = 1;

    function reader(files) {
        if (files.length >   4) return reader(files.splice(0, 3)) + reader(files);
        if (files.length === 4) return reader(files.splice(0, 2)) + reader(files);

        let imgs = files.map(function(f) {
            let k = (index++);
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = new Image();
                img.dataset['k'] = k;
                img.onload = function () {
                    if (img.src.substr(0, 5) === 'data:') {
                        img.dataset['w'] = img.width;
                        img.dataset['h'] = img.height;
                        $('#image-' + img.dataset['k']).append(img);
                        $.post('/upload', { m: img.src }, function (res) {
                            if (res.error) {
                                $('#image-' + img.dataset['k']).append('<span>' + res.error + '</span>');
                            } else {
                                img.src = res.url;
                                img.dataset['code'] = img.code;
                            }
                        }, "json");
                    }
                    align();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(f);

            return Template('image-image', {id: 'image-' + k, image: ''});
        }).join('');

        return Template('image-line', {html: imgs});
    }

    function align() {
        // Empty image-blocks removing
        $('.image-line').each(function () {
            if ($(this).find('.image').length === 0) $(this).remove();
        });
        $('.image-block').each(function () {
            if ($(this).find('.image-line').length === 0) $(this).remove();
        });

        // Align images
        $('.image-line').each(function () {
            let imgs = $(this).removeClass('solo').find('img');

            if (imgs.length === 1) {
                $(this).addClass('solo');
                imgs.css({ height: '', width: '' });
                return ;
            }

            let sum = 0;
            imgs.each(function(){
                sum += this.dataset['w']/this.dataset['h'];
            });

            let k = (sizes.space - (imgs.length - 1) * sizes.offset * 2) / sum;
            imgs.each(function(){
                $(this).css({
                    width: this.dataset['w']/this.dataset['h'] * k,
                    height: k
                });
            });
        });

    }

    let drag = false;
    let over = null;
    let helper = null;

    $(document).on('dragstart', function(e) {
        e.preventDefault();
    });

    $(document).on('mousedown', function(e) {
        if (!e.target.classList.contains('image-draggable')) return;

        drag = $(e.target).find('img').get(0);
        helper = $('<img class="image-helper" />').attr('src', drag.src);

        $('body').append(helper);


        // - Helpers to drop: block
        $('[data-editable] > *').before('<hr data-tpl="1">');
        $('[data-editable]').append('<hr data-tpl="1">');

        // - Helpers to drop: line
        $('[data-editable] .image-block > *').before('<hr data-tpl="2">');

        // - Helpers to drop: image (vertical)
        // - Max: 5 in line
        $('[data-editable] .line-wrapper .image').before('<hr data-tpl="3">');
        $('[data-editable] .line-wrapper').append('<hr data-tpl="3">');


        $('[data-editable] hr').hover(function () {
            over = $(this);
        }, function () {
            over = null;
        });
    });

    $(document).on('mousemove', function(e) {
        if (!drag) return ;
        helper.css({ top: e.pageY + 10, left: e.pageX + 10 });
    });

    $(document).on('mouseup', function() {
        if (!drag) return ;
        if (over) {
            let image = Template('image-image', {id: drag.id, image: drag.outerHTML});
            $(drag).parent().remove();

            if (over.data('tpl') < 3) image = Template('image-line', {html: image});
            if (over.data('tpl') < 2) image = Template('image-block', {html: image});
            over.before(image);
            align();
        }

        helper.remove();
        $('[data-editable] hr').remove();
        drag = false;
        over = null;
    });

    $(document).on('click', '[data-image-pane] .btn', function () {
        $(this).parent().find('.btn').removeClass('current');
        $(this).addClass('current');
        $(this).closest('.image-line').attr('data-type', $(this).data('type'));
    });

    $(document).on('click', '[data-action="image-remove"]', function () {
        $(this).closest('.image').remove();
        align();
    });

    return function(fs) {
        return Template('image-block', {html: reader(fs)});
    };
})();

$(function () {
    let after = {};

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
            $('[data-editable]').append(imageComposer(files));
            obj.remove();
        };
    };

    after['video'] = function (obj) {
        let parser = function (url) {
            let id = false;

            let match = url.match(/^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/);
            if (match && match[1]) {
                id = match[1];
                return '<iframe src="https://www.youtube-nocookie.com/embed/'+id+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
            }

            $.ajax({
                async: false,
                url: 'https://vimeo.com/api/oembed.json?url=' + url,
                success: function(res) { if (res.video_id) id = res.video_id; }
            });
            if (id) {
                return '<iframe src="https://player.vimeo.com/video/'+id+'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            }

            return false;
        };

        obj.find('.text').on('keypress', function (e) {
            if (e.which !== 13) return ;
            e.preventDefault();
            let parse = parser($(this).html());
            if (parse) return obj.html(parse);
            // Parse error
        });
    };

    $(document).on('paste', '[data-clean]', function(e) {
        e.preventDefault();
        let pd = e.originalEvent.clipboardData.getData('text');
        document.execCommand("insertHTML", false, pd);
    });

    $(document).on('click', '[data-action="block-remove"]', function (e) {
        $(this).closest('.container').remove();
    });

    $(document).on('click', '[data-w-buttons] a', function (e) {
        e.preventDefault();
        let type = $(this).data('type');
        let tpl = $('#' + type);
        if (tpl.length === 0) return ;

        let obj = $(tpl.html());
        $('[data-editable]').append(obj);
        if (after[type]) (after[type])(obj);
    });
});

/*
 * + Описания под фото
 * + Сохранение фото
 * + Удаление картиник
 * Сохранение страницы
 * Отображение страницы
 * Стили - отсупы и ховеры
 * Авторизация
 *
 * */

