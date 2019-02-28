<? /* Template Name: FAQ */
get_header(); ?>
    <div class="container">
        <div class="title big-size title-indent"><? the_title() ?></div>
        <div class="faq-container zoomIn" id="faq" data-wow-duration="2s">
            <?
            $faq = get_field('faq');
            $faq = array_chunk($faq, ceil(count($faq) / 2));
            $i = 0;
            foreach ($faq as $column): ?>
                <div class="faq-card">
                    <? foreach ($column as $item): ?>
                        <div class="wow <?= $i < count($faq[0]) ? 'fadeInLeft' : 'fadeInRight' ?>"
                             data-wow-delay="<?= $i * .2 ?>s">
                            <div class="faq-header collapsed" data-toggle="collapse" data-target="#question-<?= $i ?>"
                                 aria-expanded="false"><?= $item['question'] ?></div>
                            <div id="question-<?= $i ?>" class="collapse faq-content" data-parent="#faq">
                                <div class="faq-answer"><?= $item['answer'] ?></div>
                            </div>
                        </div>
                        <? $i++; endforeach; ?>
                </div>
            <? endforeach; ?>
        </div>
        <div class="text-center mt-3">
            <a href="<? the_permalink(131) ?>" class="button btn-yellow">Перейти к расчёту</a>
        </div>
    </div>
<? get_footer() ?>