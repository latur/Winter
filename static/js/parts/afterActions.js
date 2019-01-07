let fileComposer = require('./fileComposer.js');
let imageComposer = require('./imageComposer.js');

module.exports = {};

module.exports.file = function (obj) {
    obj.click().get(0).onchange = function (e) {
        let files = [];
        for (let i = 0; i < e.target.files.length; i++) files.push(e.target.files[i]);
        $(fileComposer(files)).insertAfter(obj);
        obj.remove();
    };
};

module.exports.text = function (obj) {
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

module.exports.image = function (obj) {
    obj.click().get(0).onchange = function (e) {
        let files = [];
        for (let i = 0; i < e.target.files.length; i++) files.push(e.target.files[i]);
        $(imageComposer(files)).insertAfter(obj);
        obj.remove();
    };
};

module.exports.video = function (obj) {
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
