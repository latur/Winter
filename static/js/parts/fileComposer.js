module.exports = (function () {
    let index = 0;
    let loaded = 0;

    function reader(files) {
        let html = '';

        for (let i = 0; i < files.length; i++) {
            let form = new FormData();
            let id = 'file-' + (index++);

            form.append('f', files[i]);
            form.append('method', 'loadFile');
            $(document).trigger('upload-trigger');

            html += template('file-block', {
                id: id,
                name: files[i].name,
                size: files[i].size
            });

            window.request(window.api || '/', form, function(res) {
                loaded += 1;
                $('#' + id).attr('data-code', res.code);
                $('body').data('files-loading', index - loaded);
                $(document).trigger('upload-trigger');
            });
        }

        return html;
    }

    return reader;
})();
