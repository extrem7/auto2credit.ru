<?php
require_once "classes/ThemeBase.php";
require_once "classes/ThemeGeo.php";

class Auto2Credit extends ThemeBase
{
    public $geo;

    private $wpdb;

    public function __construct()
    {
        parent::__construct();
        add_action('init', function () {
            $this->registerTaxonomies();
            $this->registerPostTypes();
        });
        add_action('plugins_loaded', function () {
            $this->geo = new ThemeGeo();
        });
        add_action('wp_enqueue_scripts', function () {
            if (get_page_template_slug() == "pages/order.php") {
                wp_localize_script('main', 'Data', $this->orderData());
            }
        });
        foreach (['contact', 'exbico', 'order'] as $action) {
            add_action("wp_ajax_$action", [$this, $action]);
            add_action("wp_ajax_nopriv_$action", [$this, $action]);
        }
        global $wpdb;
        $this->wpdb = $wpdb;
        date_default_timezone_set('Europe/Moscow');
    }

    public function orderData()
    {
        $data = [];

        $cities = get_terms('city');
        $data['city'] = $this->geo->city->term_id;
        foreach ($cities as $city) {
            $data['cities'][$city->term_id] = [
                'name' => $city->name,
                'phones' => array_map(function ($phone) {
                    return $phone['phone'];
                }, get_field('phones', $city))
            ];
        }

        $car_brands = get_terms('car_brand');
        foreach ($car_brands as $brand) {
            $data['brands'][$brand->term_id] = $brand->name;
        }

        $dealerships = get_posts([
            'post_type' => 'dealership',
            'posts_per_page' => -1
        ]);
        foreach ($dealerships as $dealership) {
            $city = wp_get_post_terms($dealership->ID, 'city')[0]->term_id;
            $car_brands = wp_get_post_terms($dealership->ID, 'car_brand');
            $data['dealerships'][] = [
                'id' => $dealership->ID,
                'title' => $dealership->post_title,
                'city' => $city,
                'brands' => array_map(function ($brand) {
                    return $brand->term_id;
                }, $car_brands)
            ];
        }

        $intervals = get_field('time_intervals', 'options');
        $data['intervals'] = array_map(function ($interval) {
            return $interval['time'];
        }, $intervals);

        $data['banks']['vtb']['link'] = get_permalink(133);

        $data['texts'] = get_field('texts', 'option');

        $data['politic'] = get_permalink(182);
        $data['nonce'] = wp_create_nonce();
        return $data;
    }

    //mail methods
    public function order($subject = '', $exbico = false)
    {
        $headers = $this->getHeaders();
        if (!$exbico) {
            $this->checkNonce();
            $subject = 'Заявка на сделку Auto2Credit';
        }
        $fields = [];

        $fields['Дата заполнения'] = date('d.m.Y');
        $fields['Время заполнения'] = date('G:i');
        $fields['Имя клиента'] = $_POST['firstName'] ?? null;
        $fields['Фамилия клиента'] = $_POST['lastName'] ?? null;
        $fields['Телефон клиента'] = $_POST['phone'] ?? null;
        $fields['Почта'] = $_POST['email'] ?? null;
        $fields['Паспорт'] = $_POST['passport'] ?? null;
        $fields['Дата рождения'] = $_POST['dateBirth'] ?? null;
        $fields['Дата паспорта'] = $_POST['datePassport'] ?? null;
        $fields['Город'] = $_POST['city'] ?? null;
        if (!$exbico) {
            $fields['Марка'] = $_POST['brand'] ?? null;
            $fields['Дилерский центр'] = $_POST['dealership']['title'] ?? null;
            $fields['Дата сделки'] = $_POST['dateDeal'] ?? null;
            $fields['Время сделки'] = $_POST['time'] ?? null;
        }
        $fields['Кредит по стоимости'] = $_POST['byPrice'] ?? null;
        $fields['Кредит по платежу'] = $_POST['byPayment'] ?? null;
        $fields['Цена авто'] = $_POST['price'] ?? null;

        $message = $this->generateMessage($fields);

        $emailCenter = $exbico ? get_field('loan_rating', 'option')['email'] : get_field('email', get_post($_POST['dealership']['id']));

        $mail = mail($emailCenter, $subject, $message, $headers);
        if (!$exbico) {
            if ($mail) {
                echo json_encode(['status' => 'ok']);
            } else {
                echo json_encode(['status' => 'error']);
            }
            exit;
        }
    }

    public function contact()
    {
        $headers = $this->getHeaders();

        $subject = 'Заказать звонок Auto2Credit';

        $fields = [];

        $name = null;
        $phone = null;

        if (isset($_POST['name']) && $_POST['name']) {
            $name = $_POST['name'];
        }
        if (isset($_POST['tel']) && $_POST['tel']) {
            $phone = $_POST['tel'];
        }

        $fields['Дата заполнения'] = date('d.m.Y');
        $fields['Время заполнения'] = date('G:i');
        $fields['Имя клиента'] = $name ? $name : '-';
        $fields['Телефон клиента'] = $phone ? $phone : '-';

        $message = $this->generateMessage($fields);

        $mail = mail(get_field('email', $this->geo->city), $subject, $message, $headers);

        if ($mail) {
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        wp_die();
    }

    private function getHeaders()
    {
        $headers = "From: Auto2Credit <admin@" . $_SERVER['SERVER_NAME'] . ">\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=utf-8' . "\r\n";
        return $headers;
    }

    private function generateMessage($fields)
    {
        $message = "<html><head></head><body><table border=\"1\" cellpadding=\"7\" cellspacing=\"0\" bordercolor=\"#CCCCCC\">";
        foreach ($fields as $key => $field) {
            $message .= "<tr><td>$key</td><td>$field</td></tr>";
        }
        $message .= "</table><br><p>Данное сообщение сгенерировано автоматически. Пожалуйста, не отвечайте на него.</p>";
        $message .= "</body></html>";
        return $message;
    }

    //exbico methods
    public function exbico()
    {
        $this->checkNonce();

        $firstName = $_POST['firstName'] ?? null;
        $lastName = $_POST['lastName'] ?? null;
        $passport = isset($_POST['passport']) ? str_replace(' ', '', $_POST['passport']) : null;
        $dateBirth = $_POST['dateBirth'] ?? null;
        $datePassport = $_POST['datePassport'] ?? null;
        $price = $_POST['price'] ? intval($_POST['price']) : 1000000;

        if ($firstName && $lastName && $passport && $dateBirth && $datePassport) {

            $this->checkIpLimit();

            $series = substr($passport, 0, 4);
            $number = substr($passport, 4);

            $this->order('Заявка на проверку документов Auto2Credit', true);

            if ($this->xml($firstName, $lastName, $series, $number, $price)) {
                echo json_encode(['status' => 'ok']);
            } else {
                status_header(405);
                echo json_encode(['status' => 'denied']);
            }
        } else {
            echo json_encode(['status' => 'validation_error']);
        }

        exit;
    }

    private function xml($firstName, $lastName, $series, $number, $amount)
    {
        $passport = $this->checkPassport($series, $number);

        if ($passport == 'ok') {
            return true;
        } else if ($passport == 'denied') {
            return false;
        }

        $xml = require_once('includes/exbico.php');
        $context = stream_context_create([
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => $xml
            ]
        ]);
        $result = file_get_contents("http://api.exbico.ru/se/crm_V4_1", false, $context);
        if ($result === FALSE) return false;

        $xml = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);
        $this->wpdb->insert('ac_exbico', ['name' => "$firstName $lastName", 'json' => json_encode($xml)]);

        if ($xml->status !== -1) {
            $docCheck = $xml->response->docCheck;
            $docValid = array_search('Y', [$docCheck->lost, $docCheck->invalid, $docCheck->wanted]) === false;
            if ($docCheck->found == "Y" && $docValid) {
                if ($xml->status == 1) {
                    return true;
                } else if ($xml->status == 2) {
                    return false;
                } else {
                    $loanRating = $xml->response->loanRating;
                    if (!empty($loanRating)) {
                        $setting = get_field('loan_rating', 'option');
                        $totalOverdue = $loanRating->totalOverdue;
                        $delay = $loanRating->delay;
                        $and = $setting['and'];
                        $denied = null;
                        $totalOverdue = 1500;
                        $delay = 1;
                        if ($and) {
                            $denied = $totalOverdue >= $setting['total_overdue'] && $delay >= $setting['delay'];
                        } else {
                            $denied = $totalOverdue >= $setting['total_overdue'] || $delay >= $setting['delay'];
                        }
                        if (!$denied) {
                            $this->addPassport($series, $number, true);
                        }
                        return !$denied;
                    }
                }
            }
        }
        $this->addPassport($series, $number, false);
        //var_dump($xml);
        //  $xml = json_encode($xml);
        // $xml = json_decode($xml, TRUE);
        //var_dump($xml->status!== -1);
        return false;
    }

    private function addPassport($series, $number, $status)
    {
        $passport = "$series$number";
        if ($this->wpdb->get_row("SELECT * FROM `ac_passports` WHERE passport = $series$number")) {
            $this->wpdb->update('ac_passports', ['status' => $status, 'date' => current_time('mysql')], ['passport' => $passport]);
        } else {
            $this->wpdb->insert('ac_passports', ['passport' => $passport, 'status' => $status]);
        }
    }

    public function checkPassport($series, $number)
    {
        $passport = $this->wpdb->get_row("SELECT * FROM `ac_passports` WHERE passport = $series$number");
        $currentDate = new DateTime();
        $passportDate = new DateTime($passport->date);
        $interval = $currentDate->diff($passportDate);
        $days = $interval->days;

        if ($passport) {
            if ($passport->status == false && $days <= 100) return 'denied';
            if ($passport->status == true && $days <= 30) return 'ok';
        }
    }

    private function checkIpLimit()
    {
        $ip = ip2long($this->geo->getIp());
        $user = $this->wpdb->get_row("SELECT * FROM `ac_ip` WHERE ip = $ip");
        if ($user) {
            if ($user->count >= get_field('ip_limit', 'option')) {
                status_header(429);
                wp_die(json_encode(['status' => 'ip_limit']));
            }
            $this->wpdb->update('ac_ip', ['count' => $user->count + 1], ['ip' => $ip]);
        } else {
            $this->wpdb->insert('ac_ip', ['ip' => $ip, 'count' => 1]);
        }
    }

    private function checkNonce()
    {
        if (!wp_verify_nonce($_POST['nonce'])) {
            status_header(401);
            exit(json_encode(['status' => 'denied']));
        }
    }

    //theme methods
    public function views()
    {
        return new class
        {
            public function video()
            {
                get_template_part('views/video');
            }
        };
    }

    private function registerTaxonomies()
    {
        register_taxonomy('car_brand',
            ['bank', 'dealership'],
            ['label' => '',
                'labels' => [
                    'name' => 'Марка автомобиля',
                    'singular_name' => 'Марка автомобиля',
                    'search_items' => 'Искать марку автомобиля',
                    'all_items' => 'Новая Марка автомобиля',
                    'view_item ' => 'Смотреть марку автомобиля',
                    'parent_item' => 'Родитель марки',
                    'parent_item_colon' => 'Родитель марки:',
                    'edit_item' => 'Редактировать марку автомобиля',
                    'update_item' => 'Обновить марку автомобиля',
                    'add_new_item' => 'Добавить новую марку автомобиля',
                    'new_item_name' => 'Марка автомобиля',
                    'menu_name' => 'Марки автомобиля'],
                'public' => true,
                'publicly_queryable' => false,
                'hierarchical' => true,
                'show_admin_column' => true,
                'meta_box_cb' => false,
            ]);
    }

    private function registerPostTypes()
    {
        register_post_type('bank',
            ['label' => null,
                'labels' => [
                    'name' => 'Банки',
                    'singular_name' => 'Банк',
                    'add_new' => 'Добавить банк',
                    'add_new_item' => 'Добавление банка',
                    'edit_item' => 'Редактирование банка',
                    'new_item' => '',
                    'view_item' => 'Смотреть банк',
                    'search_items' => 'Искать банк',
                    'not_found' => 'Не найдено',
                    'not_found_in_trash' => 'Не найдено в корзине',
                    'menu_name' => 'Банки',
                ],
                'public' => true,
                'menu_position' => 6,
                'menu_icon' => 'dashicons-building',
                'supports' => ['title', 'editor', 'custom-fields'],
                'has_archive' => false,
                'rewrite' => ['slug' => ''],]);
        register_post_type('dealership',
            ['label' => null,
                'labels' => [
                    'name' => 'Дилерские центры',
                    'singular_name' => 'Дилерский центр',
                    'add_new' => 'Добавить дилерский центр',
                    'add_new_item' => 'Добавление дилерского центра',
                    'edit_item' => 'Редактирование дилерского центра',
                    'new_item' => '',
                    'view_item' => 'Смотреть дилерский центр',
                    'search_items' => 'Искать дилерский центр',
                    'not_found' => 'Не найдено',
                    'not_found_in_trash' => 'Не найдено в корзине',
                    'menu_name' => 'Дилерские центры',
                ],
                'public' => true,
                'publicly_queryable' => false,
                'menu_position' => 6,
                'menu_icon' => 'dashicons-store',
                'supports' => ['title', 'custom-fields'],
                'has_archive' => false,
                'rewrite' => ['slug' => ''],]);
    }

}