<?php

class ThemeGeo
{

    public $city, $ip;

    public function __construct()
    {
        add_action('init', function () {
            $this->data();
            $this->setupCity();
        });
    }

    private function data()
    {
        register_taxonomy('city',
            ['bank', 'dealership'],
            ['label' => '',
                'labels' => [
                    'name' => 'Город',
                    'singular_name' => 'Город',
                    'search_items' => 'Искать город',
                    'all_items' => 'Новый город',
                    'view_item ' => 'Смотреть город',
                    'parent_item' => 'Родитель города',
                    'parent_item_colon' => 'Родитель города:',
                    'edit_item' => 'Редактировать город',
                    'update_item' => 'Обновить город',
                    'add_new_item' => 'Добавить город',
                    'new_item_name' => 'Город',
                    'menu_name' => 'Города',],
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true,
                'meta_box_cb' => false,
            ]);
    }

    private function setupCity()
    {
        $city_name = null;

        if (isset($_POST["city-name"]) && !empty($_POST["city-name"])) {
            setcookie('city', $_POST["city-name"], time() + (10 * 365 * 24 * 60 * 60), '/');
            $city_name = $_POST["city-name"];
        } else if (isset($_COOKIE['city']) && !empty($_COOKIE['city'])) {
            $city_name = $_COOKIE['city'];
        } else {

            $result = ['country' => '', 'city' => ''];

            $ip = $this->getIp();

            //$ip = '176.125.36.33';

            $ip_data = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

            if ($ip_data && $ip_data->geoplugin_countryName != null) {
                $result = $ip_data->geoplugin_city;
            }
            $city_name = $result;
        }

        $city = get_terms('city', [
            'meta_key' => 'slug',
            'meta_value' => $city_name
        ]);

        if (!empty($city)) {
            $this->city = $city[0];
        } else {
            $this->city = get_term(get_field('city', 'option'));
        }
    }

    public function getIp()
    {
        $client = $_SERVER['HTTP_CLIENT_IP'];
        $forward = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];
        if (filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif (filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;
        return $ip;
    }

    public function getList()
    {
        return get_terms('city', [
            'exclude' => $this->city->term_id
        ]);

    }
}