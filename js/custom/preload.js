(function ($) {
    function Preload(imgs, options) {
        this.imgs = typeof imgs === 'string' ? [imgs] : imgs;
        this.opts = $.extend({}, Preload.DEFAULTS, options);
        this._unorder();
    }
    Preload.DEFAULTS = {
        each : null, //每张图片加载完成后执行
        all : null, //所有图片加载完毕后执行
    };
    Preload.prototype._unorder = function () { // 无序加载
        images = this.imgs;
        opts = this.opts;
        count = 0;
        length = images.length;
        $.each(images, function (i, src) {
            if (typeof src != 'string') {
                length--;
                return;
            }
            imgObj = new Image();
            $(imgObj).on('load error', function () {
                count++;
                opts.each && opts.each(count, length);
                if (count >= length) {
                    opts.all && opts.all();
                }
            });
            imgObj.src = src;
        });
    }

    $.extend({
        preload : function (imgs, opts) {
            new Preload(imgs, opts);
        }
    })
})(jQuery);