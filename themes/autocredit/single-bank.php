<? get_header(); ?>
    <div class="container">
        <div class="title medium-size mb-3">Прочие условия по автокредиту</div>
        <div><? the_field('conditions_text') ?></div>
        <table class="disclaimer-table">
            <? while (have_rows('conditions')):the_row() ?>
                <tr>
                    <td>
                        <div class="second-title"><? the_sub_field('title') ?></div>
                    </td>
                    <td class="text-left"><? the_sub_field('text') ?></td>
                </tr>
            <? endwhile; ?>
        </table>
        <div class="title medium-size mb-3">Требования к заемщику</div>
        <div><? the_field('requirements_text') ?></div>
        <table class="disclaimer-table">
            <? while (have_rows('requirements')):the_row() ?>
                <tr>
                    <td>
                        <div class="second-title"><? the_sub_field('title') ?></div>
                    </td>
                    <td class="text-left"><? the_sub_field('text') ?></td>
                </tr>
            <? endwhile; ?>
        </table>
        <div> <?= apply_filters('the_content', wpautop(get_post_field('post_content', $id), true)); ?></div>
    </div>
<? get_footer(); ?>