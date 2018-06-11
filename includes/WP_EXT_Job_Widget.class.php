<?php

/**
 * Class WP_EXT_Job_Widget
 * ------------------------------------------------------------------------------------------------------------------ */

class WP_EXT_Job_Widget extends WP_Widget {

	/**
	 * Textdomain used for translation.
	 *
	 * @var string
	 * -------------------------------------------------------------------------------------------------------------- */

	private $domain_ID;

	/**
	 * Post type name.
	 *
	 * @var string
	 * -------------------------------------------------------------------------------------------------------------- */

	private $pt_ID;

	/**
	 * Constructor. Register widget with WordPress.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function __construct() {
		$this->pt_ID     = 'job';
		$this->domain_ID = 'job';

		$args = [
			'classname'   => 'wp-ext-' . $this->domain_ID,
			'description' => esc_html__( 'Displays jobs.', 'wp-ext-' . $this->domain_ID ),
		];

		parent::__construct(
			'wp-ext-' . $this->domain_ID,
			esc_html__( 'Jobs', 'wp-ext-' . $this->domain_ID ),
			$args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args
	 * @param array $instance
	 * -------------------------------------------------------------------------------------------------------------- */

	public function widget( $args, $instance ) {

		/**
		 * Options.
		 * ---------------------------------------------------------------------------------------------------------- */

		$title = '<a href="/jobs">' . esc_html__( 'Вакансии', 'wp-ext-' . $this->domain_ID ) . '</a>';
		$opts  = [
			'post_type'      => $this->pt_ID,
			'post_status'    => 'publish',
			'posts_per_page' => 6,
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

		$wp_query = new WP_Query( $opts );

		if ( $wp_query->have_posts() ) {
			echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
			echo '<ul class="wp-ext-' . $this->domain_ID . '">';

			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();

				echo self::job_render();
			}

			echo '</ul>';
			echo $args['after_widget'];
		}

		/**
		 * Reset query.
		 * ---------------------------------------------------------------------------------------------------------- */

		wp_reset_query();
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance The widget options.
	 *
	 * @return string|void
	 * -------------------------------------------------------------------------------------------------------------- */

	public function form( $instance ) {
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance The new options.
	 * @param array $old_instance The previous options.
	 *
	 * @return array|void
	 * -------------------------------------------------------------------------------------------------------------- */

	public function update( $new_instance, $old_instance ) {
	}

	/**
	 * Render: `job`.
	 *
	 * @return string
	 * -------------------------------------------------------------------------------------------------------------- */

	public function job_render() {
		$cover = esc_html( get_field( $this->pt_ID . '_cover' ) );

		if ( $cover ) {
			$cover = '<i class="' . $cover . '"></i>';
		} else {
			$cover = '<i class="fas fa-user"></i>';
		}

		$out = '<li class="job-grid">';
		$out .= '<div class="job-cover"><a title="' . esc_attr( get_the_title() ) . '" href="' . esc_url( get_permalink() ) . '">' . $cover . '</a></div>';
		$out .= '<div class="job-title"><a title="' . esc_attr( get_the_title() ) . '" href="' . esc_url( get_permalink() ) . '">' . wp_trim_words( get_the_title(), 10, '...' ) . '</a></div>';
		$out .= '</li>';

		return $out;
	}
}

/**
 * Register the widget.
 * ------------------------------------------------------------------------------------------------------------------ */

function WP_EXT_Job_Widget_Register() {
	register_widget( 'WP_EXT_Job_Widget' );
}

/**
 * Initialize on `widgets_init`.
 * ------------------------------------------------------------------------------------------------------------------ */

add_action( 'widgets_init', 'WP_EXT_Job_Widget_Register' );
