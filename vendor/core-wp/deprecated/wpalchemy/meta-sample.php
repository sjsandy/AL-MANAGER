<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$custom_metabox = $simple_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_custom_meta',
	'title' => 'My Custom Meta',
	'template' => get_stylesheet_directory() . '/metaboxes/simple-meta.php',
));

/* eof */

// usually needed
global $custom_metabox;

// get the meta data for the current post
$custom_metabox->the_meta();

// set current field, then get value
$custom_metabox->the_field('name');
$custom_metabox->the_value();

// get value directly
$custom_metabox->the_value('description');

// loop a set of fields
while($custom_metabox->have_fields('authors'))
{
	$custom_metabox->the_value();
}

// loop a set of field groups
while($custom_metabox->have_fields('links'))
{
	$custom_metabox->the_value('title');

	$custom_metabox->the_value('url');

	if ($custom_metabox->get_the_value('nofollow')) echo 'is-nofollow';

	$custom_metabox->the_value('target');
}

?>

<div class="my_meta_control">

	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras orci lorem, bibendum in pharetra ac, luctus ut mauris.</p>

	<label>Title</label>

	<p>
		<?php $mb->the_field('title'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter in a title</span>
	</p>

	<label>Description <span>(optional)</span></label>

	<p>
		<?php $mb->the_field('description'); ?>
		<textarea name="<?php $mb->the_name(); ?>" rows="3"><?php $mb->the_value(); ?></textarea>
		<span>Enter in a description</span>
	</p>

</div>


