<?php
/*
 * Plugin Name: Auto Approve 5-Star Product Reviews
 * Description: Automatically approves WooCommerce product reviews, but only if the customer gives a 5-star rating.
 * Version: 1.0 revision
 * Author:
*/

class AutoApproveReviews {

	public static function start() {
		return new static;
	}

	public function __construct() {
		// Only auto-approve if review has 5-star rating
		add_filter('pre_comment_approved', [$this, 'checkReview'], 500, 2);

		// Sanitize comment content before WordPress processes it
		add_filter('preprocess_comment', [$this, 'sanitizeCommentContent'], 5);
	}

	public function checkReview($approved, $commentdata) {
		$isUnapprovedReview = $commentdata['comment_type'] === 'review' && $approved == 0;

		if ($isUnapprovedReview && isset($_POST['rating']) && intval($_POST['rating']) === 5) {
			$approved = 1;
		}
		return $approved;
	}

	public function sanitizeCommentContent($commentdata) {

		if (isset($commentdata['comment_content'])) {
			// Clean and balance tags
			$commentdata['comment_content'] = wp_kses_post($commentdata['comment_content']);
		}
		return $commentdata;
	}

	public static function onActivation() {
		// Placeholder
	}

}

// Run the plugin
add_action('plugins_loaded', 'AutoApproveReviews::start');
