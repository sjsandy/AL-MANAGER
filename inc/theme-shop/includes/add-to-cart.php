<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<p>
<?php

global $post, $post_id;

echo get_post_meta($post_id, '_nonce-test', true);

echo $post_id . ' - ' . $post->ID;

  wp_nonce_field('items_nonce_action', 'items_nonce_name');


?>
</p>

<div class="container">
   <table class="widefat">
<thead>
    <tr>
        <th>RegId</th>
        <th>Name</th>
        <th>Email</th>
    </tr>
</thead>
<tfoot>
    <tr>
    <th>RegId</th>
    <th>Name</th>
    <th>Email</th>
    </tr>
</tfoot>
<tbody>
   <tr>
     <td>ID000000</td>
     <td>MY NAME</td>
     <td>me@me.com</td>
   </tr>
   <tr>
     <td>ID000000</td>
     <td>MY NAME</td>
     <td>me@me.com</td>
   </tr>
   <tr>
     <td>ID000000</td>
     <td>MY NAME</td>
     <td>me@me.com</td>
   </tr>
   <tr>
     <td>ID000000</td>
     <td>MY NAME</td>
     <td>me@me.com</td>
   </tr>
   <tr>
     <td>ID000000</td>
     <td>MY NAME</td>
     <td>me@me.com</td>
   </tr>
</tbody>
</table>
    <div class="row">
        <p>
            <strong>SELECT &AMP; ADD ITEM TO CART:</strong>
        </p>
        <p>
         <?php echo $cts_item_ftm = FN_forms::factory()->email_input('name', ''); ?>
        </p>
    </div>
    <!-- ###### -->
</div>