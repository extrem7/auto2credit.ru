<? /* Template Name: Почему мы */
get_header(); ?>
    <div class="decorative-bg wow slideInRight" data-wow-delay="0.3s" data-wow-duration="1.2s"></div>
    <div class="container">
        <div class="title title-indent"><? the_title() ?></div>
        <div class="row">
            <?
            $blocks = get_field('blocks');
            while (have_rows('blocks')):the_row();
                $icon = get_attached_file(get_sub_field('icon'));
                ?>
                <div class="<?= get_row_index() == 2 ? 'col-xl-8' : '' ?>col-lg-4 col-md-6 col-sm-6 col-12 advantage-item wow zoomIn"
                     data-wow-delay="<?= get_row_index() * .3 ?>s"
                     data-wow-duration="1.2s">
                    <div class="advantage-icon"><?= file_get_contents($icon) ?></div>
                    <div class="advantage-text">
                        <div class="second-title"><? the_sub_field('text') ?></div>
                    </div>
                </div>
            <? endwhile; ?>
        </div>
        <div class="text-center mt-2">
            <a href="<? the_permalink(131) ?>" class="button btn-yellow">Перейти к расчёту</a>
        </div>
    </div>
<? get_footer() ?>