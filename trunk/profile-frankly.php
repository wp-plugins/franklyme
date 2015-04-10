<?php


function frankly_add_custom_user_profile_fields( $user ) {
?>

	<h3><?php _e('Frankly.me Profile Information', 'frankly-me'); ?></h3>
	
	<table class="form-table">
		<tr>
			<th>
				<label for="frankly"><?php _e('Frankly.me User Name', 'frankly-me'); ?>
			</label></th>
			<td>
				<input type="text" name="frankly" id="frankly" value="<?php echo esc_attr( get_the_author_meta( 'frankly', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your Frankly.me User Name.', 'frankly-me'); ?></span>
			</td>
		</tr>
	</table>

<?php 
}

function frankly_save_custom_user_profile_fields( $user_id ) {
	
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;
	
	update_usermeta( $user_id, 'frankly', $_POST['frankly'] );
}

add_action( 'show_user_profile', 'frankly_add_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'frankly_add_custom_user_profile_fields' );

add_action( 'personal_options_update', 'frankly_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'frankly_save_custom_user_profile_fields' );


?>