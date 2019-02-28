<? get_header(); ?>
    <div class="container">
        <div class="title title-indent"><? single_cat_title() ?></div>
        <? if (have_posts()) : ?>
            <div class="row">
                <?
                while (have_posts()) {
                    the_post();
                    get_template_part('views/post');
                }
                ?>
            </div>
            <?
            $args = [
                'show_all' => false,
                'end_size' => 2,
                'mid_size' => 2,
                'prev_next' => true,
                'prev_text' => 'Предыдущая',
                'next_text' => 'Следующая',
            ];
            the_posts_pagination($args);
        endif;
        ?>
        <div class="text-center mt-2">
            <a href="<? the_permalink(131) ?>" class="button btn-yellow">Перейти к расчёту</a>
        </div>
    </div>
<? get_footer() ?>