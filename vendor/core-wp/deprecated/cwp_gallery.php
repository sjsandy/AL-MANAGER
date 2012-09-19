<?php



/**
 * Description of cwp_gallery
 *
 * @author Studio365
 */
class cwp_gallery {
    //put your code here

    /**
 * Add "Include in Rotator" option to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */

public function be_attachment_field_rotator( $form_fields, $post ) {

	// Set up options
	$options = array( '1' => 'Yes', '0' => 'No' );

	// Get currently selected value
	$selected = get_post_meta( $post->ID, 'be_rotator_include', true );

	// If no selected value, default to 'No'
	if( !isset( $selected ) )
		$selected = '0';

	// Display each option
	foreach ( $options as $value => $label ) {
		$checked = '';
		$css_id = 'rotator-include-option-' . $value;

		if ( $selected == $value ) {
			$checked = " checked='checked'";
		}

		$html = "<div class='rotator-include-option'><input type='radio' name='attachments[$post->ID][be-rotator-include]' id='{$css_id}' value='{$value}'$checked />";

		$html .= "<label for='{$css_id}'>$label</label>";

		$html .= '</div>';

		$out[] = $html;
	}

	// Construct the form field
	$form_fields['be-include-rotator'] = array(
		'label' => 'Include in Rotator',
		'input' => 'html',
		'html'  => join("\n", $out),
	);

	// Return all form fields
	return $form_fields;
}




/**
 * Save value of "Include in Rotator" selection in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */

public function be_attachment_field_rotator_save( $post, $attachment ) {
	if( isset( $attachment['be-rotator-include'] ) )
		update_post_meta( $post['ID'], 'be_rotator_include', $attachment['be-rotator-include'] );

	return $post;
}



public static function gallery_rotator(){
    add_filter( 'attachment_fields_to_edit', array('cwp_gallery', 'be_attachment_field_rotator'), 10, 2 );
    add_filter( 'attachment_fields_to_save', array('cwp_gallery','be_attachment_field_rotator_save'), 10, 2 );
}

}