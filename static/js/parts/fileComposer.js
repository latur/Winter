module.exports = (function () {
    let index = 1;

    function reader(files) {
        for (let i in files) {
            let form = new FormData();
            form.append('media', files[i]);
            $.ajax({
                url : '/upload',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data : form,
                success: function(response){
                }
            });
            // Template('file', {name: f.name, size: f.size})
        }
    }

    return reader;
})();
