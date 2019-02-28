<? get_header(); ?>
    <div class="container">
        <div class="title title-indent">Блог</div>
        <article class="article-page dynamic-content">
            <? the_post_thumbnail(null, ['class' => "alignleft"]) ?>
            <div class="article-head">
                <h1 class="sub-title medium-size"><? the_title(); ?></h1>
                <div class="text-muted mt-2 mb-2"><?= get_the_date() ?></div>
            </div>
            <?= apply_filters('the_content', wpautop(get_post_field('post_content', $id), true)); ?>
        </article>
    </div>
<? get_footer(); ?>