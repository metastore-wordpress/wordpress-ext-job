<?php

/**
 * Class WP_EXT_Job_ShortCode
 * ------------------------------------------------------------------------------------------------------------------ */

class WP_EXT_Job_ShortCode extends WP_EXT_Job {

	/**
	 * Constructor.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function __construct() {
		parent::__construct();

		$this->run();
	}

	/**
	 * Plugin: `initialize`.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function run() {
		add_shortcode( $this->archive_ID, [ $this, 'shortcode' ] );
	}

	/**
	 * ShortCode.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function shortcode( $atts, $content = null ) {

		/**
		 * Global variables.
		 * ---------------------------------------------------------------------------------------------------------- */

		global $wp_query;

		/**
		 * Options.
		 * ---------------------------------------------------------------------------------------------------------- */

		$defaults = [
			'type' => '',
		];

		$atts = shortcode_atts( $defaults, $atts, $this->archive_ID );

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$args = [
			'post_type'      => $this->pt_ID,
			'post_status'    => 'publish',
			'posts_per_page' => 6,
			'paged'          => $paged,
			'tax_query'      => [
				[
					'taxonomy' => $this->pt_ID . '_meta',
					'field'    => 'slug',
					'terms'    => 'archive',
					'operator' => 'NOT IN',
				]
			],
		];

		/**
		 * Rendering data.
		 * ---------------------------------------------------------------------------------------------------------- */

		$wp_query = new WP_Query( $args );

		if ( $wp_query->have_posts() ) {
			echo '<div class="wp-ext-' . $this->domain_ID . '">';

			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();

				echo '<div><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></div>';
			}

			echo '</div>';

			do_action( 'genesis_after_endwhile' );
		}

		/**
		 * Reset query.
		 * ---------------------------------------------------------------------------------------------------------- */

		wp_reset_query();
	}
}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Job_ShortCode
 * ------------------------------------------------------------------------------------------------------------------ */

function WP_EXT_Job_ShortCode() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Job_ShortCode;
	}

	return $object;
}

/**
 * Initialize the object on `plugins_loaded`.
 * ------------------------------------------------------------------------------------------------------------------ */

add_action( 'plugins_loaded', [ WP_EXT_Job_ShortCode(), 'run' ] );
