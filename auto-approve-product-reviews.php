<?php
/*
 * Plugin Name: Auto Approve 5-Star Product Reviews
 * Description: Automatically approves WooCommerce product reviews, but only if the customer gives a 5-star rating.
 * Version: 1.0 revision
 * Author:
*/

class autoApproveReviews {

	public static function start() {
		return new static;
	}

	public function __construct() {

		// Only auto-approve if review has 5-star rating
		add_filter('pre_comment_approved', [$this, 'checkReview'], 500, 2);
	}

	public function checkReview($approved, $commentdata) {
		$isUnapprovedReview = $commentdata['comment_type'] === 'review' && $approved == 0;

		if ($isUnapprovedReview && isset($_POST['rating']) && intval($_POST['rating']) === 5) {
			$approved = 1;
		}

		return $approved;
	}

	public static function onActivation() {
	}

}

// Run the plugin
add_action('plugins_loaded', 'autoApproveReviews::start');
