<?php
/*
Plugin Name: WP Ultimate Recipe
Plugin URI: http://www.wpultimaterecipe.com
Description: Everything a Food Blog needs. Beautiful SEO friendly recipes, print versions, visitor interaction, ...
Version: 3.12.8
Author: Bootstrapped Ventures
Author URI: http://bootstrapped.ventures
License: GPLv2
Text Domain: wp-ultimate-recipe
Domain Path: /lang
*/
define( 'WPURP_VERSION', '3.12.8' );
define( 'WPURP_POST_TYPE', 'recipe' );

class WPUltimateRecipe {

    private static $instance;
    private static $instantiated_by_premium;
    private static $addons = array();

    /**
     * Return instance of self
     */
    public static function get( $instantiated_by_premium = false )
    {
        // Instantiate self only once
        if( is_null( self::$instance ) ) {
            self::$instantiated_by_premium = $instantiated_by_premium;
            self::$instance = new self;
            self::$instance->init();
        }

        return self::$instance;
    }

    /**
     * Should we load the entire plugin or not?
     */
    public static function minimal_mode()
    {
        // No minimal mode in backend
        if( is_admin() ) return false;

        $minimal_mode = apply_filters( 'wpurp_minimal_mode', false, $_SERVER['REQUEST_URI'] );
        return $minimal_mode;
    }

    /**
     * Returns true if we are using the Premium version
     */
    public static function is_premium_active()
    {
        return self::$instantiated_by_premium;
    }

    /**
     * Add loaded addon to array of loaded addons
     */
    public static function loaded_addon( $addon, $instance )
    {
        if( !array_key_exists( $addon, self::$addons ) ) {
            self::$addons[$addon] = $instance;
        }
    }

    /**
     * Returns true if the specified addon has been loaded
     */
    public static function is_addon_active( $addon )
    {
        return array_key_exists( $addon, self::$addons );
    }

    public static function addon( $addon )
    {
        if( isset( self::$addons[$addon] ) ) {
            return self::$addons[$addon];
        }

        return false;
    }

    /**
     * Access a VafPress option with optional default value
     */
    public static function option( $name, $default = null )
    {
        $option = vp_option( 'wpurp_option.' . $name );

        if( is_null( $default ) ) {
            $default = self::get()->helper( 'vafpress_menu' )->defaults( $name );
        }

        // Force JSON-LD
        if ( 'recipe_metadata_type' == $name ) {
            return apply_filters( 'wpurp_recipe_metadata_type', 'json' );
        }

        // Chicory specific check
        if( 'partners_integrations_chicory_enable' == $name && '0' == $option ) {
            $option = '';
        }
        if( 'partners_integrations_chicory_enable' == $name && '1' == $option ) {
            $option = vp_option( 'wpurp_option.partners_integrations_chicory_terms' );
            if( count( $option ) == 0 ) {
                $option = '';
            } else {
                $option = '1';
            }
        }

        return is_null( $option ) ? $default : $option;
    }


    public $pluginName = 'wp-ultimate-recipe';
    public $coreDir;
    public $corePath;
    public $coreUrl;
    public $pluginFile;

    protected $helper_dirs = array();
    protected $helpers = array();

    /**
     * Initialize
     */
    public function init()
    {
        // Load external libraries
        require_once( 'vendor/vafpress/bootstrap.php' );
        require_once( 'vendor/taxonomy-metadata/Taxonomy_MetaData.php' );

        // Update plugin version
        update_option( $this->pluginName . '_version', WPURP_VERSION );

        // Set core directory, URL and main plugin file
        $this->corePath = str_replace( '/wp-ultimate-recipe.php', '', plugin_basename( __FILE__ ) );
        $this->coreDir = apply_filters( 'wpurp_core_dir', WP_PLUGIN_DIR . '/' . $this->corePath );
        $this->coreUrl = apply_filters( 'wpurp_core_url', plugins_url() . '/' . $this->corePath );
        $this->pluginFile = apply_filters( 'wpurp_plugin_file', __FILE__ );

        // Load textdomain
        if( !self::is_premium_active() ) {
            $domain = 'wp-ultimate-recipe';
            $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

            load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
            load_plugin_textdomain( $domain, false, $this->corePath . '/lang/' );
        }

        // Add core helper directory
        $this->add_helper_directory( $this->coreDir . '/helpers' );

        // Migrate first if needed
        $this->helper( 'migration' );

        // Load required helpers
        $this->helper( 'ajax' );
        $this->helper( 'amp' );
        $this->helper( 'activate' );
        $this->helper( 'blocks' );
        $this->helper( 'cache' );
        $this->helper( 'compatibility' );
        $this->helper( 'css' );
        $this->helper( 'faq' );
        $this->helper( 'metadata' );
        $this->helper( 'notices' );
        $this->helper( 'permalinks_flusher' );
        $this->helper( 'partners' );
        $this->helper( 'plugin_action_link' );
        $this->helper( 'print' );
        $this->helper( 'privacy' );
        $this->helper( 'query_posts' );
        $this->helper( 'recipe_content' );
        $this->helper( 'recipe_demo' );
        $this->helper( 'recipe_meta_box' );
        $this->helper( 'recipe_post_type' );
        $this->helper( 'recipe_revisions' );
        $this->helper( 'recipe_save' );
        $this->helper( 'search' );
        $this->helper( 'support_tab' );
        $this->helper( 'taxonomies' );
        $this->helper( 'thumbnails' );
        $this->helper( 'vafpress_menu' );
        $this->helper( 'vafpress_shortcode' );

        $this->helper( 'shortcodes/adjustable_shortcode' );
        $this->helper( 'shortcodes/index_shortcode' );
        $this->helper( 'shortcodes/jump_shortcode' );
        $this->helper( 'shortcodes/print_shortcode' );
        $this->helper( 'shortcodes/recipe_shortcode' );
        $this->helper( 'shortcodes/video_shortcode' );

        // Include required helpers but don't instantiate
        $this->include_helper( 'addons/addon' );
        $this->include_helper( 'addons/premium_addon' );
        $this->include_helper( 'models/recipe' );
        $this->include_helper( 'metadata_video' );

        if( !WPUltimateRecipe::minimal_mode() ) {
            // Load core addons
            $this->helper( 'addon_loader' )->load_addons( $this->coreDir . '/addons' );

            // Load default assets
            $this->helper( 'assets' );
        }
    }

    /**
     * Access a helper. Will instantiate if helper hasn't been loaded before.
     */
    public function helper( $helper )
    {
        // Lazy instantiate helper
        if( !isset( $this->helpers[$helper] ) ) {
            $this->include_helper( $helper );

            // Get class name from filename
            $class_name = 'WPURP';

            $dirs = explode( '/', $helper );
            $file = end( $dirs );
            $name_parts = explode( '_', $file );
            foreach( $name_parts as $name_part ) {
                $class_name .= '_' . ucfirst( $name_part );
            }

            // Instantiate class if exists
            if( class_exists( $class_name ) ) {
                $this->helpers[$helper] = new $class_name();
            }
        }

        // Return helper instance
        return $this->helpers[$helper];
    }

    /**
     * Include a helper. Looks through all helper directories that have been added.
     */
    public function include_helper( $helper )
    {
        foreach( $this->helper_dirs as $dir )
        {
            $file = $dir . '/'.$helper.'.php';

            if( file_exists( $file ) ) {
                require_once( $file );
            }
        }
    }

    /**
     * Add a directory to look for helpers.
     */
    public function add_helper_directory( $dir )
    {
        if( is_dir( $dir ) ) {
            $this->helper_dirs[] = $dir;
        }
    }

    /*
     * Quick access functions
     */

    public function tags()
    {
        return $this->helper( 'taxonomies' )->get();
    }

    public function query()
    {
        return $this->helper( 'query_recipes' );
    }

    public function template( $type, $template )
    {
        return $this->addon( 'custom-templates' )->get_template( $type, $template );
    }

    // Source: http://wordpress.stackexchange.com/questions/198435/how-to-convert-datetime-to-display-time-based-on-wordpress-timezone-setting
    public function timezone()
    {
        $tzstring = get_option( 'timezone_string' );
        $offset   = get_option( 'gmt_offset' );

        //Manual offset...
        //@see http://us.php.net/manual/en/timezones.others.php
        //@see https://bugs.php.net/bug.php?id=45543
        //@see https://bugs.php.net/bug.php?id=45528
        //IANA timezone database that provides PHP's timezone support uses POSIX (i.e. reversed) style signs
        if( empty( $tzstring ) && 0 != $offset && floor( $offset ) == $offset ){
            $offset_st = $offset > 0 ? "-$offset" : '+'.absint( $offset );
            $tzstring  = 'Etc/GMT'.$offset_st;
        }

        //Issue with the timezone selected, set to 'UTC'
        if( empty( $tzstring ) ){
            $tzstring = 'UTC';
        }

        if( $tzstring instanceof DateTimeZone ){
            return $tzstring;
        }

        date_default_timezone_set( $tzstring );
        $timezone = new DateTimeZone( $tzstring );
        return $timezone;
    }
}

// Premium version is responsible for instantiating and Freemius Integration if available
if( !class_exists( 'WPUltimateRecipePremium' ) ) {
    // Freemius Integration.
    if ( ! function_exists( 'wpurp_fs' ) ) {
        // Create a helper function for easy SDK access.
        function wpurp_fs() {
            global $wpurp_fs;

            if ( ! isset( $wpurp_fs ) ) {
                // Include Freemius SDK.
                require_once dirname(__FILE__) . '/freemius/start.php';

                $wpurp_fs = fs_dynamic_init( array(
                    'id'                  => '3573',
                    'slug'                => 'wp-ultimate-recipe',
                    'type'                => 'plugin',
                    'public_key'          => 'pk_e26dd45a00dd68423c1a9892dfb46',
                    'is_premium'          => false,
                    'premium_suffix'      => 'Premium',
                    // If your plugin is a serviceware, set this option to false.
                    'has_premium_version' => true,
                    'has_addons'          => false,
                    'has_paid_plans'      => true,
                    'menu'                => array(
                        'slug'           => 'edit.php?post_type=recipe',
                        'contact'        => false,
                        'support'        => false,
                    ),
                    'is_live'            => true,
                ) );
            }

            return $wpurp_fs;
        }

        // Init Freemius.
        wpurp_fs();
        // Signal that SDK was initiated.
        do_action( 'wpurp_fs_loaded' );
    }

    WPUltimateRecipe::get();
}