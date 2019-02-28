<? /* Template Name: Главная */
get_header(); ?>
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="banner-block">
                    <?= get_post_field('post_content', $id) ?>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 video">
                <? $Auto2Credit->views()->video() ?>
            </div>
            <div class="col-12 mt-0 mt-md-3 mb-0 mb-md-5">
                <div class="more-detail text-center" id="arrow-down">
                    Узнать подробнее
                    <div><i class="fas fa-angle-double-down"></i></div>
                </div>
            </div>
        </div>
        <div class="multiplication mult-1 wow zoomIn" data-wow-duration="1.2s" data-wow-delay="1.5s">
            <img data-lazysrc="<? the_field('svg_1') ?>" class="pc" alt="">
            <img data-lazysrc="<? the_field('svg_1_mobile') ?>" class="mob" alt="">
            <div class="text-center mt-4">
                <a href="<? the_permalink(131) ?>" class="button btn-yellow">Перейти на расчёт</a>
            </div>
        </div>
        <div class="multiplication mult-2 wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="1s">
            <img data-lazysrc="<? the_field('svg_2') ?>" class="pc" alt="">
            <img data-lazysrc="<? the_field('svg_2_mobile') ?>" class="mob" alt="">
            <div class="text-center mt-2">
                <a href="<? the_permalink(131) ?>" class="button btn-yellow">Перейти на расчёт</a>
            </div>
        </div>
        <div class="multiplication mult-3 wow fadeInRight" data-wow-duration="1.2s" data-wow-delay="1s">
            <img data-lazysrc="<? the_field('svg_3') ?>" class="pc" alt="">
            <img data-lazysrc="<? the_field('svg_3_mobile_kopiya') ?>" class="mob" alt="">
            <div class="text-left">
                <a href="<? the_permalink(131) ?>" class="button btn-yellow">Перейти на расчёт</a>
            </div>
        </div>
        <div class="multiplication mult-4 wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="1s">
            <img data-lazysrc="<? the_field('svg_4') ?>" class="pc" alt="">
            <img data-lazysrc="<? the_field('svg_4_mobile') ?>" class="mob" alt="">
            <div class="text-center mt-2">
                <a href="<? the_permalink(131) ?>" class="button btn-yellow">Перейти на расчёт</a>
            </div>
        </div>
        <div class="multiplication mult-5 wow fadeInRight" data-wow-duration="1.2s" data-wow-delay="1s">
            <img data-lazysrc="<? the_field('svg_5') ?>" class="pc" alt="">
            <img data-lazysrc="<? the_field('svg_5_mobile') ?>" class="mob" alt="">
            <a href="<? the_permalink(131) ?>" class="button btn-yellow w-100 btn-sale">
                перейти на страницу <br/> расчёта
            </a>
        </div>
        <div class="multiplication mult-6 wow zoomIn" data-wow-duration="1.2s" data-wow-delay="1s">
            <a href="<? the_permalink(131) ?>" class="link-img"></a>
            <img data-lazysrc="<? the_field('svg_6') ?>" class="pc" alt="">
            <img data-lazysrc="<? the_field('svg_6_mobile') ?>" class="mob" alt="">
        </div>
    </div>
<? get_footer() ?>