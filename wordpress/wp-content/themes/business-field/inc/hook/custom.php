<?php
/**
 * Custom theme functions.
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Business_Field
 */

if ( ! function_exists( 'business_field_skip_to_content' ) ) :
	/**
	 * Add Skip to content.
	 *
	 * @since 1.0.0
	 */
	function business_field_skip_to_content() {
		?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'business-field' ); ?></a><?php
	}
endif;

add_action( 'business_field_action_before', 'business_field_skip_to_content', 15 );

if ( ! function_exists( 'business_field_site_branding' ) ) :

	/**
	 * Site branding.
	 *
	 * @since 1.0.0
	 */
	function business_field_site_branding() {
		?>
		<div class="site-branding">

			<?php business_field_the_custom_logo(); ?>

			<?php $show_title = business_field_get_option( 'show_title' ); ?>
			<?php $show_tagline = business_field_get_option( 'show_tagline' ); ?>
			<?php if ( true === $show_title || true === $show_tagline ) : ?>
				<div id="site-identity">
					<?php if ( true === $show_title ) :  ?>
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( true === $show_tagline ) :  ?>
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div><!-- #site-identity -->
			<?php endif; ?>
	    </div><!-- .site-branding -->
    	<?php $search_in_header = business_field_get_option( 'search_in_header' ); ?>
	    <?php if ( true === $search_in_header ) : ?>
	    	<div class="header-search-box">
		    	<a href="#" class="search-icon"><i class="fa fa-search"></i></a>
		    	<div class="search-box-wrap">
	    			<?php get_search_form(); ?>
		    	</div><!-- .search-box-wrap -->
		    </div><!-- .header-search-box -->
		<?php endif; ?>
	    <div id="main-nav">
	        <nav id="site-navigation" class="main-navigation" role="navigation">
	            <div class="wrap-menu-content">
					<?php
					wp_nav_menu(
						array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'fallback_cb'    => 'business_field_primary_navigation_fallback',
						)
					);
					?>
	            </div><!-- .menu-content -->
	        </nav><!-- #site-navigation -->
	    </div> <!-- #main-nav -->
	    <?php
	}

endif;

add_action( 'business_field_action_header', 'business_field_site_branding' );

if ( ! function_exists( 'business_field_mobile_navigation' ) ) :

	/**
	 * Mobile navigation.
	 *
	 * @since 1.0.0
	 */
	function business_field_mobile_navigation() {
		?>
		<a id="mobile-trigger" href="#mob-menu"><i class="fa fa-bars"></i></a>
		<div id="mob-menu">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => '',
				'fallback_cb'    => 'business_field_primary_navigation_fallback',
				) );
			?>
		</div><!-- #mob-menu -->
		<?php
	}

endif;

add_action( 'business_field_action_before', 'business_field_mobile_navigation', 20 );

if ( ! function_exists( 'business_field_footer_copyright' ) ) :

	/**
	 * Footer copyright.
	 *
	 * @since 1.0.0
	 */
	function business_field_footer_copyright() {

		// Check if footer is disabled.
		$footer_status = apply_filters( 'business_field_filter_footer_status', true );
		if ( true !== $footer_status ) {
			return;
		}

		// Footer Menu.
		$footer_menu_content = wp_nav_menu( array(
			'theme_location' => 'footer',
			'container'      => 'div',
			'container_id'   => 'footer-navigation',
			'depth'          => 1,
			'fallback_cb'    => false,
			'echo'           => false,
		) );

		// Copyright content.
		$copyright_text = business_field_get_option( 'copyright_text' );
		$copyright_text = apply_filters( 'business_field_filter_copyright_text', $copyright_text );
		if ( ! empty( $copyright_text ) ) {
			$copyright_text = wp_kses_data( $copyright_text );
		}

		// Powered by content.
		$powered_by_text = sprintf( esc_html__( 'Business Field by %s', 'business-field' ), '<a target="_blank" rel="designer" href="https://wenthemes.com/">' . esc_html__( 'WEN Themes', 'business-field' ) . '</a>' );

		$show_social_in_footer = business_field_get_option( 'show_social_in_footer' );

		$column_count = 0;

		if ( $footer_menu_content ) {
			$column_count++;
		}
		if ( $copyright_text ) {
			$column_count++;
		}
		if ( $powered_by_text ) {
			$column_count++;
		}
		if ( true === $show_social_in_footer && has_nav_menu( 'social' ) ) {
			$column_count++;
		}
		?>

		<div class="colophon-inner colophon-grid-<?php echo esc_attr( $column_count ); ?>">
			<div class="colophon-column-left">
				<?php if ( ! empty( $copyright_text ) ) : ?>
					<div class="colophon-column">
						<div class="copyright">
							<?php echo $copyright_text; ?>
						</div><!-- .copyright -->
					</div><!-- .colophon-column -->
				<?php endif; ?>

				<?php if ( ! empty( $footer_menu_content ) ) : ?>
					<div class="colophon-column">
						<?php echo $footer_menu_content; ?>
					</div><!-- .colophon-column -->
				<?php endif; ?>

			</div> <!-- .colophon-column-left -->
			<div class="colophon-column-right">

				<?php if ( true === $show_social_in_footer && has_nav_menu( 'social' ) ) : ?>
					<div class="colophon-column">
						<div class="footer-social">
							<?php the_widget( 'Business_Field_Social_Widget' ); ?>
						</div><!-- .footer-social -->
					</div><!-- .colophon-column -->
				<?php endif; ?>

				<?php if ( ! empty( $powered_by_text ) ) : ?>
					<div class="colophon-column">
						<div class="site-info">
							<?php echo $powered_by_text; ?>
						</div><!-- .site-info -->
					</div><!-- .colophon-column -->
				<?php endif; ?>
			</div> <!-- .colophon-column-right -->
		</div><!-- .colophon-inner -->

	    <?php
	}

endif;

add_action( 'business_field_action_footer', 'business_field_footer_copyright', 10 );

if ( ! function_exists( 'business_field_add_sidebar' ) ) :

	/**
	 * Add sidebar.
	 *
	 * @since 1.0.0
	 */
	function business_field_add_sidebar() {

		global $post;

		$global_layout = business_field_get_option( 'global_layout' );
		$global_layout = apply_filters( 'business_field_filter_theme_global_layout', $global_layout );

		// Check if single.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'business_field_theme_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = $post_options['post_layout'];
			}
		}

		// Include primary sidebar.
		if ( 'no-sidebar' !== $global_layout ) {
			get_sidebar();
		}

		// Include Secondary sidebar.
		switch ( $global_layout ) {
			case 'three-columns':
			get_sidebar( 'secondary' );
			break;

			default:
			break;
		}

	}

endif;

add_action( 'business_field_action_sidebar', 'business_field_add_sidebar' );

if ( ! function_exists( 'business_field_custom_posts_navigation' ) ) :

	/**
	 * Posts navigation.
	 *
	 * @since 1.0.0
	 */
	function business_field_custom_posts_navigation() {

		the_posts_pagination();

	}
endif;

add_action( 'business_field_action_posts_navigation', 'business_field_custom_posts_navigation' );

if ( ! function_exists( 'business_field_add_image_in_single_display' ) ) :

	/**
	 * Add image in single post.
	 *
	 * @since 1.0.0
	 */
	function business_field_add_image_in_single_display() {

		global $post;

		if ( has_post_thumbnail() ) {

			$values = get_post_meta( $post->ID, 'business_field_theme_settings', true );
			$business_field_theme_settings_single_image = isset( $values['single_image'] ) ? esc_attr( $values['single_image'] ) : '';

			if ( ! $business_field_theme_settings_single_image ) {
				$business_field_theme_settings_single_image = business_field_get_option( 'single_image' );
			}

			if ( 'disable' !== $business_field_theme_settings_single_image ) {
				$args = array(
					'class' => 'aligncenter',
				);
				the_post_thumbnail( esc_attr( $business_field_theme_settings_single_image ), $args );
			}
		}

	}

endif;

add_action( 'business_field_single_image', 'business_field_add_image_in_single_display' );

if ( ! function_exists( 'business_field_add_breadcrumb' ) ) :

	/**
	 * Add breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function business_field_add_breadcrumb() {

		// Bail if Breadcrumb disabled.
		$breadcrumb_type = business_field_get_option( 'breadcrumb_type' );
		if ( 'disabled' === $breadcrumb_type ) {
			return;
		}

		// Bail if Home Page.
		if ( is_front_page() || is_home() ) {
			return;
		}

		echo '<div id="breadcrumb"> <div class="container">';

		switch ( $breadcrumb_type ) {
			case 'simple':
				business_field_simple_breadcrumb();
			break;

			default:
			break;
		}

		echo '</div></div><!-- #breadcrumb -->';

	}

endif;

add_action( 'business_field_action_breadcrumb', 'business_field_add_breadcrumb' );

if ( ! function_exists( 'business_field_footer_goto_top' ) ) :

	/**
	 * Go to top.
	 *
	 * @since 1.0.0
	 */
	function business_field_footer_goto_top() {

		echo '<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a>';

	}

endif;

add_action( 'business_field_action_after', 'business_field_footer_goto_top', 20 );

if ( ! function_exists( 'business_field_add_front_page_widget_area' ) ) :

	/**
	 * Add Front Page Widget area.
	 *
	 * @since 1.0.0
	 */
	function business_field_add_front_page_widget_area() {

		$current_id = business_field_get_index_page_id();

		if ( is_front_page() && get_queried_object_id() === $current_id && $current_id > 0 ) {
			echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
			if ( is_active_sidebar( 'sidebar-front-page-widget-area' ) ) {
				dynamic_sidebar( 'sidebar-front-page-widget-area' );
			}
			else {
				do_action( 'business_field_action_default_front_page_widget_area' );
			}
			echo '</div><!-- #sidebar-front-page-widget-area -->';
		}

	}
endif;

add_action( 'business_field_action_before_content', 'business_field_add_front_page_widget_area', 7 );

if ( ! function_exists( 'business_field_check_home_page_content' ) ) :

	/**
	 * Check home page content status.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $status Home page content status.
	 * @return bool Modified home page content status.
	 */
	function business_field_check_home_page_content( $status ) {

		if ( is_front_page() ) {
			$home_content_status = business_field_get_option( 'home_content_status' );
			if ( false === $home_content_status ) {
				$status = false;
			}
		}

		return $status;

	}

endif;

add_action( 'business_field_filter_home_page_content', 'business_field_check_home_page_content' );

if ( ! function_exists( 'business_field_add_custom_header' ) ) :

	/**
	 * Add Custom Header.
	 *
	 * @since 1.0.0
	 */
	function business_field_add_custom_header() {

		$flag_apply_custom_header = apply_filters( 'business_field_filter_custom_header_status', true );
		if ( true !== $flag_apply_custom_header ) {
			return;
		}
		$attribute = '';
		$attribute = apply_filters( 'business_field_filter_custom_header_style_attribute', $attribute );
		?>
		<div id="custom-header" <?php echo ( ! empty( $attribute ) ) ? ' style="' . esc_attr( $attribute ) . '" ' : ''; ?>>
			<div class="container">
				<?php
					/**
					 * Hook - business_field_action_custom_header.
					 */
					do_action( 'business_field_action_custom_header' );
				?>
			</div><!-- .container -->
		</div><!-- #custom-header -->

	    <?php do_action( 'business_field_action_breadcrumb' ); ?>

		<?php

	}
endif;

add_action( 'business_field_action_before_content', 'business_field_add_custom_header', 6 );

if ( ! function_exists( 'business_field_add_title_in_custom_header' ) ) :

	/**
	 * Add title in Custom Header.
	 *
	 * @since 1.0.0
	 */
	function business_field_add_title_in_custom_header() {
		$tag = 'h1';
		if ( is_front_page() ) {
			$tag = 'h2';
		}
		$custom_page_title = apply_filters( 'business_field_filter_custom_page_title', '' );
		?>
		<div class="header-content">
			<div class="header-content-inner">
				<?php if ( ! empty( $custom_page_title ) ) : ?>
					<?php echo '<' . $tag . ' class="page-title">'; ?>
					<?php echo esc_html( $custom_page_title ); ?>
					<?php echo '</' . $tag . '>'; ?>
				<?php endif; ?>
			</div><!-- .header-content-inner -->
        </div><!-- .header-content -->
		<?php
	}

endif;

add_action( 'business_field_action_custom_header', 'business_field_add_title_in_custom_header' );

if ( ! function_exists( 'business_field_customize_page_title' ) ) :

	/**
	 * Add title in Custom Header.
	 *
	 * @since 1.0.0
	 *
	 * @param string $title Title.
	 * @return string Modified title.
	 */
	function business_field_customize_page_title( $title ) {

		if ( is_front_page() && 'posts' === get_option( 'show_on_front' ) ) {
			$title = business_field_get_option( 'blog_title' );
		}
		elseif ( is_home() && ( $blog_page_id = business_field_get_index_page_id( 'blog' ) ) > 0 ) {
			$title = business_field_get_option( 'blog_title' );
		}
		elseif ( is_singular() ) {
			$title = single_post_title( '', false );
		}
		elseif ( is_archive() ) {
			$title = strip_tags( get_the_archive_title() );
		}
		elseif ( is_search() ) {
			$title = sprintf( __( 'Search Results for: %s', 'business-field' ),  get_search_query() );
		}
		elseif ( is_404() ) {
			$title = __( '404!', 'business-field' );
		}
		return $title;
	}
endif;

add_filter( 'business_field_filter_custom_page_title', 'business_field_customize_page_title' );

if ( ! function_exists( 'business_field_add_image_in_custom_header' ) ) :

	/**
	 * Add image in Custom Header.
	 *
	 * @since 1.0.0
	 */
	function business_field_add_image_in_custom_header( $input ) {

		$image_details = array();

		if ( empty( $image_details ) ) {

			// Fetch from Custom Header Image.
			$image = get_header_image();
			if ( ! empty( $image ) ) {
				$image_details['url']    = $image;
				$image_details['width']  = get_custom_header()->width;
				$image_details['height'] = get_custom_header()->height;
			}
		}

		if ( ! empty( $image_details ) ) {
			$input .= 'background-image:url(' . esc_url( $image_details['url'] ) . ');';
			$input .= 'background-size:cover;';
		}

		return $input;

	}

endif;

add_filter( 'business_field_filter_custom_header_style_attribute', 'business_field_add_image_in_custom_header' );

if( ! function_exists( 'business_field_check_custom_header_status' ) ) :

	/**
	 * Check status of custom header.
	 *
	 * @since 1.0.0
	 */
	function business_field_check_custom_header_status( $input ) {

		if ( is_front_page() && ! is_home() ) {
			$input = false;
		}

		return $input;

	}

endif;

add_filter( 'business_field_filter_custom_header_status', 'business_field_check_custom_header_status' );
