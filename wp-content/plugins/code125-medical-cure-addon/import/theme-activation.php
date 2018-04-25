<?php

class C5_theme_activation {

    public $_sections = array();
    public $_options = array();
    public $_theme_name = 'Master';
    public $_theme_videos_url = '';
    public $_theme_docs_url = '';

    function __construct() {

    }

    function hook() {

        add_action('admin_init', array($this, 'admin_init'));
    }

    function admin_init() {
        if (isset($_GET['demo_type'])) {

            global $wpdb;

            if (!defined('WP_LOAD_IMPORTERS'))
            define('WP_LOAD_IMPORTERS', true);

            // Load Importer API
            require_once ABSPATH . 'wp-admin/includes/import.php';

            if (!class_exists('WP_Importer')) {
                $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
                if (file_exists($class_wp_importer)) {
                    require $class_wp_importer;
                }
            }

            if (!class_exists('WP_Import') ) {
                $class_wp_importer = C5_IMPORT_ROOT . "wordpress-importer/wordpress-importer.php";
                if (file_exists($class_wp_importer))
                require $class_wp_importer;
            }


        }
    }

    function install_html() {
        if (isset($_GET['demo_type'])) {

            $type = $_GET['demo_type'];
            $id = $_GET['demo_id'];

            $all_objects = $this->all_demos();

            $info = $all_objects[$id];

            echo '<pre>';
            if ($type == 'demo' || $type == 'options') {
                $this->import_theme_options($info['theme-options']);
                c5_register_sidebars();
                echo '<p>Theme Options installed ...</p>';
            }


            if ($type == 'demo' || $type == 'widget') {
                $this->update_sidebars($info['widgets']);
                echo '<p>Sidebar installed ...</p>';
            }

            if (class_exists('WP_Import') && $type == 'demo') {
                $import_filepath = $info['xml'];

                $wp_import = new WP_Import();
                $wp_import->fetch_attachments = true;
                $wp_import->import($import_filepath);
                do_action( 'code125-after-demo-import' , $info['slug'] );
                echo '<p>Demo installed ...</p>';

                $this->update_page_media();

                if (apply_filters( 'code125-activation-category-filter', true )) {
                    $this->update_categories_ids();
                    $this->update_categories_colors();

                    $obj = new C5_header_css();
                    $terms = $obj->create_terms_array();
                    update_option( 'c5_terms_settings', $terms );
                }




                $nav_menu_locations = array();
                $nav_menu_locations= apply_filters( 'c5_import_menu_locations', $nav_menu_locations );


                set_theme_mod('nav_menu_locations', $nav_menu_locations);

                $home = get_page_by_title($info['homepage']);
                update_option('page_on_front', $home->ID);
                update_option('show_on_front', 'page');


                $demo_url = 'code125.com';

                $old_settings = get_option('option_tree');

                $old_settings['preview'] = 'off';

                foreach ($old_settings as $key => $value) {
                    if (is_array($value)) {
                        continue;
                    }

                    if (strpos($value, $demo_url) && !strpos($value, 'files.' . $demo_url)) {
                        $info = explode('/', $value);
                        $index = count($info) - 1;
                        $new_value = $this->get_attachment_id_from_filename($info[$index]);
                        if ($new_value != '') {
                            $old_settings[$key] = $new_value;
                        }
                    }
                }


                update_option('option_tree', $old_settings);

                //update arqm data
                c5_set_arq_saved_data();
            }
            echo '</pre>';

            echo '<a href="' . admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab=quick_setup') . '" class="button button-hero pull-right button-primary">'. esc_html__('Continue', 'medical-cure') .' <span class="fa fa-chevron-right"></span></a>';
            echo '<div class="clearfix"></div>';
        }
    }

    public function update_page_media()
    {
        echo '<p>Updating Page Builder Media ...</p>';
        $obj = new C5AB_Theme_Templates();
        $args = array(
        	'post_type'   => 'page',
            'posts_per_page' => -1
        );
        $page_query = new WP_Query( $args );

        // The Loop
        if ( $page_query->have_posts() ) {
        	while ( $page_query->have_posts() ) {
        		$page_query->the_post();
                $post_id = get_the_ID();
                $data = get_post_meta( $post_id, 'c5ab_data' , true);
                $data = $obj->validate_template_data($data);
                $return = update_post_meta( $post_id,'c5ab_data', $data);

        	}
        }
        /* Restore original Post Data */
        wp_reset_postdata();
    }

    function hook_page() {
        $this->_theme_name = apply_filters( 'c5_theme_name', $this->_theme_name );
        $this->_theme_videos_url = apply_filters( 'c5_theme_videos_url', $this->_theme_videos_url );
        $this->_theme_docs_url = apply_filters( 'c5_theme_docs_url', $this->_theme_docs_url );

        add_submenu_page(C5_SLUG_ABOUT, 'Install Demos', 'Install Demos', 'edit_pages', C5_SLUG_DEMOS_INSTALL, array($this, 'import_page'));
    }

    function all_demos() {
        $demos = array();
        $demos = apply_filters( 'c5_import_demo_data', $demos );
        return $demos;
    }
    function dummy_html(){
        ?>
        <?php if (isset($_GET['activated'])) { ?>
            <h2 ><span class="fa fa-check-square-o"></span> Successfully Activated...</h2>
            <p class="about-description"><?php echo $this->_theme_name; ?> Theme has been activated, Thank you for choosing <?php echo $this->_theme_name; ?>, we recommend you to see the following resources for help.</p>
            <?php } else { ?>
                <p>Thank you for choosing <?php echo $this->_theme_name; ?>, we recommend you to see the following resources for help.</p>
                <?php } ?>
            </div>


            <div class="feature-section col three-col">

                <div class="col">
                    <h4>Quick Setup</h4>
                    <p>We grouped the most important settings you might need to set in initial setup.</p>
                    <a href="<?php echo admin_url('index.php?page=c5-quick-setup'); ?>" target="_blank" class="button button-primary button-large">Start Here</a>
                </div>

                <div class="col ">
                    <h4>Check Online Documentation</h4>
                    <p>Check our online documentation for more updated on how to use your theme and make the best of it.</p>
                    <a href="<?php echo $this->_theme_docs_url; ?>" target="_blank" class="button button-primary button-large">Check it here</a>
                </div>
                <div class="col ">
                    <h4>Check Online Video Tutorials</h4>
                    <p>Check our online video tutorials to make the best out of this product.</p>
                    <a href="<?php echo $this->_theme_videos_url; ?>" target="_blank" class="button button-primary button-large">Check it here</a>
                </div>


            </div>
        <?php
    }

    function import_page() {
        ?>

            <h1>Install Demos</h1>
            <div class="about-text">
                <p>To learn about how our pages was built. We prepared a handful demos to install and start your website. You will get all the pages and posts in the demo page you visited before purchasing this theme.</p>
            </div>
            <?php $this->install_html(); ?>
                <div class="feature-section col three-col clearfix">
                    <?php
                    foreach ($this->all_demos() as $id => $info) {
                        ?>
                        <div class="col">
                            <div class="c5-import-signle">
                                <h4><a href="<?php echo $info['demo_url'] ?>" target="_blank"><?php echo $info['label'] ?></a></h4>
                                <div class="item-wrap">
                                    <div class="img-wrap">
                                        <img src="<?php echo $info['img'] ?>" alt="" />
                                    </div>
                                    <div class="buttons-wrap">
                                        <a class="button-primary button-large button c5-install-button" href="<?php echo admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab=import&demo_type=demo&demo_id=' . $id); ?>" >Install Complete Demo</a>
                                        <a class="button-primary button-large button c5-install-button" href="<?php echo admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab=import&demo_type=widget&demo_id=' . $id); ?>" >Install Only Widgets</a>
                                        <a class="button-primary button-large button c5-install-button" href="<?php echo admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab=import&demo_type=options&demo_id=' . $id); ?>">Install Only Theme Options</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <a href="<?php echo admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab=quick_setup') ?>" class="button button-hero pull-right button-primary"><?php echo esc_html__('Skip', 'medical-cure') ?> <span class="fa fa-chevron-right"></span></a>
                </div>
                <?php
            }

            function get_categories_info(){
                $url = 'http://files.code125.com/alyoum/categories.txt';
                $url = apply_filters( 'c5_import_categories_url', $url );
                $get_data = wp_remote_get($url);

                if (is_wp_error($get_data))
                return false;

                $rawdata = isset($get_data['body']) ? $get_data['body'] : '';
                $options = unserialize(ot_decode($rawdata));

                return $options;
            }

            function generate_categories_info(){
                $args = array(
                    'type'                     => 'post',
                    'child_of'                 => 0,
                    'parent'                   => '',
                    'orderby'                  => 'name',
                    'order'                    => 'ASC',
                    'hide_empty'               => 1,
                    'hierarchical'             => 1,
                    'exclude'                  => '',
                    'include'                  => '',
                    'number'                   => '',
                    'taxonomy'                 => 'category',
                    'pad_counts'               => false

                );
                $categories = get_categories(  $args );
                $list = array();
                foreach ($categories as $category) {
                    $list[$category->slug] = array(
                        'color' =>  get_option('c5_term_meta_category_' . $category->term_id . '_primary_color'),
                        'icon' =>   get_option('c5_term_meta_category_' . $category->term_id . '_icon'),
                        'old_id' => $category->term_id
                    );
                }
                print_r(base64_encode(serialize($list)));
            }

            function update_categories_colors() {
                $old_categories = $this->get_categories_info();
                foreach ($old_categories as $slug => $values) {
                    $cat = get_category_by_slug($slug);
                    $term_id = $cat->term_id;

                    update_option('c5_term_meta_category_' . $term_id . '_use_custom_colors', 'on');
                    update_option('c5_term_meta_category_' . $term_id . '_primary_color', $values['color']);
                    update_option('c5_term_meta_category_' . $term_id . '_title_color', $values['color']);
                    update_option('c5_term_meta_category_' . $term_id . '_icon', $values['icon']);
                }
            }

            function update_categories_ids() {
                $old_categories  = $this->get_categories_info();
                $replace_array = array();
                foreach ($old_categories as $slug => $category) {
                    $cat = get_category_by_slug($slug);
                    if ($cat->term_id != $category['old_id']) {
                        $replace_array[$category['old_id']] = $cat->term_id;
                    }
                }

                if (count($replace_array) != 0) {
                    $args = array(
                        'post_type' => 'page',
                        'posts_per_page' => -1
                    );
                    // The Query
                    $the_query = new WP_Query($args);

                    // The Loop
                    if ($the_query->have_posts()) {
                        while ($the_query->have_posts()) {
                            $the_query->the_post();
                            $raw_data = get_post_meta(get_the_ID(), 'c5ab_data', true);
                            if ($raw_data != '') {
                                $raw_data = base64_decode($raw_data);
                                $data = unserialize($raw_data);
                                $raw_data = json_encode($data);
                                foreach ($replace_array as $old_ID => $new_ID) {
                                    $raw_data = str_replace('post#category#' . $old_ID, 'post!#category!#' . $new_ID, $raw_data);
                                }
                                $raw_data = str_replace('post!#category!#', 'post#category#', $raw_data);

                                $data = json_decode($raw_data, true);
                                $raw_data = serialize($data);
                                $raw_data = base64_encode($raw_data);
                                update_post_meta(get_the_ID(), 'c5ab_data', $raw_data);
                            }
                        }
                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();
                }
                $page = get_page_by_title('Hello world!', 'OBJECT', 'post');
                wp_delete_post($page->ID,true);
            }

            function update_sidebars($base_url) {
                //		$base_url = 'http://files.code125.com/master/main-sidebar.json';
                $get_data = wp_remote_get($base_url);

                if (is_wp_error($get_data))
                return false;

                $rawdata = isset($get_data['body']) ? $get_data['body'] : '';
                $options = json_decode($rawdata);
                $sidebars = $options[0];
                $data = array();
                foreach ($sidebars as $sidebar => $value) {
                    $data[$sidebar] = $value;
                }
                $data['wp_inactive_widgets'] = array();
                update_option('sidebars_widgets', $data);
                $widgets = $options[1];

                foreach ($widgets as $widget => $value) {
                    if ($widget != '_empty_') {
                        $value = (array) $value;

                        $new_value = array();
                        foreach ($value as $key => $value_2) {
                            $new_value[$key] = (array) $value_2;
                        }
                        update_option('widget_' . $widget, $new_value);
                    }
                }
            }

            /**
            * The main controller for the import theme options.
            *
            * @param string $file Path to the text file for importing
            */
            function import_theme_options($data_file) {
                $get_data = wp_remote_get($data_file);

                if (is_wp_error($get_data))
                return false;

                $rawdata = isset($get_data['body']) ? $get_data['body'] : '';
                $options = unserialize(ot_decode($rawdata));

                /* get settings array */
                $settings = get_option('option_tree_settings');

                /* has options */
                if (is_array($options)) {

                    /* validate options */
                    if (is_array($settings)) {

                        foreach ($settings['settings'] as $setting) {
                            if (isset($setting['id'])) {
                                if (isset($options[$setting['id']])) {

                                    $content = ot_stripslashes($options[$setting['id']]);

                                    $options[$setting['id']] = ot_validate_setting($content, $setting['type'], $setting['id']);
                                }
                            }
                        }
                    }

                    /* update the option tree array */
                    update_option('option_tree', $options);
                }
            }

            function get_wp_options() {
                $args = array(
                    'orderby' => 'name',
                    'order' => 'ASC'
                );
                $info_data = array(
                    'primary_color',
                    'icon'
                );
                $tax = 'category';
                $data = array();
                $categories = get_categories($args);
                foreach ($categories as $category) {
                    $info = array();
                    foreach ($info_data as $single_info) {
                        $info[$single_info] = get_option('c5_term_meta_category_' . $category->term_id . '_' . $single_info);
                    }
                    $data[$category->slug] = $info;
                }

                print_r(base64_encode(serialize($data)));
            }

            function get_attachment_id_from_filename($name) {
                global $wpdb;

                $query = "SELECT guid FROM {$wpdb->posts} WHERE guid LIKE '%{$name}%'";
                $id = $wpdb->get_var($query);

                return $id;
            }

        }

        $c5_import_demo = new C5_theme_activation();
        $c5_import_demo->hook();
        ?>
