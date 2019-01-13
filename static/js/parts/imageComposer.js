module.exports = (function () {
    let index = 0;
    let loaded = 0;

    function reader(files) {
        if (files.length >   4) return reader(files.splice(0, 3)) + reader(files);
        if (files.length === 4) return reader(files.splice(0, 2)) + reader(files);

        let imgs = files.map(function(f) {
            let k = (index++);
            let reader = new FileReader();
            $(document).trigger('upload-trigger');

            reader.onload = function(e) {
                let img = new Image();
                img.dataset['k'] = k;
                img.onload = function () {
                    if (img.src.substr(0, 5) === 'data:') {
                        let t = $('#image-' + img.dataset['k']);
                        img.dataset['w'] = img.width;
                        img.dataset['h'] = img.height;
                        t.append(img).append('<span class="processing"></span>');

                        window.request(window.api || '/', { m: img.src, method: 'loadImage' }, function(res) {
                            loaded += 1;
                            $('body').data('images-loading', index - loaded);
                            $(document).trigger('upload-trigger');
                            t.find('.processing').remove();
                            if (res.error) {
                                t.append('<span class="error">' + res.error + '</span>');
                            } else {
                                img.src = res.url;
                                img.dataset['code'] = res.code;
                            }
                        });
                    }
                    align();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(f);

            return template('image-image', {id: 'image-' + k, image: ''});
        }).join('');

        return template('image-line', {html: imgs});
    }

    function align() {
        // Empty image-blocks removing
        $('.image-line').each(function () {
            if ($(this).find('.image').length === 0) $(this).remove();
        });
        $('.image-block').each(function () {
            if ($(this).find('.image-line').length === 0) $(this).closest('[data-editor-item]').remove();
        });

        // Align images
        $('.image-line').each(function () {
            let imgs = $(this).removeClass('solo').find('img');

            if (imgs.length === 1) {
                $(this).addClass('solo');
                $(this).find('[data-image-pane] a').removeClass('current');
                $(this).find('[data-image-pane] a[data-type="'+$(this).data('type')+'"]').addClass('current');
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
        if (e.button != 0) {
            e.preventDefault();
            return ;
        }

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
            let image = template('image-image', {id: drag.id, image: drag.outerHTML});
            $(drag).parent().remove();

            if (over.data('tpl') < 3) image = template('image-line', {html: image});
            if (over.data('tpl') < 2) image = template('image-block', {html: image});
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

    align();

    return function(fs) {
        return template('image-block', {html: reader(fs)});
    };
})();
