<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Business_Field
 */

?><?php
	/**
	 * Hook - business_field_action_doctype.
	 *
	 * @hooked business_field_doctype -  10
	 */
	do_action( 'business_field_action_doctype' );
?>
<head>
	<?php
	/**
	 * Hook - business_field_action_head.
	 *
	 * @hooked business_field_head -  10
	 */
	do_action( 'business_field_action_head' );
	?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	/**
	 * Hook - business_field_action_before.
	 *
	 * @hooked business_field_page_start - 10
	 * @hooked business_field_skip_to_content - 15
	 */
	do_action( 'business_field_action_before' );
	?>

    <?php
	  /**
	   * Hook - business_field_action_before_header.
	   *
	   * @hooked business_field_header_start - 10
	   */
	  do_action( 'business_field_action_before_header' );
	?>
		<?php
		/**
		 * Hook - business_field_action_header.
		 *
		 * @hooked business_field_site_branding - 10
		 */
		do_action( 'business_field_action_header' );
		?>
	<?php
	  /**
	   * Hook - business_field_action_after_header.
	   *
	   * @hooked business_field_header_end - 10
	   */
	  do_action( 'business_field_action_after_header' );
	?>

	<?php
	/**
	 * Hook - business_field_action_before_content.
	 *
	 * @hooked business_field_content_start - 10
	 */
	do_action( 'business_field_action_before_content' );
	?>
    <?php
	  /**
	   * Hook - business_field_action_content.
	   */
	  do_action( 'business_field_action_content' );
	?>
