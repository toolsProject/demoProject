<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>preload</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <style>
        .loading {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #cccccc;
            text-align: center;
        }
        .progress {
            margin-top: 200px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-2 btn btn-info" data-control="pre">上一张</div>
        <div class="col-md-8 prompt" style="text-align: center"></div>
        <div class="col-md-2 btn btn-info" data-control="next">下一张</div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <img id="img" src="https://n.codespromofr.com/images/banner/ZalandoPrive_banner.jpg" class="img-rounded img-responsive" />
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2 btn btn-info" data-control="pre">上一张</div>
        <div class="col-md-8 prompt" style="text-align: center"></div>
        <div class="col-md-2 btn btn-info" data-control="next">下一张</div>
    </div>
</div>
<div class="loading">
    <div class="progress">
        <div class="progress-bar progress-bar-info progress-bar-striped active">
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/custom/preload.js"></script>
<script>
    images = [
        'https://n.codespromofr.com/images/banner/ZalandoPrive_banner.jpg',
        'https://n.codespromofr.com/images/banner/kiabi_banner.jpg',
        'https://n.codespromofr.com/images/model/banner_small.jpg',
        'https://n.codespromofr.com/images/banner/145403252185.jpg',
        'https://n.codespromofr.com/images/banner/b149386642891.jpg',
        'https://n.codespromofr.com/images/banner/b149319723030.jpg',
        'https://n.codespromofr.com/images/banner/b148999143585.jpg',
        'https://n.codespromofr.com/images/banner/b148913884249.jpg',
        'https://n.codespromofr.com/images/banner/banner_big.jpg',
        'https://n.codespromofr.com/images/banner/kiabi_banner.jpg',
        'https://n.codespromofr.com/images/banner/ZalandoPrive_banner.jpg',
        'https://n.codespromofr.com/images/banner/145206671838.jpg',
        'https://n.codespromofr.com/images/banner/145223011454.jpg',
        'https://n.codespromofr.com/images/banner/145403252185.jpg',
        'https://n.codespromofr.com/images/banner/145576396586.jpg',
        'https://n.codespromofr.com/images/banner/145576640410.jpg',
        'https://n.codespromofr.com/images/banner/b145767296739.jpg',
        'https://n.codespromofr.com/images/banner/b145829425461.jpg',
        'https://n.codespromofr.com/images/banner/b145922988959.jpg',
        'https://n.codespromofr.com/images/banner/b145949070745.jpg',
        'https://n.codespromofr.com/images/banner/b145992314840.jpg',
        'https://n.codespromofr.com/images/banner/b148816216725.jpg',
        'https://n.codespromofr.com/images/banner/b145992319554.jpg',
        'https://n.codespromofr.com/images/banner/b146105317667.jpg',
        'https://n.codespromofr.com/images/banner/b146114652799.jpg',
        'https://n.codespromofr.com/images/banner/b146114915883.jpg',
        'https://n.codespromofr.com/images/banner/b146182307738.jpg',
        'https://n.codespromofr.com/images/banner/b146182314617.jpg',
        'https://n.codespromofr.com/images/banner/b148913799348.jpg',
        'https://n.codespromofr.com/images/banner/b146234509055.jpg',
        'https://n.codespromofr.com/images/banner/b146253111375.jpg',
        'https://n.codespromofr.com/images/banner/b146459305278.jpg',
        'https://n.codespromofr.com/images/banner/b146485905671.jpg',
        'https://n.codespromofr.com/images/banner/b146557674763.png',
        'https://n.codespromofr.com/images/banner/b146604330444.png',
        'https://n.codespromofr.com/images/banner/b146604519597.jpg',
        'https://n.codespromofr.com/images/banner/b146659076114.jpg',
        'https://n.codespromofr.com/images/banner/b146831795151.png',
        'https://n.codespromofr.com/images/banner/b147160416025.jpg',
        'https://n.codespromofr.com/images/banner/b147252595648.jpg',
        'https://n.codespromofr.com/images/banner/b147436472762.jpg',
        'https://n.codespromofr.com/images/banner/b147444181924.jpg',
        'https://n.codespromofr.com/images/banner/b147485486733.png',
        'https://n.codespromofr.com/images/banner/b148913801862.jpg',
        'https://n.codespromofr.com/images/banner/b147928586369.jpg',
        'https://n.codespromofr.com/images/banner/b147936183064.jpg',
        'https://n.codespromofr.com/images/banner/b148402585868.jpg',
        'https://n.codespromofr.com/images/banner/b148816212752.jpg',
        'https://n.codespromofr.com/images/banner/b148490682740.gif',
        'https://n.codespromofr.com/images/banner/b148653102389.jpg',
        'https://n.codespromofr.com/images/banner/b148818903215.jpg',
        'https://n.codespromofr.com/images/banner/b148913879142.jpg',
        'https://n.codespromofr.com/images/banner/b148913882676.jpg',
        'https://n.codespromofr.com/images/banner/b148818912250.gif',
        'https://n.codespromofr.com/images/banner/b148833311260.jpg',
        'https://n.codespromofr.com/images/banner/b148833314516.jpg',
        'https://n.codespromofr.com/images/banner/b148913804049.jpg',
        'https://n.codespromofr.com/images/banner/b148913884249.jpg',
        'https://n.codespromofr.com/images/banner/b148913806441.jpg',
        'https://n.codespromofr.com/images/banner/b148913885898.jpg',
        'https://n.codespromofr.com/images/banner/b148913716030.jpg',
        'https://n.codespromofr.com/images/banner/b148999142312.jpg',
        'https://n.codespromofr.com/images/banner/b148999143585.jpg',
        'https://n.codespromofr.com/images/banner/b149069548977.jpg',
        'https://n.codespromofr.com/images/banner/b149069550939.jpg',
        'https://n.codespromofr.com/images/banner/b149319718632.jpg',
        'https://n.codespromofr.com/images/banner/b149319723030.jpg',
        'https://n.codespromofr.com/images/banner/b149386640338.jpg',
        'https://n.codespromofr.com/images/banner/b149386642891.jpg'
    ];
    var index = 0,
        length = images.length,
        count = 0;
//    $.each(images, function (i, src) {
//        imgObj = new Image();
//        $(imgObj).on('load error', function () {
//            count++;
//            progress = Math.round(count / length * 100) + '%';
//            $('.progress-bar').attr('style', 'width: ' + progress);
//            $('.progress-bar').html(progress);
//            if (count >= length) {
//                $('.loading').hide();
//            }
//        });
//        imgObj.src = src;
//    });
    $.preload(images, {
        each : function (count, length) {
            progress = Math.round(count / length * 100) + '%';
            $('.progress-bar').attr('style', 'width: ' + progress);
            $('.progress-bar').html(progress);
        },
        all : function () {
            $('.loading').hide();
        }
    });

    $('.prompt').html(index + 1 + '/' + length);
    $('.btn').on('click', function () {
        behavior = $(this).data('control');
        if ('pre' == behavior) { // 上一张
            index = Math.max(0, --index);
        } else {
            index = Math.min(length - 1, ++index);
        }
        $('#img').attr('src', images[index]);
        $('.prompt').html(index + 1 + '/' + length);
    });
</script>
</body>
</html>