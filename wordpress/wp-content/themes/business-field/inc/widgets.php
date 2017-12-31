<?php
/**
 * Theme widgets.
 *
 * @package Business_Field
 */

// Load widget base.
require_once get_template_directory() . '/lib/widget-base/class-widget-base.php';

if ( ! function_exists( 'business_field_load_widgets' ) ) :

	/**
	 * Load widgets.
	 *
	 * @since 1.0.0
	 */
	function business_field_load_widgets() {

		// Social widget.
		register_widget( 'Business_Field_Social_Widget' );

		// Featured Page widget.
		register_widget( 'Business_Field_Featured_Page_Widget' );

		// Latest News widget.
		register_widget( 'Business_Field_Latest_News_Widget' );

		// Call To Action widget.
		register_widget( 'Business_Field_Call_To_Action_Widget' );

		// Services widget.
		register_widget( 'Business_Field_Services_Widget' );

		// Recent Posts widget.
		register_widget( 'Business_Field_Recent_Posts_Widget' );

		// Featured News Blocks widget.
		register_widget( 'Business_Field_News_Blocks_Widget' );
	}

endif;

add_action( 'widgets_init', 'business_field_load_widgets' );

if ( ! class_exists( 'Business_Field_Social_Widget' ) ) :

	/**
	 * Social widget Class.
	 *
	 * @since 1.0.0
	 */
	class Business_Field_Social_Widget extends Business_Field_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'business_field_widget_social',
				'description'                 => __( 'Displays social icons.', 'business-field' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				);

			if ( false === has_nav_menu( 'social' ) ) {
				$fields['message'] = array(
					'label' => __( 'Social menu is not set. Please create menu and assign it to Social Menu.', 'business-field' ),
					'type'  => 'message',
					'class' => 'widefat',
					);
			}

			parent::__construct( 'business-field-social', __( 'BF: Social', 'business-field' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}

			if ( ! empty( $params['subtitle'] ) ) {
				echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
			}

			if ( has_nav_menu( 'social' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'social',
					'container'      => false,
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>',
				) );
			}

			echo $args['after_widget'];

		}
	}
endif;

if ( ! class_exists( 'Business_Field_Featured_Page_Widget' ) ) :

	/**
	 * Featured page widget Class.
	 *
	 * @since 1.0.0
	 */
	class Business_Field_Featured_Page_Widget extends Business_Field_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'business_field_widget_featured_page',
				'description'                 => __( 'Displays single featured Page or Post.', 'business-field' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'use_page_title' => array(
					'label'   => __( 'Use Page/Post Title as Widget Title', 'business-field' ),
					'type'    => 'checkbox',
					'default' => true,
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'featured_page' => array(
					'label'            => __( 'Select Page:', 'business-field' ),
					'type'             => 'dropdown-pages',
					'show_option_none' => __( '&mdash; Select &mdash;', 'business-field' ),
					),
				'id_message' => array(
					'label'            => '<strong>' . _x( 'OR', 'Featured Page Widget', 'business-field' ) . '</strong>',
					'type'             => 'message',
					),
				'featured_post' => array(
					'label'             => __( 'Post ID:', 'business-field' ),
					'placeholder'       => __( 'Eg: 1234', 'business-field' ),
					'type'              => 'text',
					'sanitize_callback' => 'business_field_widget_sanitize_post_id',
					),
				'content_type' => array(
					'label'   => __( 'Show Content:', 'business-field' ),
					'type'    => 'select',
					'default' => 'full',
					'options' => array(
						'excerpt' => __( 'Excerpt', 'business-field' ),
						'full'    => __( 'Full', 'business-field' ),
						),
					),
				'excerpt_length' => array(
					'label'       => __( 'Excerpt Length:', 'business-field' ),
					'description' => __( 'Applies when Excerpt is selected in Content option.', 'business-field' ),
					'type'        => 'number',
					'css'         => 'max-width:60px;',
					'default'     => 100,
					'min'         => 1,
					'max'         => 400,
					),
				'featured_image' => array(
					'label'   => __( 'Featured Image:', 'business-field' ),
					'type'    => 'select',
					'options' => business_field_get_image_sizes_options(),
					),
				'featured_image_alignment' => array(
					'label'   => __( 'Image Alignment:', 'business-field' ),
					'type'    => 'select',
					'default' => 'center',
					'options' => business_field_get_image_alignment_options(),
					),
				);

			parent::__construct( 'business-field-featured-page', __( 'BF: Featured Page', 'business-field' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			$our_id = '';

			if ( absint( $params['featured_post'] ) > 0 ) {
				$our_id = absint( $params['featured_post'] );
			}

			if ( absint( $params['featured_page'] ) > 0 ) {
				$our_id = absint( $params['featured_page'] );
			}

			if ( absint( $our_id ) > 0 ) {
				$qargs = array(
					'p'             => absint( $our_id ),
					'post_type'     => 'any',
					'no_found_rows' => true,
					);

				$the_query = new WP_Query( $qargs );
				if ( $the_query->have_posts() ) {

					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						echo '<div class="featured-page-widget image-align' . esc_attr( $params['featured_image_alignment'] ) . ' entry-content">';

						if ( 'disable' != $params['featured_image'] && has_post_thumbnail() ) {
							the_post_thumbnail( esc_attr( $params['featured_image'] ) );
						}

						echo '<div class="featured-page-content">';

						if ( true === $params['use_page_title'] ) {
							the_title( $args['before_title'], $args['after_title'] );
						} else {
							if ( $params['title'] ) {
								echo $args['before_title'] . $params['title'] . $args['after_title'];
							}
						}

						if ( ! empty( $params['subtitle'] ) ) {
							echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
						}

						if ( 'excerpt' === $params['content_type'] && absint( $params['excerpt_length'] ) > 0 ) {
							$excerpt = business_field_the_excerpt( absint( $params['excerpt_length'] ) );
							echo wp_kses_post( wpautop( $excerpt ) );
							echo '<a href="'  . esc_url( get_permalink() ) . '" class="more-link">' . esc_html__( 'Know More', 'business-field' ) . '</a>';
						} else {
							the_content();
						}

						echo '</div><!-- .featured-page-content -->';
						echo '</div><!-- .featured-page-widget -->';
					}

					wp_reset_postdata();
				}

			}

			echo $args['after_widget'];
		}
	}
endif;

if ( ! class_exists( 'Business_Field_Latest_News_Widget' ) ) :

	/**
	 * Latest news widget Class.
	 *
	 * @since 1.0.0
	 */
	class Business_Field_Latest_News_Widget extends Business_Field_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$opts = array(
				'classname'                   => 'business_field_widget_latest_news',
				'description'                 => __( 'Displays latest posts in grid.', 'business-field' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'post_category' => array(
					'label'           => __( 'Select Category:', 'business-field' ),
					'type'            => 'dropdown-taxonomies',
					'show_option_all' => __( 'All Categories', 'business-field' ),
					),
				'post_number' => array(
					'label'   => __( 'Number of Posts:', 'business-field' ),
					'type'    => 'number',
					'default' => 3,
					'css'     => 'max-width:60px;',
					'min'     => 1,
					'max'     => 100,
					),
				'post_column' => array(
					'label'   => __( 'Number of Columns:', 'business-field' ),
					'type'    => 'select',
					'default' => 3,
					'options' => business_field_get_numbers_dropdown_options( 3, 4 ),
					),
				'featured_image' => array(
					'label'   => __( 'Featured Image:', 'business-field' ),
					'type'    => 'select',
					'default' => 'business-field-thumb',
					'options' => business_field_get_image_sizes_options(),
					),
				'excerpt_length' => array(
					'label'       => __( 'Excerpt Length:', 'business-field' ),
					'description' => __( 'in words', 'business-field' ),
					'type'        => 'number',
					'css'         => 'max-width:60px;',
					'default'     => 15,
					'min'         => 1,
					'max'         => 400,
					'adjacent'    => true,
					),
				'more_text' => array(
					'label'   => __( 'More Text:', 'business-field' ),
					'type'    => 'text',
					'default' => __( 'Know More', 'business-field' ),
					),
				'disable_date' => array(
					'label'   => __( 'Disable Date', 'business-field' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				'disable_excerpt' => array(
					'label'   => __( 'Disable Excerpt', 'business-field' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				'disable_more_text' => array(
					'label'   => __( 'Disable More Text', 'business-field' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				);

			parent::__construct( 'business-field-latest-news', __( 'BF: Latest News', 'business-field' ), $opts, array(), $fields );
		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}

			if ( ! empty( $params['subtitle'] ) ) {
				echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
			}

			$qargs = array(
				'posts_per_page' => esc_attr( $params['post_number'] ),
				'no_found_rows'  => true,
				);
			if ( absint( $params['post_category'] ) > 0 ) {
				$qargs['cat'] = absint( $params['post_category'] );
			}
			$all_posts = get_posts( $qargs );
			?>
			<?php if ( ! empty( $all_posts ) ) : ?>

				<?php global $post; ?>

				<div class="latest-news-widget latest-news-col-<?php echo esc_attr( $params['post_column'] ); ?>">

					<div class="inner-wrapper">

						<?php foreach ( $all_posts as $key => $post ) : ?>
							<?php setup_postdata( $post ); ?>

							<div class="latest-news-item">

									<?php if ( 'disable' !== $params['featured_image'] && has_post_thumbnail() ) : ?>
										<div class="latest-news-thumb">

											<a href="<?php the_permalink(); ?>">
												<?php
												$img_attributes = array( 'class' => 'aligncenter' );
												the_post_thumbnail( esc_attr( $params['featured_image'] ), $img_attributes );
												?>
											</a>
										</div><!-- .latest-news-thumb -->
									<?php endif; ?>
									<div class="latest-news-text-wrap">

										<div class="latest-news-text-content">
											<h3 class="latest-news-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3><!-- .latest-news-title -->

											<?php $category = business_field_get_single_post_category(); ?>
											<?php if ( false !== $params['disable_date'] || ! empty( $category ) ) : ?>
												<div class="latest-news-meta">
													<?php if ( false === $params['disable_date'] ) : ?>
														<span class="posted-on">
															<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
														</span>
													<?php endif; ?>
													<?php if ( ! empty( $category ) ) : ?>
														<span class="cat-links"><a href="<?php echo esc_url( $category['url'] ); ?>"><?php echo esc_html( $category['name'] ); ?></a></span>
													<?php endif; ?>
												</div><!-- .latest-news-meta -->
											<?php endif; ?>

											<?php if ( false === $params['disable_excerpt'] ) : ?>
												<div class="latest-news-summary">
												<?php
												$summary = business_field_the_excerpt( esc_attr( $params['excerpt_length'] ), $post );
												echo wp_kses_post( wpautop( $summary ) );
												?>
												</div><!-- .latest-news-summary -->
											<?php endif; ?>
										</div><!-- .latest-news-text-content -->

										<?php if ( false === $params['disable_more_text'] ) : ?>
											<a href="<?php the_permalink(); ?>" class="learn-more-link"><?php echo esc_html( $params['more_text'] ); ?><span class="screen-reader-text">"<?php the_title(); ?>"</span>
											</a>
										<?php endif; ?>

									</div><!-- .latest-news-text-wrap -->

							</div><!-- .latest-news-item -->

						<?php endforeach; ?>
					</div><!-- .row -->

				</div><!-- .latest-news-widget -->

				<?php wp_reset_postdata(); ?>

			<?php endif; ?>

			<?php echo $args['after_widget'];

		}
	}
endif;

if ( ! class_exists( 'Business_Field_Call_To_Action_Widget' ) ) :

	/**
	 * Call to action widget Class.
	 *
	 * @since 1.0.0
	 */
	class Business_Field_Call_To_Action_Widget extends Business_Field_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'business_field_widget_call_to_action',
				'description'                 => __( 'Call To Action Widget.', 'business-field' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'primary_button_text' => array(
					'label'   => __( 'Primary Button Text:', 'business-field' ),
					'default' => __( 'Learn more', 'business-field' ),
					'type'    => 'text',
					'class'   => 'widefat',
					),
				'primary_button_url' => array(
					'label' => __( 'Primary Button URL:', 'business-field' ),
					'type'  => 'url',
					'class' => 'widefat',
					),
				'secondary_button_text' => array(
					'label'   => __( 'Secondary Button Text:', 'business-field' ),
					'default' => '',
					'type'    => 'text',
					'class'   => 'widefat',
					),
				'secondary_button_url' => array(
					'label' => __( 'Secondary Button URL:', 'business-field' ),
					'type'  => 'url',
					'class' => 'widefat',
					),
				);

			parent::__construct( 'business-field-call-to-action', __( 'BF: Call To Action', 'business-field' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			// Add extra classes.
			$extra_class = 'cta-layout-1';
			$args['before_widget'] = implode( 'class="' . $extra_class . ' ', explode( 'class="', $args['before_widget'], 2 ) );

			echo $args['before_widget'];
			echo '<div class="call-to-action-main-wrap">';
			echo '<div class="call-to-action-content-wrap">';

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}

			echo '</div>';
			?>

			<?php if ( ( ! empty( $params['primary_button_text'] ) && ! empty( $params['primary_button_url'] ) ) || ( ! empty( $params['secondary_button_text'] ) && ! empty( $params['secondary_button_url'] ) ) ) : ?>
				<div class="call-to-action-buttons">
					<?php if ( ! empty( $params['primary_button_url'] ) && ! empty( $params['primary_button_text'] ) ) : ?>
						<a href="<?php echo esc_url( $params['primary_button_url'] ); ?>" class="custom-button btn-call-to-action button-primary"><?php echo esc_html( $params['primary_button_text'] ); ?></a>
					<?php endif; ?>
					<?php if ( ! empty( $params['secondary_button_url'] ) && ! empty( $params['secondary_button_text'] ) ) : ?>
						<a href="<?php echo esc_url( $params['secondary_button_url'] ); ?>" class="custom-button btn-call-to-action button-secondary"><?php echo esc_html( $params['secondary_button_text'] ); ?></a>
					<?php endif; ?>
				</div><!-- .call-to-action-buttons -->
			<?php endif; ?>
			<?php echo '</div>'; ?>
			<?php

			echo $args['after_widget'];

		}
	}
endif;

if ( ! class_exists( 'Business_Field_Services_Widget' ) ) :

	/**
	 * Services widget Class.
	 *
	 * @since 1.0.0
	 */
	class Business_Field_Services_Widget extends Business_Field_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'business_field_widget_services',
				'description'                 => __( 'Show your services with icon and read more link.', 'business-field' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'excerpt_length' => array(
					'label'       => __( 'Excerpt Length:', 'business-field' ),
					'description' => __( 'in words', 'business-field' ),
					'type'        => 'number',
					'css'         => 'max-width:60px;',
					'default'     => 15,
					'min'         => 1,
					'max'         => 400,
					'adjacent'    => true,
					),
				'disable_excerpt' => array(
					'label'   => __( 'Disable Excerpt', 'business-field' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				'more_text' => array(
					'label'   => __( 'Read More Text:', 'business-field' ),
					'type'    => 'text',
					'default' => __( 'Know More', 'business-field' ),
					),
				'disable_more_text' => array(
					'label'   => __( 'Disable Read More', 'business-field' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				);

			for( $i = 1; $i <= 6; $i++ ) {
				$fields[ 'block_heading_' . $i ] = array(
					'label' => __( 'Block', 'business-field' ) . ' #' . $i,
					'type'  => 'heading',
					'class' => 'widefat',
					);
				$fields[ 'block_page_' . $i ] = array(
					'label'            => __( 'Select Page:', 'business-field' ),
					'type'             => 'dropdown-pages',
					'show_option_none' => __( '&mdash; Select &mdash;', 'business-field' ),
					);
				$fields[ 'block_icon_' . $i ] = array(
					'label'       => __( 'Icon:', 'business-field' ),
					'description' => __( 'Eg: fa-cogs', 'business-field' ),
					'type'        => 'text',
					'default'     => 'fa-cogs',
					);
			}

			parent::__construct( 'business-field-services', __( 'BF: Services', 'business-field' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}
			if ( ! empty( $params['subtitle'] ) ) {
				echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
			}

			$service_arr = array();
			for ( $i = 0; $i < 6 ; $i++ ) {
				$block = ( $i + 1 );
				$service_arr[ $i ] = array(
					'page' => $params[ 'block_page_' . $block ],
					'icon' => $params[ 'block_icon_' . $block ],
					);
			}
			$refined_arr = array();
			if ( ! empty( $service_arr ) ) {
				foreach ( $service_arr as $item ) {
					if ( ! empty( $item['page'] ) ) {
						$refined_arr[ $item['page'] ] = $item;
					}
				}
			}

			if ( ! empty( $refined_arr ) ) {
				$this->render_widget_content( $refined_arr, $params );
			}

			echo $args['after_widget'];

		}

		/**
		 * Render services content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $service_arr Services array.
		 * @param array $params      Parameters array.
		 */
		function render_widget_content( $service_arr, $params ) {

			$column = count( $service_arr );

			$page_ids = array_keys( $service_arr );

			$qargs = array(
				'posts_per_page' => count( $page_ids ),
				'post__in'       => $page_ids,
				'post_type'      => 'page',
				'orderby'        => 'post__in',
				'no_found_rows'  => true,
			);

			$all_posts = get_posts( $qargs );
			?>
			<?php if ( ! empty( $all_posts ) ) : ?>

				<?php global $post; ?>

				<div class="service-block-list service-col-<?php echo esc_attr( $column ); ?>">
					<div class="inner-wrapper">

						<?php foreach ( $all_posts as $post ) : ?>
							<?php setup_postdata( $post ); ?>
							<div class="service-block-item">
								<div class="service-block-inner">
									<?php if ( isset( $service_arr[ $post->ID ]['icon'] ) && ! empty( $service_arr[ $post->ID ]['icon'] ) ) : ?>
										<a class="service-icon" href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><i class="<?php echo 'fa ' . esc_attr( $service_arr[ $post->ID ]['icon'] ); ?>"></i></a>
									<?php endif; ?>

									<div class="service-block-inner-content">
										<h3 class="service-item-title">
											<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
												<?php echo get_the_title( $post->ID ); ?>
											</a>
										</h3>
										<?php if ( true !== $params['disable_excerpt'] ) : ?>
											<div class="service-block-item-excerpt">
												<?php
												$excerpt = business_field_the_excerpt( $params['excerpt_length'], $post );
												echo wp_kses_post( wpautop( $excerpt ) );
												?>
											</div><!-- .service-block-item-excerpt -->
										<?php endif; ?>

										<?php if ( true !== $params['disable_more_text'] ) : ?>
											<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="learn-more-link"><?php echo esc_html( $params['more_text'] ); ?></a>
										<?php endif; ?>
									</div><!-- .service-block-inner-content -->
								</div><!-- .service-block-inner -->
							</div><!-- .service-block-item -->
						<?php endforeach; ?>

					</div><!-- .inner-wrapper -->

				</div><!-- .service-block-list -->

				<?php wp_reset_postdata(); ?>

			<?php endif; ?>

			<?php
		}

	}
endif;

if ( ! class_exists( 'Business_Field_Recent_Posts_Widget' ) ) :

	/**
	 * Recent posts widget Class.
	 *
	 * @since 1.0.0
	 */
	class Business_Field_Recent_Posts_Widget extends Business_Field_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'business_field_widget_recent_posts',
				'description'                 => __( 'Displays recent posts.', 'business-field' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'post_category' => array(
					'label'           => __( 'Select Category:', 'business-field' ),
					'type'            => 'dropdown-taxonomies',
					'show_option_all' => __( 'All Categories', 'business-field' ),
					),
				'post_number' => array(
					'label'   => __( 'Number of Posts:', 'business-field' ),
					'type'    => 'number',
					'default' => 4,
					'css'     => 'max-width:60px;',
					'min'     => 1,
					'max'     => 100,
					),
				'featured_image' => array(
					'label'   => __( 'Featured Image:', 'business-field' ),
					'type'    => 'select',
					'default' => 'thumbnail',
					'options' => business_field_get_image_sizes_options( true, array( 'disable', 'thumbnail' ), false ),
					),
				'image_width' => array(
					'label'       => __( 'Image Width:', 'business-field' ),
					'type'        => 'number',
					'description' => __( 'px', 'business-field' ),
					'css'         => 'max-width:60px;',
					'adjacent'    => true,
					'default'     => 70,
					'min'         => 1,
					'max'         => 150,
					),
				'disable_date' => array(
					'label'   => __( 'Disable Date', 'business-field' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				);

			parent::__construct( 'business-field-recent-posts', __( 'BF: Recent Posts', 'business-field' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}
			if ( ! empty( $params['subtitle'] ) ) {
				echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
			}
			$qargs = array(
				'posts_per_page' => esc_attr( $params['post_number'] ),
				'no_found_rows'  => true,
				);
			if ( absint( $params['post_category'] ) > 0 ) {
				$qargs['cat'] = $params['post_category'];
			}
			$all_posts = get_posts( $qargs );

			?>
			<?php if ( ! empty( $all_posts ) ) :  ?>

				<?php global $post; ?>

				<div class="recent-posts-wrapper">

					<?php foreach ( $all_posts as $key => $post ) :  ?>
						<?php setup_postdata( $post ); ?>

						<div class="recent-posts-item">

							<?php if ( 'disable' !== $params['featured_image'] && has_post_thumbnail() ) :  ?>
								<div class="recent-posts-thumb">
									<a href="<?php the_permalink(); ?>">
										<?php
										$img_attributes = array(
											'class' => 'alignleft',
											'style' => 'max-width:' . esc_attr( $params['image_width'] ). 'px;',
											);
										the_post_thumbnail( esc_attr( $params['featured_image'] ), $img_attributes );
										?>
									</a>
								</div><!-- .recent-posts-thumb -->
							<?php endif ?>
							<div class="recent-posts-text-wrap">
								<h3 class="recent-posts-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3><!-- .recent-posts-title -->

								<?php if ( false === $params['disable_date'] ) :  ?>
									<div class="recent-posts-meta">

										<?php if ( false === $params['disable_date'] ) :  ?>
											<span class="recent-posts-date"><?php the_time( get_option( 'date_format' ) ); ?></span><!-- .recent-posts-date -->
										<?php endif; ?>

									</div><!-- .recent-posts-meta -->
								<?php endif; ?>

							</div><!-- .recent-posts-text-wrap -->

						</div><!-- .recent-posts-item -->

					<?php endforeach; ?>

				</div><!-- .recent-posts-wrapper -->

				<?php wp_reset_postdata(); // Reset. ?>

			<?php endif; ?>

			<?php
			echo $args['after_widget'];

		}
	}
endif;

if ( ! class_exists( 'Business_Field_News_Blocks_Widget' ) ) :

	/**
	 * Featured pages grid widget Class.
	 *
	 * @since 1.0.0
	 */
	class Business_Field_News_Blocks_Widget extends Business_Field_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'business_field_widget_news_blocks',
				'description'                 => __( 'Displays news and blocks.', 'business-field' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'business-field' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'heading_1' => array(
					'label' => __( 'First Block', 'business-field' ),
					'type'  => 'heading',
					'class' => 'widefat',
					),
				'block_title_1' => array(
					'label'   => __( 'Block Title:', 'business-field' ),
					'default' => __( 'Latest News', 'business-field' ),
					'type'    => 'text',
					'class'   => 'widefat',
					),
				'block_icon_1' => array(
					'label' => __( 'Block Icon:', 'business-field' ),
					'default' => 'fa-th',
					'type'  => 'text',
					'class' => 'widefat',
					),
				'block_post_category_1' => array(
					'label'           => __( 'Select Category:', 'business-field' ),
					'type'            => 'dropdown-taxonomies',
					'show_option_all' => __( 'All Categories', 'business-field' ),
					),
				'block_post_number_1' => array(
					'label' => __( 'No of Posts:', 'business-field' ),
					'default' => 2,
					'type'    => 'number',
					'css'     => 'max-width:60px;',
					'min'     => 1,
					'max'     => 10,
					),
				'block_featured_image_1' => array(
					'label'   => __( 'Featured Image:', 'business-field' ),
					'type'    => 'select',
					'default' => 'business-field-thumb',
					'options' => business_field_get_image_sizes_options(),
					),
				'block_excerpt_length_1' => array(
					'label'       => __( 'Excerpt Length:', 'business-field' ),
					'description' => __( 'in words', 'business-field' ),
					'type'        => 'number',
					'css'         => 'max-width:60px;',
					'default'     => 15,
					'min'         => 1,
					'max'         => 400,
					'adjacent'    => true,
					),
				'block_disable_excerpt_1' => array(
					'label'   => __( 'Disable Excerpt', 'business-field' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				'heading_2' => array(
					'label' => __( 'Second Block', 'business-field' ),
					'type'  => 'heading',
					'class' => 'widefat',
					),
				'block_title_2' => array(
					'label'   => __( 'Block Title:', 'business-field' ),
					'default' => __( 'Recent Highlights', 'business-field' ),
					'type'    => 'text',
					'class'   => 'widefat',
					),
				'block_icon_2' => array(
					'label' => __( 'Block Icon:', 'business-field' ),
					'default' => 'fa-calendar-check-o',
					'type'  => 'text',
					'class' => 'widefat',
					),
				'block_post_category_2' => array(
					'label'           => __( 'Select Category:', 'business-field' ),
					'type'            => 'dropdown-taxonomies',
					'show_option_all' => __( 'All Categories', 'business-field' ),
					),
				'block_post_number_2' => array(
					'label' => __( 'No of Posts:', 'business-field' ),
					'default' => 4,
					'type'    => 'number',
					'css'     => 'max-width:60px;',
					'min'     => 1,
					'max'     => 10,
					),
				'block_excerpt_length_2' => array(
					'label'       => __( 'Excerpt Length:', 'business-field' ),
					'description' => __( 'in words', 'business-field' ),
					'type'        => 'number',
					'css'         => 'max-width:60px;',
					'default'     => 10,
					'min'         => 1,
					'max'         => 400,
					'adjacent'    => true,
					),
				'block_disable_excerpt_2' => array(
					'label'   => __( 'Disable Excerpt', 'business-field' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				);

			parent::__construct( 'business-field-news-blocks', __( 'BF: News Blocks', 'business-field' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}

			if ( ! empty( $params['subtitle'] ) ) {
				echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
			}
			?>
			<div class="news-and-blocks">
				<div class="inner-wrapper">
					<div class="recent-news">
						<?php if ( ! empty( $params['block_title_1'] ) ) : ?>
							<h2>
							<?php if ( ! empty( $params['block_icon_1'] ) ) : ?>
								<i class="fa <?php echo esc_attr( $params['block_icon_1'] ); ?>" aria-hidden="true"></i>
							<?php endif; ?>
							<?php echo esc_html( $params['block_title_1'] ); ?>
							</h2>
							<?php if ( absint( $params['block_post_category_1'] ) > 0 ) : ?>
								<?php
								$term_link = get_term_link( absint( $params['block_post_category_1'] ), 'category' );
								?>
								<?php if ( ! is_wp_error( $term_link ) ) : ?>
									<a href="<?php echo esc_url( $term_link ); ?>" class="view-more-post"><?php esc_html_e( 'View More', 'business-field' ); ?></a>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
						<div class="inner-wrapper">
							<?php
							$qargs = array(
								'posts_per_page'      => absint( $params['block_post_number_1'] ),
								'no_found_rows'       => true,
								'ignore_sticky_posts' => true,
								);
							if ( absint( $params['block_post_category_1'] ) > 0 ) {
								$qargs['cat'] = absint( $params['block_post_category_1'] );
							}
							?>
							<?php $the_query = new WP_Query( $qargs ); ?>
							<?php if ( $the_query->have_posts() ) : ?>

								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
									<div class="news-post">
										<?php if ( 'disable' !== $params['block_featured_image_1'] && has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>">
												<?php
												$img_attributes = array( 'class' => 'aligncenter' );
												the_post_thumbnail( esc_attr( $params['block_featured_image_1'] ), $img_attributes );
												?>
											</a>
										<?php endif; ?>
										<div class="news-content">
											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<div class="block-meta">
												<span class="posted-on">
													<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
												</span>
												<?php
												if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
													echo '<span class="comments-link">';
													comments_popup_link( esc_html__( '0 comments', 'business-field' ), esc_html__( '1 Comment', 'business-field' ), esc_html__( '% Comments', 'business-field' ) );
													echo '</span>';
												}
												?>
											</div><!-- .block-meta -->
											<?php if ( false === $params['block_disable_excerpt_1'] ) : ?>
												<?php
												$summary = business_field_the_excerpt( absint( $params['block_excerpt_length_1'] ) );
												echo wp_kses_post( wpautop( $summary ) );
												?>
											<?php endif; ?>
										</div><!-- .news-content -->
									</div><!-- .news-post -->
								<?php endwhile; ?>

								<?php wp_reset_postdata(); ?>

							<?php endif; ?>
						</div><!-- .inner-wrapper -->
					</div><!-- .recent-news -->
					<div class="recent-blocks">
						<?php if ( ! empty( $params['block_title_2'] ) ) : ?>
							<h2>
							<?php if ( ! empty( $params['block_icon_2'] ) ) : ?>
								<i class="fa <?php echo esc_attr( $params['block_icon_2'] ); ?>" aria-hidden="true"></i>
							<?php endif; ?>
							<?php echo esc_html( $params['block_title_2'] ); ?>
							</h2>
							<?php if ( absint( $params['block_post_category_2'] ) > 0 ) : ?>
								<?php
								$term_link = get_term_link( absint( $params['block_post_category_2'] ), 'category' );
								?>
								<?php if ( ! is_wp_error( $term_link ) ) : ?>
									<a href="<?php echo esc_url( $term_link ); ?>" class="view-more-post"><?php esc_html_e( 'View More', 'business-field' ); ?></a>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>

						<?php
						$qargs = array(
							'posts_per_page'      => absint( $params['block_post_number_2'] ),
							'no_found_rows'       => true,
							'ignore_sticky_posts' => true,
							);
						if ( absint( $params['block_post_category_2'] ) > 0 ) {
							$qargs['cat'] = absint( $params['block_post_category_2'] );
						}
						?>
						<?php $the_query = new WP_Query( $qargs ); ?>
						<?php if ( $the_query->have_posts() ) : ?>

							<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<div class="block-post">

									<div class="custom-entry-date">
										<span class="entry-month"><?php the_time( esc_html_x( 'M', 'date format', 'business-field' ) ); ?></span>
										<span class="entry-day"><?php the_time( esc_html_x( 'd', 'date format', 'business-field' ) ); ?></span>
									</div>

									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<?php if ( false === $params['block_disable_excerpt_2'] ) : ?>
										<?php
										$summary = business_field_the_excerpt( absint( $params['block_excerpt_length_2'] ) );
										echo wp_kses_post( wpautop( $summary ) );
										?>
									<?php endif; ?>

								</div><!-- .block-post -->
							<?php endwhile; ?>

							<?php wp_reset_postdata(); ?>

						<?php endif; ?>

					</div><!-- .recent-blocks -->

				</div> <!-- .inner-wrapper -->
			</div><!-- .news-and-blocks -->
			<?php

			echo $args['after_widget'];
		}
	}
endif;

