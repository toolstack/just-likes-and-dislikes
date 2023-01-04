<div class="jlad-settings-section" data-settings-ref="design" style="display:none;">
			<div class="jlad-field-wrap">
				<label><?php _e( 'Choose Template', 'just-likes-and-dislikes' ); ?></label>
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
						$jlad_total_templates = apply_filters( 'jlad_total_templates', 4 );
						for ( $i = 1; $i <= $jlad_total_templates; $i++ ) {
							?>
							<option value="template-<?php echo $i; ?>" <?php selected( $jlad_settings['design_settings']['template'], 'template-' . $i ); ?>><?php echo __( 'Template ', 'just-likes-and-dislikes' ) . $i; ?></option>
							<?php
						}
						?>
						<option value="custom" <?php selected( $jlad_settings['design_settings']['template'], 'custom' ); ?>><?php _e( 'Custom Template', 'just-likes-and-dislikes' ); ?></option>
					</select>
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
				</div>
			</div>
			<div class="jlad-custom-ref" <?php if ( $jlad_settings['design_settings']['template'] != 'custom' ) { ?>style="display:none"<?php } ?>>
				<div class="jlad-field-wrap">
					<label><?php _e( 'Like Icon', 'just-likes-and-dislikes' ); ?></label>
					<div class="jlad-field">
						<input type="text" name="jlad_settings[design_settings][like_icon]" class="jlad-form-field" value="<?php echo esc_url( $jlad_settings['design_settings']['like_icon'] ) ?>"/>
						<input type="button" class="button-primary jlad-file-uploader" value="<?php _e( 'Upload Icon', 'just-likes-and-dislikes' ); ?>"/>
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
						<input type="button" class="button-primary jlad-file-uploader" value="<?php _e( 'Upload Icon', 'just-likes-and-dislikes' ); ?>"/>
						<span class="jlad-preview-holder"><?php if ( $jlad_settings['design_settings']['dislike_icon'] != '' ) { ?><img src="<?php echo esc_url( $jlad_settings['design_settings']['dislike_icon'] ); ?>"/><?php } ?></span>
					</div>
				</div>
			</div>
			<div class="jlad-field-wrap jlad-template-ref"  <?php if ( $jlad_settings['design_settings']['template'] == 'custom' ) { ?>style="display:none"<?php } ?>>
				<label><?php _e( 'Icon Color', 'just-likes-and-dislikes' ); ?></label>
				<div class="jlad-field">
					<input type="text" name="jlad_settings[design_settings][icon_color]" class="jlad-form-field jlad-colorpicker" value="<?php echo esc_attr( $jlad_settings['design_settings']['icon_color'] ) ?>"/>
				</div>
			</div>
			<div class="jlad-field-wrap">
				<label><?php _e( 'Count Color', 'just-likes-and-dislikes' ); ?></label>
				<div class="jlad-field">
					<input type="text" name="jlad_settings[design_settings][count_color]" class="jlad-form-field jlad-colorpicker" value="<?php echo esc_attr( $jlad_settings['design_settings']['count_color'] ) ?>"/>
				</div>
			</div>
		</div>