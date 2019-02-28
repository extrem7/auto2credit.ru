<? get_header(); ?>
    <div class="container">
        <article class="article-page dynamic-content">
            <? the_post_thumbnail(null, ['class' => "alignleft"]) ?>
            <div class="article-head">
                <h1 class="sub-title big-size text-center"><? the_title(); ?></h1>
            </div>
            <?= apply_filters('the_content', wpautop(get_post_field('post_content', $id), true)); ?>
        </article>
    </div>
<? get_footer(); ?>