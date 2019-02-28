<!doctype html>
<html lang="<? bloginfo('language') ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= wp_get_document_title() ?></title>
    <? wp_head() ?>
</head>
<body <? body_class() ?>>
<header class="header">
    <?
    global $Auto2Credit;
    $phones = get_field('phones', $Auto2Credit->geo->city);
    ?>
    <div class="container d-flex align-items-center justify-content-between">
        <a href="<? bloginfo('url') ?>"><img src="<? the_field('logo', 'option') ?>" class="logo" alt="logo"></a>
        <nav class="menu-container" role="navigation">
            <div class="mob-box-contact">
                <div>
                    <? while (have_rows('phones', $Auto2Credit->geo->city)):
                        the_row();
                        $phone = get_sub_field('phone');
                        ?>
                        <div>
                            <? require get_template_directory() . "/assets/img/icons/phone.svg" ?>
                            <a href="<?= phoneLink($phone) ?>"><?= $phone ?></a>
                        </div>
                    <? endwhile; ?>
                    <button class="button btn-yellow btn-sm" data-toggle="modal" data-target="#callback">Заказать
                        звонок
                    </button>
                </div>
            </div>
            <? wp_nav_menu([
                'theme_location' => 'header_menu',
                'items_wrap' => '<ul class="menu">%3$s</ul>'
            ]);
            ?>
        </nav>
        <div class="d-flex flex-column align-items-end">
            <div class="box-contact d-flex flex-column justify-content-center">
                <? while (have_rows('phones', $Auto2Credit->geo->city)):
                    the_row();
                    $phone = get_sub_field('phone');
                    ?>
                    <a href="<?= phoneLink($phone) ?>"><?= $phone ?></a>
                <? endwhile; ?>
                <button class="button btn-yellow btn-sm" data-toggle="modal" data-target="#callback">Заказать звонок
                </button>
            </div>
            <a href="#" class="geoapi-link" data-toggle="modal" data-target="#geoapi">
                <i class="fas fa-map-marker-alt"></i> <?= $Auto2Credit->geo->city->name ?>
            </a>
        </div>
        <button class="mobile-btn" id="mobile-menu" data-toggle="collapse" data-target="#navbarmenu">
            <span></span><span></span><span></span></button>
    </div>
</header>
<? if (!(is_front_page() || is_404())):
    $isOrder = get_page_template_slug() == 'pages/order.php';
    if ($isOrder):?>
        <div class="container-fluid breadcrumb-order">
    <? endif; ?>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <? if (function_exists('bcn_display')) bcn_display(); ?>
            </ol>
        </nav>
    </div>
    <? if ($isOrder): ?>
    </div>
<? endif; ?>
<? endif; ?>
<main class="content" role="main" id="app">
