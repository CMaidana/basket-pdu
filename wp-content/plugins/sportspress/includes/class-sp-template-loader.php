<?php
/**
 * Template Loader
 *
 * @class 		SP_Template_Loader
 * @version		2.0.7
 * @package		SportsPress/Classes
 * @category	Class
 * @author 		ThemeBoy
 */
class SP_Template_Loader {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'template_include', array( $this, 'template_loader' ) );
		add_filter( 'the_content', array( $this, 'event_content' ) );
		add_filter( 'the_content', array( $this, 'calendar_content' ) );
		add_filter( 'the_content', array( $this, 'team_content' ) );
		add_filter( 'the_content', array( $this, 'table_content' ) );
		add_filter( 'the_content', array( $this, 'player_content' ) );
		add_filter( 'the_content', array( $this, 'list_content' ) );
		add_filter( 'the_content', array( $this, 'staff_content' ) );
	}

	public function add_content( $content, $type, $position = 10, $caption = null ) {
		if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
		if ( ! in_the_loop() ) return; // Return if not in main loop

		// Return password form if required
		if ( post_password_required() ) {
			echo get_the_password_form();
			return;
		}

		// Prepend caption to content if given
		if ( $content ) {
			if ( $caption ) {
				$content = '<h3 class="sp-post-caption">' . $caption . '</h3>' . $content;
			}

			$content = '<div class="sp-post-content">' . $content . '</div>';
		}

		global $wp_filter;
		
		// Array of hooks associated with this post type
		$hooks = array(
			'sportspress_before_single_' . $type,
			'sportspress_single_' . $type . '_content',
			'sportspress_after_single_' . $type,
		);
		
		$actions = array();
		
		// Find all actions associated with those hooks
		foreach ( $hooks as $hook ) {
			$priorities = sp_array_value( $wp_filter, $hook, array() );
			
			foreach ( $priorities as $priority => $action ) {
				$a = reset( $action );
				$function = sp_array_value( $a, 'function', false );
				remove_action( $hook, $function, $priority );
				$actions[] = $function;
			}
		}
		
		// Get layout setting
		$layout = (array) get_option( 'sportspress_' . $type . '_template_order', array() );
		
		// Combine layout setting with available templates
		$templates = array_merge( array_flip( $layout ), SP()->templates->$type );
		
		$templates = apply_filters( 'sportspress_' . $type . '_templates', $templates );

		ob_start();
		
		// Loop through templates
		foreach ( $templates as $key => $template ) {
			// Ignore templates that are unavailable or that have been turned off
			if ( ! is_array( $template ) ) continue;
			if ( ! isset( $template['option'] ) ) continue;
			if ( 'yes' !== get_option( $template['option'], sp_array_value( $template, 'default', 'yes' ) ) ) continue;
			
			// Render the template
			if ( 'content' === $key ) {
				echo $content;
			} else {
				call_user_func( $template['action'] );
			}
		}

		return ob_get_clean();
	}

	public function event_content( $content ) {
		if ( is_singular( 'sp_event' ) ) {
			$status = sp_get_status( get_the_ID() );
			if ( 'results' == $status ) {
				$caption = __( 'Recap', 'sportspress' );
			} else {
				$caption = __( 'Preview', 'sportspress' );
			}
			$content = self::add_content( $content, 'event', apply_filters( 'sportspress_event_content_priority', 10 ), $caption );
		}
		return $content;
	}

	public function calendar_content( $content ) {
		if ( is_singular( 'sp_calendar' ) )
			$content = self::add_content( $content, 'calendar', apply_filters( 'sportspress_calendar_content_priority', 10 ) );
		return $content;
	}

	public function team_content( $content ) {
		if ( is_singular( 'sp_team' ) )
			$content = self::add_content( $content, 'team', apply_filters( 'sportspress_team_content_priority', 10 ) );
		return $content;
	}

	public function table_content( $content ) {
		if ( is_singular( 'sp_table' ) )
			$content = self::add_content( $content, 'table', apply_filters( 'sportspress_table_content_priority', 10 ) );
		return $content;
	}

	public function player_content( $content ) {
		if ( is_singular( 'sp_player' ) )
			$content = self::add_content( $content, 'player', apply_filters( 'sportspress_player_content_priority', 10 ) );
		return $content;
	}

	public function list_content( $content ) {
		if ( is_singular( 'sp_list' ) )
			$content = self::add_content( $content, 'list', apply_filters( 'sportspress_list_content_priority', 10 ) );
		return $content;
	}

	public function staff_content( $content ) {
		if ( is_singular( 'sp_staff' ) )
			$content = self::add_content( $content, 'staff', apply_filters( 'sportspress_staff_content_priority', 10 ) );
		return $content;
	}

	/**
	 * Load a template.
	 *
	 * Handles template usage so that we can use our own templates instead of the themes.
	 *
	 * Templates are in the 'templates' folder. sportspress looks for theme
	 * overrides in /theme/sportspress/ by default
	 *
	 * For beginners, it also looks for a sportspress.php template last. If the user adds
	 * this to the theme (containing a sportspress() inside) this will be used as a
	 * fallback for all sportspress templates.
	 *
	 * @param mixed $template
	 * @return string
	 */
	public function template_loader( $template ) {
		$find = array();
		$file = '';

		if ( is_single() ):

			$post_type = get_post_type();
		
			if ( is_sp_post_type( $post_type ) ):
				$file = 'single-' . str_replace( 'sp_', '', $post_type ) . '.php';
				$find[] = $file;
				$find[] = SP_TEMPLATE_PATH . $file;
			endif;

		elseif ( is_tax() ):

			$term = get_queried_object();

			switch( $term->taxonomy ):
				case 'sp_venue':
				$file = 'taxonomy-venue.php';
				$find[] 	= 'taxonomy-venue-' . $term->slug . '.php';
				$find[] 	= SP_TEMPLATE_PATH . 'taxonomy-venue-' . $term->slug . '.php';
				$find[] 	= $file;
				$find[] 	= SP_TEMPLATE_PATH . $file;
			endswitch;

		endif;

		$find[] = 'sportspress.php';

		if ( $file ):
			$located       = locate_template( $find );
			if ( $located ):
				$template = $located;
			endif;
		endif;

		return $template;
	}
}

new SP_Template_Loader();
			