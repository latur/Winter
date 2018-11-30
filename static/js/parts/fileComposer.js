module.exports = (function () {
    let index = 1;

    function reader(files) {
        let html = '';
        for (let i in files) {
            let form = new FormData();
            let id = (index++);
            form.append('f', files[i]);
            html += Template('file', {
                id: id,
                name: files[i].name,
                size: files[i].size
            });
            $.ajax({
                url : '/file', type: "POST",
                cache: false, contentType: false, processData: false,
                data : form,
                success: function(res){

                }
            });
        }

        return html;
    }

    return reader;
})();
