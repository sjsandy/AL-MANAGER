<?php

/**
 * Description of reaveal
 *
 * @author Studio365
 * @credits
 */
class reveal {

    public static $instance;
    private $template = '';

    /**
     * Stores the name of the template being rendered
     *
     * @param string $template The template name
     * @return string The unmodified template name
     */
    public function template_handler($template) {
        $this->template = $template;
        return $template;
    }

    /**
     * Formats for output the template path info for the currently rendered template.
     *
     * @param bool $echo (optional) Echo the template info? Default is true
     * @param string $template_path_type (optional) The style of the template's path for return. Accepts: 'absolute', 'relative', 'theme-relative', 'filename'
     * @param bool $in_footer (optional) Should the path info be output in the footer? Default is true
     * @return string The path info for the currently rendered template
     */
    public function reveal($template_path_type = 'filename', $echo = true, $in_footer = true) {
        $template = $this->template;

        switch ($template_path_type) {
            case 'absolute':
                // Do nothing; already have the absolute path
                break;
            case 'relative':
                $template = str_replace(ABSPATH, '', $template);
                break;
            case 'theme-relative':
                $template = basename(dirname($template)) . '/' . basename($template);
                break;
            case 'filename':
            default:
                $template = basename($template);
                break;
        }

        if ($in_footer) {
            // Should this check to see if user defined %template%, and if not, go ahead and display template?
            if ($options['format'])
                $display = str_replace('%template%', $template, $options['format']);
            else
                $display = $template;
            echo $display;
        } elseif ($echo) {
            echo $template;
        }

        return $template;
    }

    /**
	 * Returns either the buffered array of all options for the plugin, or
	 * obtains the options and buffers the value.
	 *
	 * @param bool $with_current_values (optional) Should the currently saved values be returned? If false, then the plugin's defaults are returned. Default is true.
	 * @return array The options array for the plugin (which is also stored in $this->options if !$with_options).
	 */
	protected function get_options( $with_current_values = true ) {
		if ( $with_current_values && !empty( $this->options ) )
			return $this->options;
		// Derive options from the config
		$options = array();
		$option_names = $this->get_option_names( !$with_current_values );
		foreach ( $option_names as $opt )
			$options[$opt] = $this->config[$opt]['default'];
		if ( !$with_current_values )
			return $options;
		$this->options = wp_parse_args( get_option( $this->admin_options_name ), $options );

		// Check to see if the plugin has been updated
		$this->check_if_plugin_was_upgraded();

		// Un-escape fields
		foreach ( $option_names as $opt ) {
			if ( $this->config[$opt]['allow_html'] == true ) {
				if ( is_array( $this->options[$opt] ) ) {
					foreach ( $this->options[$opt] as $key => $val ) {
						$new_key = wp_specialchars_decode( $key, ENT_QUOTES );
						$new_val = wp_specialchars_decode( $val, ENT_QUOTES );
						$this->options[$opt][$new_key] = $new_val;
						if ( $key != $new_key )
							unset( $this->options[$opt][$key] );
					}
				} else {
					$this->options[$opt] = wp_specialchars_decode( $this->options[$opt], ENT_QUOTES );
				}
			}
		}
		return apply_filters( $this->get_hook( 'options' ), $this->options );
	}

}
