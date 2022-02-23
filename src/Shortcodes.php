<?php

namespace Pressmind\Travelshop;


class Shortcodes
{

    public function __construct()
    {
        add_shortcode('ts-list', [$this, 'list']);
        add_shortcode('ts-searchroutes', [$this, 'searchRoutes']);
        add_shortcode('ts-searchpage', [$this, 'searchPage']);
        add_shortcode('ts-layoutblock', [$this, 'layoutBlock']);
        add_shortcode('ts-modal', [$this, 'modal']);
        add_shortcode('ts-company-name', [$this, 'ts_company_name']);
        add_shortcode('ts-company-nick-name', [$this, 'ts_company_nick_name']);
        add_shortcode('ts-company-street', [$this, 'ts_company_street']);
        add_shortcode('ts-company-city', [$this, 'ts_company_city']);
        add_shortcode('ts-company-zip', [$this, 'ts_company_zip']);
        add_shortcode('ts-company-country', [$this, 'ts_company_country']);
        add_shortcode('ts-company-phone', [$this, 'ts_company_phone']);
        add_shortcode('ts-company-fax', [$this, 'ts_company_fax']);
        add_shortcode('ts-company-email', [$this, 'ts_company_email']);
        add_shortcode('ts-company-hotline', [$this, 'ts_company_hotline']);
        add_shortcode('ts-company-hotline-info', [$this, 'ts_company_hotline_info']);
        add_shortcode('ts-company-hotline-opening-times', [$this, 'ts_company_hotline_opening_times']);
        add_shortcode('ts-company-hotline-info-2', [$this, 'ts_company_hotline_info_2']);
        add_shortcode('ts-company-facebook', [$this, 'ts_company_facebook']);
        add_shortcode('ts-company-twitter', [$this, 'ts_company_twitter']);
        add_shortcode('ts-company-insta', [$this, 'ts_company_insta']);
        add_shortcode('ts-company-youtube', [$this, 'ts_company_youtube']);
        add_shortcode('ts-company-qualitybus', [$this, 'ts_company_qualitybus']);

        // TODO
        // add_shortcode('ts-ct-items', [$this, 'categoryTreeItems']);
    }

    public function ts_company_name()
    {
        return $this->get_wpsf_option('contact', 'contact', 'ts-company-name');
    }

    public function ts_company_nick_name()
    {
        return $this->get_wpsf_option('contact', 'contact', 'ts-company-nick-name');
    }

    public function ts_company_street()
    {
        return $this->get_wpsf_option('contact', 'contact', 'ts-company-street');
    }

    public function ts_company_zip()
    {
        return $this->get_wpsf_option('contact', 'contact', 'ts-company-zip');
    }

    public function ts_company_city()
    {
        return $this->get_wpsf_option('contact', 'contact', 'ts-company-city');
    }

    public function ts_company_country()
    {
        return $this->get_wpsf_option('contact', 'contact', 'ts-company-country');
    }

    public function ts_company_phone()
    {
        return $this->get_wpsf_option('contact', 'contact', 'ts-company-phone');
    }

    public function ts_company_fax()
    {
        return $this->get_wpsf_option('contact', 'contact', 'ts-company-fax');
    }

    public function ts_company_email()
    {
        return $this->get_wpsf_option('contact', 'contact', 'ts-company-email');
    }

    public function ts_company_hotline()
    {
        return $this->get_wpsf_option('contact', 'hotline', 'ts-company-hotline');
    }

    public function ts_company_hotline_info()
    {
        return $this->get_wpsf_option('contact', 'hotline', 'ts-company-hotline-info');
    }

    public function ts_company_hotline_opening_times()
    {
        return $this->get_wpsf_option('contact', 'hotline', 'ts-company-hotline-opening-times');
    }

    public function ts_company_hotline_info_2()
    {
        return $this->get_wpsf_option('contact', 'hotline', 'ts-company-hotline-info-2');
    }

    public function ts_company_facebook()
    {
        return $this->get_wpsf_option('contact', 'socialmedia', 'ts-company-facebook');
    }

    public function ts_company_twitter()
    {
        return $this->get_wpsf_option('contact', 'socialmedia', 'ts-company-twitter');
    }

    public function ts_company_insta()
    {
        return $this->get_wpsf_option('contact', 'socialmedia', 'ts-company-insta');
    }

    public function ts_company_youtube()
    {
        return $this->get_wpsf_option('contact', 'socialmedia', 'ts-company-youtube');
    }

    public function ts_company_qualitybus()
    {
        return $this->get_wpsf_option('contact', 'socialmedia', 'ts-company-qualitybus');
    }

    public function get_wpsf_option($tab_id, $section_id, $field_id)
    {
        return wpsf_get_setting('travelshop_wpsf', $tab_id . '_' . $section_id, $field_id);
    }

    /**
     * @param $atts
     * @return string
     * @example [ts-list view="Teaser1" pm-ot="123" pm-t="Italien"  pm-pr="1-1000" pm-dr=20201231-20210131 pm-*=...]
     * attr "view" defines the view template (default "Teaser1"), located in wp-content/themes/travelshop/template-parts/pm-views/*
     * @see for further Documentation and all possible attributes see readme.md section "Query API"
     */
    public function list($atts)
    {

        if (empty($atts['pm-ot'])) {
            return false;
        }

        // support constants as Object Type ID, for better theme normalization
        if (preg_match('/^([0-9]+)$/', $atts['pm-ot']) == 0) {
            $atts['pm-ot'] = constant($atts['pm-ot']);
        }

        // remap wordpress shortcode to subkeys
        foreach ($atts as $key => $value) {
            if (preg_match('/^pm\-c\-([a-zA-Z0-9_\-]+)$/', $key, $matches) > 0) {
                $atts['pm-c'][$matches[1]] = $value;
                unset($atts[$key]);
            }
        }

        $result = Search::getResult($atts,2, 12, false, false, TS_TTL_FILTER, TS_TTL_SEARCH);
        $view = 'Teaser1';
        if (empty($atts['view']) === false) {
            $view = $atts['view'];
        }
        $output = '<div class="container"><div class="row">';
        foreach ($result['items'] as $item) {
            $item['class'] = 'col-12 col-md-6 col-lg-4';
            $output .= Template::render(get_stylesheet_directory() . '/template-parts/pm-views/' . $view . '.php', $item);
        }
        $output .= '</div></div>';
        return $output;

    }


    /**
     * This Shortcode is for demo purposes only.
     * it's rendundant to the current defined routing.. so use it only for demonstration
     * @return string
     */
    public function searchRoutes()
    {
        global $config;
        global $PMTravelShop;
        $output = '<ul>';

        foreach ($config['data']['media_types_pretty_url'] as $id_object_type => $pretty_url) {

            if (!empty($config['data']['primary_media_type_ids']) && !in_array($id_object_type, $config['data']['primary_media_type_ids'])) {
                continue;
            }

            $page = RouteHelper::get_url_by_object_type($id_object_type);
            $output .= '<li><a href="' . site_url() . '/' . $page . '/' . '">' . $page . '</a></li>';
        }
        $output .= '</ul>';
        return $output;
    }

    /**
     * Delivers the default searchpage by the defined constant (see config-theme.php)
     * e.g. [ts-searchpage page="TS_TOUR_PRODUCTS"]
     * @param $atts
     * @return string|null
     */
    public function searchPage($atts)
    {
        global $PMTravelShop;
        $page = RouteHelper::get_url_by_object_type(constant($atts['page']));
        if ($page == false) {
            return null;
        }

        return site_url() . '/' . $page . '/';

    }


    /**
     * @TODO not final
     * @param $atts
     * @return string
     */
    public function categoryTreeItems($atts)
    {

        if (preg_match('/^([0-9]+)$/', $atts['pm-idt']) == 0) {
            $id_tree = $atts['pm-idt']; // TODO
        }

        $url = trim($atts['pm-href'], '/');
        $fieldname = $atts['pm-fieldname'];

        $tree = new Pressmind\Search\Filter\Category($id_tree);
        $treeItems = $tree->getResult();

        $output = '<ul>';
        foreach ($treeItems as $item) {
            $item->toStdClass();
            $href = $url . '?pm-c[' . $fieldname . ']=' . $item->id;
            $output .= '<li><a href="' . $href . '">' . $item->name . '</a></li>';

        }
        $output .= '</ul>';
        return $output;
    }


    /**
     * @param $atts
     * @return string
     */
    public function layoutBlock($atts)
    {

        if (!isset($atts['f'])) {
            return;
        }

        $layoutblock_filename = '/template-parts/layout-blocks/' . $atts['f'] . '.php';
        if (!file_exists(get_template_directory() . $layoutblock_filename)) {
            return '<pre>file not found: ' . $layoutblock_filename . '</pre>';
        }

        ob_start();
        load_template(get_template_directory() . $layoutblock_filename, false, $atts);
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    /**
     * Example:
     * [ts-modal id_post="124" name="foo foo"]
     * @param $atts
     * @return false|string
     */
    public function modal($atts)
    {

        $id_post = (int)$atts['id_post'];
        if (empty($id_post) || empty($atts['name'])) {
            return 'error: shortcode [ts-modal...] not valid, post-id or name is missing example [ts-modal id_post=123 "the link name"]';
        }


        $post = get_post($id_post);

        if (empty($post)) {
            return 'error: post for id (' . $id_post . ') for not found (cf7-shortcode [modal... ])';
        }

        $args = [
            'name' => $atts['name'],
            'title' => $post->post_title,
            'id_post' => $id_post,
            'div_only' => (!empty($atts[0]) && $atts[0] == 'create_div_only'),
            'content' => apply_filters('the_content', $post->post_content)
        ];

        ob_start();
        require get_template_directory() . '/template-parts/layout-blocks/modalscreen.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;

    }


}

