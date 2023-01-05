<div class="jlad-settings-section" data-settings-ref="design" style="display:none;">
	<div class="jlad-field-wrap">
        <div class="jlad-field-description">
			<label class="jlad-field-label"><?php _e( 'Choose template', 'just-likes-and-dislikes' ); ?>: </label>
		</div>
		<div class="jlad-field">
			<select name="jlad_settings[design_settings][template]" class="jlad-form-field jlad-template-dropdown">
				<?php
				/**
				 * Filters total number or templates
				 *
				 * @param int
				 *
				 * @since 1.0.0
				 */
				$jlad_total_templates = apply_filters( 'jlad_total_templates', 5 );
				$jlad_template_names = $this->get_template_names();

				for ( $i = 1; $i <= $jlad_total_templates; $i++ ) {
					?>
					<option value="template-<?php echo $i; ?>" <?php selected( $jlad_settings['design_settings']['template'], 'template-' . $i ); ?>><?php echo $jlad_template_names['template-'. $i]; ?></option>
					<?php
				}
				?>
				<option value="custom" <?php selected( $jlad_settings['design_settings']['template'], 'custom' ); ?>><?php _e( 'Custom Template', 'just-likes-and-dislikes' ); ?></option>
			</select>
            <p class="description">(<?php _e('select the like/dislike template you wish to use, or use custom images', 'just-likes-and-dislikes'); ?>)</p>
			<div class="jlad-template-previews-wrap">
				<?php for ( $i = 1; $i <= 4; $i++ ) {
					?>
					<div class="jlad-each-template-preview" <?php if ( 'template-' . $i != $jlad_settings['design_settings']['template'] ) { ?>style="display:none"<?php } ?> data-template-ref="template-<?php echo $i; ?>"><img src="<?php echo JLAD_IMG_DIR . '/template-' . $i . '.jpeg'; ?>"/></div>
					<?php
				}

				/**
				 * Fires on backend template preview
				 *
				 * Useful to add additional templates in backend
				 *
				 * @param array $jlad_settings
				 *
				 * @since 1.0.0
				 *
				 */
				do_action( 'jlad_template_previews',$jlad_settings );
				?>

			</div>
			<div class="jlad-custom-ref" <?php if ( $jlad_settings['design_settings']['template'] != 'custom' ) { ?>style="display:none"<?php } ?>>
				<div class="jlad-field-wrap">
					<label><br><?php _e( 'Like Icon', 'just-likes-and-dislikes' ); ?></label>
					<div class="jlad-field">
						<input type="text" name="jlad_settings[design_settings][like_icon]" class="jlad-form-field" value="<?php echo esc_url( $jlad_settings['design_settings']['like_icon'] ) ?>"/>
						<br>
						<br>
						<input type="button" class="button-primary jlad-file-uploader" value="<?php _e( 'Upload Like Icon', 'just-likes-and-dislikes' ); ?>"/>
						<span class="jlad-preview-holder">
							<?php if ( $jlad_settings['design_settings']['dislike_icon'] != '' ) { ?>
								<img src="<?php echo esc_url( $jlad_settings['design_settings']['like_icon'] ); ?>"/>
							<?php } ?>
						</span>
					</div>
				</div>
				<div class="jlad-field-wrap">
					<label><?php _e( 'Dislike Icon', 'just-likes-and-dislikes' ); ?></label>
					<div class="jlad-field">
						<input type="text" name="jlad_settings[design_settings][dislike_icon]" class="jlad-form-field" value="<?php echo esc_url( $jlad_settings['design_settings']['dislike_icon'] ) ?>"/>
						<br>
						<br>
						<input type="button" class="button-primary jlad-file-uploader" value="<?php _e( 'Upload Dislike Icon', 'just-likes-and-dislikes' ); ?>"/>
						<span class="jlad-preview-holder"><?php if ( $jlad_settings['design_settings']['dislike_icon'] != '' ) { ?><img src="<?php echo esc_url( $jlad_settings['design_settings']['dislike_icon'] ); ?>"/><?php } ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="jlad-field-wrap jlad-template-ref"  <?php if ( $jlad_settings['design_settings']['template'] == 'custom' ) { ?>style="display:none"<?php } ?>>
        <div class="jlad-field-description">
			<label class="jlad-field-label"><?php _e( 'Icon color', 'just-likes-and-dislikes' ); ?>: </label>
		</div>
		<div class="jlad-field">
			<input type="text" name="jlad_settings[design_settings][icon_color]" class="jlad-form-field jlad-colorpicker" value="<?php echo esc_attr( $jlad_settings['design_settings']['icon_color'] ) ?>"/>
            <p class="description">(<?php _e('override the color of the like/dislike icons provided by your active theme', 'just-likes-and-dislikes'); ?>)</p>
		</div>
	</div>
	<div class="jlad-field-wrap">
        <div class="jlad-field-description">
			<label class="jlad-field-label"><?php _e( 'Counter color', 'just-likes-and-dislikes' ); ?>: </label>
		</div>
		<div class="jlad-field">
			<input type="text" name="jlad_settings[design_settings][count_color]" class="jlad-form-field jlad-colorpicker" value="<?php echo esc_attr( $jlad_settings['design_settings']['count_color'] ) ?>"/>
            <p class="description">(<?php _e('override the color of the like/dislike text provided by your active theme', 'just-likes-and-dislikes'); ?>)</p>
		</div>
	</div>
</div>