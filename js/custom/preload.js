(function ($) {
    function Preload(imgs, opts) {
        this.imgs = typeof imgs === 'string' ? [imgs] : imgs;
        this.opts = $.extend({}, Preload.DEFAULTS, opts);
        if (this.opts.order === 'order') {
            this._order();
        } else {
            this._unorder();
        }
    }
    Preload.DEFAULTS = {
        each : null, //每张图片加载完成后执行
        all : null, //所有图片加载完毕后执行
        order :　'unorder'
    };
    Preload.prototype._unorder = function () { // 无序加载
        images = this.imgs;
        opts = this.opts;
        count = 0;
        length = images.length;
        $.each(images, function (i, src) {
            if (typeof src != 'string') {
                count++;
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
    };

    Preload.prototype._order = function () { // 有序加载，借助递归实现(漫画)
        count = 0;
        imgs = this.imgs;
        opts = this.opts;
        length = imgs.length;
        load();
        function load() {
            imgObj = new Image();
            src = imgs[count];
            if (typeof src != 'string') {
                return;
            }
            $(imgObj).on('load error', function() {
                count++;
                opts.each && opts.each(count, length);
                if (count < length) {
                    load();
                } else {
                    opts.all && opts.all();
                }
            });
            imgObj.src = src;
        }
    };

    $.extend({
        preload : function (imgs, opts) {
            new Preload(imgs, opts);
        }
    });
})(jQuery);