<?php

class Yz_Ads_Settings {

    /**
     * # Ads Settings.
     */
    function settings() {

        global $Youzer_Admin, $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'msg_type' => 'info',
                'type'     => 'msgBox',
                'title'    => __( 'info', 'youzer' ),
                'id'       => 'yz_msgbox_ads_placement',
                'msg'      => __( 'All the ads created will be added automatically to the bottom of the profile sidebar to change their placement or control their visibility go to <strong>Youzer Panel > Profile Settings > Profile Structure</strong>.', 'youzer' )
            )
        );

        $modal_args = array(
            'id'        => 'yz-ads-form',
            'title'     => __( 'create new ad', 'youzer' ),
            'button_id' => 'yz-add-ad'
        );

        // Get 'Create new ad' Form.
        $Youzer_Admin->panel->modal( $modal_args, array( &$this, 'create_new_AD_form' ) );

        // Get Exists Ads.
        $this->get_ads();

        $Yz_Settings->get_field(
            array(
                'title' => __( 'general Settings', 'youzer' ),
                'type'  => 'openBox'
            )
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'loading effect', 'youzer' ),
                'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
                'desc'  => __( 'choose how you want your ad to be loaded ?', 'youzer' ),
                'id'    => 'yz_ads_load_effect',
                'type'  => 'select'
            )
        );

        $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
    }

    /**
     * # Create New AD Form.
     */
    function create_new_AD_form() {

        // Get Data.
        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'type'  => 'openDiv',
                'class' => 'yz-ads-form'
            )
        );

        $Yz_Settings->get_field(
            array(
                'title'      => __( 'is sponsored ?', 'youzer' ),
                'desc'       => __( 'Display "sponsored" title above the ad', 'youzer' ),
                'id'         => 'yz_ad_is_sponsored',
                'type'       => 'checkbox',
                'no_options' => true
            )
        );

        $Yz_Settings->get_field(
            array(
                'title'      => __( 'AD Name', 'youzer' ),
                'id'         => 'yz_ad_title',
                'desc'       => __( "you'll use it in the profile structure", 'youzer' ),
                'type'       => 'text',
                'no_options' => true
            )
        );

        $Yz_Settings->get_field(
            array(
                'title'      => __( 'AD type', 'youzer' ),
                'id'         => 'yz_ad_type',
                'desc'       => __( 'choose the ad type', 'youzer' ),
                'std'        => 'banner',
                'no_options' => true,
                'type'       => 'radio',
                'opts'       => array(
                    'banner'  => __( 'banner', 'youzer' ),
                    'adsense' => __( 'adsense code', 'youzer' )
                ),
            )
        );

        //Banner Options
        $Yz_Settings->get_field(
            array(
                'type'  => 'openDiv',
                'class' => 'yz-adbanner-items'
            )
        );

            $Yz_Settings->get_field(
                array(
                    'title'      => __( 'AD Url', 'youzer' ),
                    'id'         => 'yz_ad_url',
                    'desc'       => __( 'ad banner link url', 'youzer' ),
                    'type'       => 'text',
                    'no_options' => true
                )
            );

             $Yz_Settings->get_field(
                array(
                    'title'      => __( 'AD Banner', 'youzer' ),
                    'id'         => 'yz_ad_banner',
                    'desc'       => __( 'uplaod ad banner image', 'youzer' ),
                    'type'       => 'upload',
                    'no_options' => true
                )
            );

        $Yz_Settings->get_field( array( 'type' => 'closeDiv' ) );

        // Ad Code Options
        $Yz_Settings->get_field(
            array(
                'type'  => 'openDiv',
                'class' => 'yz-adcode-item'
            )
        );

        $Yz_Settings->get_field(
            array(
                'title'      => __( 'AD Code', 'youzer' ),
                'id'         => 'yz_ad_code',
                'desc'       => __( 'put your adsense code here', 'youzer' ),
                'type'       => 'textarea',
                'no_options' => true
            )
        );

        $Yz_Settings->get_field( array( 'type' => 'closeDiv' ) );

        // Add Hidden Input
        $Yz_Settings->get_field(
            array(
                'id'         => 'yz_ads_form',
                'type'       => 'hidden',
                'class'      => 'yz-keys-name',
                'std'        => 'yz_ads',
                'no_options' => true
            )
        );

        $Yz_Settings->get_field( array( 'type' => 'closeDiv' ) );

    }

    /**
     * Get Ads List
     */
    function get_ads() {

        global $Yz_Settings;

        // Get Ads Items
        $yz_ads = yz_options( 'yz_ads' );

        // Next Ad ID
        $yz_nextAD = yz_options( 'yz_next_ad_nbr' );
        $yz_nextAD = ! empty( $yz_nextAD ) ? $yz_nextAD : 1;

        ?>

        <script> var yz_nextAD = <?php echo $yz_nextAD; ?>; </script>

        <div class="yz-custom-section">
            <div class="yz-cs-head">
                <div class="yz-cs-buttons">
                    <button class="yz-md-trigger yz-ads-button" data-modal="yz-ads-form">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <?php _e( 'add new ad', 'youzer' ); ?>
                    </button>
                </div>
            </div>
        </div>

        <ul id="yz_ads" class="yz-cs-content">

        <?php

            // Show No Ads Found .
            if ( empty( $yz_ads ) ) {
                global $Yz_Translation;
                $msg = $Yz_Translation['no_ads'];
                echo "<p class='yz-no-content yz-no-ads'>$msg</p></ul>";
                return false;
            }

            foreach ( $yz_ads as $ad => $data ) :

                // Get Widget Data.
                $url            = $data['url'];
                $code           = $data['code'];
                $type           = $data['type'];
                $title          = $data['title'];
                $banner         = $data['banner'];
                $is_sponsored   = $data['is_sponsored'];

                // Ad photo background.
                $banner_img = ( $type == 'banner' ) ? "style='background-image:url($banner);'" : null;
                $code_icon  = ( $type == 'adsense' ) ? 'yz_show_icon' : 'yz_hide_icon';

                // Get Field Name.
                $name = "yz_ads[$ad]";

                ?>

                <!-- AD Item -->
                <li class="yz-ad-item" data-ad-name="<?php echo $ad; ?>">
                    <div class="yz-ad-img <?php echo $code_icon; ?>" <?php echo $banner_img; ?>>
                        <i class="fa fa-code" aria-hidden="true"></i>
                    </div>
                    <div class="yz-ad-data">
                        <h2 class="yz-ad-title"><?php echo $title; ?></h2>
                        <div class="yz-ad-actions">
                            <a class="yz-edit-item yz-edit-ad"></a>
                            <a class="yz-delete-item yz-delete-ad"></a>
                        </div>
                    </div>
                    <!-- Data Inputs -->
                    <input type="hidden" name="<?php echo $name; ?>[url]" value="<?php echo $url; ?>">
                    <input type="hidden" name="<?php echo $name; ?>[code]" value="<?php echo $code; ?>">
                    <input type="hidden" name="<?php echo $name; ?>[type]" value="<?php echo $type; ?>">
                    <input type="hidden" name="<?php echo $name; ?>[title]" value="<?php echo $title; ?>">
                    <input type="hidden" name="<?php echo $name; ?>[banner]" value="<?php echo $banner; ?>">
                    <input type="hidden" name="<?php echo $name; ?>[is_sponsored]" value="<?php echo $is_sponsored; ?>">
                </li>

            <?php endforeach; ?>

        </ul>

        <?php
    }

}