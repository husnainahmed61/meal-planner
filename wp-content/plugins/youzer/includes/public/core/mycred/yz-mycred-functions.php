<?php

/**
 * Check is Mycred is Installed & Active.
 */
function yz_is_mycred_active() {
    
    if ( ! yz_is_mycred_installed() ) {
    	return false;
    }

	// Get Value.
	$is_mycred_enabled = yz_options( 'yz_enable_mycred' );

	if ( 'off' == $is_mycred_enabled ) {
		return false;
	}

	return true;

}

/**
 * Include MyCRED Files.
 */
function yz_init_mycred() {

	if ( ! yz_is_mycred_active() ) {
		return;
	}

	// Balance Functions.
    require_once YZ_PUBLIC_CORE . 'mycred/yz-mycred-balance.php';

	// Badges Functions.
	if ( defined( 'myCRED_BADGE_VERSION' ) ) {
    	require_once YZ_PUBLIC_CORE . 'mycred/yz-mycred-badges.php';
	}
}

add_action( 'setup_theme', 'yz_init_mycred' );

/**
 * MyCRED Enqueue scripts.
 */
function yz_mycred_scripts( $hook_suffix ) {

    if ( ! yz_is_mycred_active() )  {
        return;
    }
    
    global $Youzer;
    
    // Register MyCRED Css.
    wp_register_style( 'yz-mycred', YZ_PA . 'css/yz-mycred.min.css', $Youzer->version );

    // Call MyCRED Css.
    wp_enqueue_style( 'yz-mycred' );

}

add_action( 'wp_enqueue_scripts', 'yz_mycred_scripts' );

/**
 * # Default Options 
 */
function yz_mycred_default_options( $options ) {

    // Options.
    $yzsq_options = array(
		'yz_enable_mycred' => 'on',
		'yz_badges_tab_icon' => 'trophy',
		'yz_enable_cards_mycred_badges' => 'on',
		'yz_wg_max_card_user_badges_items' => 4,
		'yz_mycred-history_tab_icon' => 'history',
		'yz_author_box_max_user_badges_items' => 3,
		'yz_enable_author_box_mycred_badges' => 'on',
		'yz_mycred_badges_tab_title' => __( 'Badges', 'youzer' ),
		'yz_ctabs_mycred-history_thismonth_icon' => 'calendar-o',
		'yz_ctabs_mycred-history_today_icon' => 'calendar-check-o',
		'yz_ctabs_mycred-history_mycred-history_icon' => 'calendar',
		'yz_ctabs_mycred-history_thisweek_icon' => 'calendar-times-o',
		'yz_ctabs_mycred-history_yesterday_icon' => 'calendar-minus-o',
    );
    
    $options = array_merge( $options, $yzsq_options );

    return $options;
}

add_filter( 'yz_default_options', 'yz_mycred_default_options' );


/**
 * Edit My Cred Title
 */
function yz_edit_mycred_tab_title( $title ) {

	ob_start();

	?>

	<div class="yz-tab-title-box">
		<div class="yz-tab-title-icon"><i class="fa fa-history" aria-hidden="true"></i></div>
		<div class="yz-tab-title-content">
			<h2><?php echo $title; ?></h2>
			<span><?php _e( 'This is the user points log.', 'youzer' );?></span>
		</div>
	</div>

	<?php

	$output = ob_get_contents();
	ob_end_clean();

	return $output;

}

add_filter( 'mycred_br_history_page_title' , 'yz_edit_mycred_tab_title' );


/**
 * Leader Board Widget.
 */
function yz_mycred_leader_board_widget( $layout, $template, $user, $position, $data ) {
	$avatar = bp_core_fetch_avatar( array( 'item_id' => $user['ID'], 'type' => 'thumb' ) );
	$layout = '<li class="yz-leaderboard-item"><div class="yz-leaderboard-avatar"><span class="yz-leaderboard-position"># ' . $position .'</span>'. $avatar . '</div><div class="yz-leaderboard-content"><a class="yz-leaderboard-username" href="' . bp_core_get_user_domain( $user['ID'] ).'">' . bp_core_get_user_displayname( $user['ID'] ) . '</a><div class="yz-leaderboard-points">' . sprintf( _n( '%s ' . $data->core->core['name']['singular'], '%s ' . $data->core->core['name']['plural'], $user['cred'], 'youzer' ), $user['cred'] ) . '</div></li>';

	return $layout;
}

add_filter( 'mycred_ranking_row', 'yz_mycred_leader_board_widget', 10, 5 );