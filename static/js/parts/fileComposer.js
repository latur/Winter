module.exports = (function () {
    let index = 1;

    function reader(files) {
        let html = '';

        for (let i = 0; i < files.length; i++) {
            let form = new FormData();
            let id = 'file-' + (index++);

            form.append('f', files[i]);

            html += Template('file-block', {
                id: id,
                name: files[i].name,
                size: files[i].size
            });

            window.request(window._route.file || '/', form, function(res) {
                $('#' + id).attr('data-code', res.code);
            });
        }

        return html;
    }

    return reader;
})();
