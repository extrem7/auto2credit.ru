<? /* Template Name: Как это работает */
get_header(); ?>
    <div class="container">
        <div class="title title-indent"><? the_title() ?></div>
        <div class="video mb-4 wow zoomIn">
            <? $Auto2Credit->views()->video() ?>
        </div>
        <div class="text-center">
            <div class="sub-title black-span text-uppercase medium-size mb-2"><? the_field('title') ?></div>
            <div class="second-title medium-weight"><? the_field('subtitle') ?></div>
        </div>
        <div class="row how-works">
            <? while (have_rows('blocks')):the_row();
                $icon = get_attached_file(get_sub_field('icon')); ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12 how-work-item wow zoomIn"
                     data-wow-delay="<?= get_row_index() * .3 ?>s"
                     data-wow-duration="1.2s">
                    <div class="how-work-box">
                        <?= file_get_contents($icon) ?>
                        <div class="how-title"><? the_sub_field('title') ?></div>
                        <div class="how-text"><? the_sub_field('text') ?></div>
                        <? if (get_sub_field('image')): ?>
                            <div class="how-circle-info"
                                 style="background-image: url('<? the_sub_field('image') ?>')"></div>
                        <? endif; ?>
                    </div>
                </div>
            <? endwhile; ?>
        </div>
    </div>
    <div class="text-center mt-2">
        <a href="<? the_permalink(131) ?>" class="button btn-yellow">Перейти к расчёту</a>
    </div>
    <section class="how-it-section d-flex align-items-center wow fadeInUp" data-wow-duration="1.2s"
             data-wow-offset="600">
        <div class="container">
            <div class="row">
                <div class="offset-lg-5 col-lg-6 offset-md-4 col-md-8 how-description">
                    <?= apply_filters('the_content', wpautop(get_post_field('post_content', $id), true)); ?>
                    <div class="partners d-flex justify-content-between align-items-center mt-3 mt-sm-5">
                        <? foreach (get_field('partners') as $partner): ?>
                            <a href="<?= $partner['caption'] ?>" target="_blank">
                                <img class="img-fluid" src="<?= $partner['url'] ?>" alt="partner">
                            </a>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<? get_footer() ?>