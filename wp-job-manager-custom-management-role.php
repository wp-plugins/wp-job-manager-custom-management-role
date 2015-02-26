<?php
/*
Plugin Name: WP Job Manager - Custom Management Role
Plugin URI: https://github.com/Pressed-Solutions/WP-Job-Manager-Custom-Management-Role
Description: Allow a user who has "edit_others_job_applications" capability to edit anybody's applications.
Version: 1.0.1
Author: AndrewRMinion Design
Author URI: http://andrewrminion.com
Requires at least: 3.8
Tested up to: 4.1
Text Domain: wp-job-manager
Domain Path: /languages
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_filter( 'job_manager_user_can_edit_job', 'job_manager_custom_management_role', 10, 2 );

function job_manager_custom_management_role( $can_edit, $job_id ) {
	$can_edit = true;
	$job      = get_post( $job_id );

	if ( ! is_user_logged_in() ) {
		$can_edit = false;
    } elseif ( current_user_can( 'edit_others_job_applications' ) ) {
        $can_edit = true;
	} elseif ( $job->post_author != get_current_user_id() && ! current_user_can( 'edit_post', $job_id ) ) {
		$can_edit = false;
	}

    return $can_edit;
}
