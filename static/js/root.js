require('../scss/root.scss');

import sizes from "../scss/_settings/_settings.scss";

window.sizes = sizes;
window.hljs = require('highlight.js');
window.Quill = require('../components/quill.min.js');
window.template = require('../components/template.js');
window.request = require('../components/request.js');

$(function () {
    /* --------------------------------------------------------------------- */

    let after = require('./parts/afterActions.js');
    let data = require('./parts/dataActions.js');

    $(document).on('blockAdded', function (e, type, obj) {
        console.log([e, type, obj]);
        if (after[type]) (after[type])(obj);
    });

    $(document).on('click', '[data-action]', function (e) {
        if ($(this).hasClass('disabled')) return false;
        let action = $(this).data('action');
        if (data[action]) data[action](e, this);
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

