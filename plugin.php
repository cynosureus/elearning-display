
<?php 

/*
Plugin Name: Elearning Helper Functions
Plugin URI: http://www.cynosure.com
Description: Helpers to display images on elearning page
Version: 1.0
Author: Daniel Miller


*/
		


function format_product_name($product) {


	$old_vals = array(' ', '+');
	$new_vals = array('-', '-plus');
	$product = str_replace($old_vals, $new_vals, $product);

	$product = strtolower($product);

	return $product;

}


function retrieve_products($products) {

	$product_display = array();
	foreach ($products as &$product) {

		$product = format_product_name($product);

		$args = array(

			'post_type' => 'products',
			'name' => $product

		);

		$query = new WP_Query($args);

		if( $query-> have_posts() ) {

			while( $query->have_posts() ) {

				$query->the_post();

				$thumbnail = get_post_meta(get_the_ID(), 'wpcf-product-thumbnail', true);
				$title = get_the_title();
				$permalink = get_permalink();

				array_push($product_display, array('title' => $title, 'thumbnail' => $thumbnail, 'permalink' => $permalink));

			}
		} 

		wp_reset_postdata();

	}

	return $product_display;

}

function redirect_logged_out_user() {

	if(!is_user_logged_in()) {

		wp_redirect(get_site_url());
	}


}

add_action(
  'wp_logout',
  create_function(
    '',
    'wp_redirect(get_site_url());exit();'
  )
);


?>