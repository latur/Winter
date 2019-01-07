module.exports = {};

module.exports.text = function (obj) {
    return obj.find('.ql-editor').html();
};

module.exports.image = function (obj) {
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

module.exports.file = function (obj) {
    return obj.find('a[data-code]').attr('data-code');
};

module.exports.default = function (obj) {
    let item = {};
    obj.find('[data-name]').each(function () {
        item[this.dataset['name']] = $(this).attr('src') || this.innerHTML;
    });
    return item;
};
