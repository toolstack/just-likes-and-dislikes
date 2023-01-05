<?php
$jlad_settings = $this->jlad_settings;
?>
<div class="wrap jlad-wrap">
    <h1><?php _e('Just Likes and Dislikes', 'just-likes-and-dislikes'); ?></h1>
    <div class="jlad-clear"></div>
    <h2 class="nav-tab-wrapper wp-clearfix">
        <?php
        $jlad_tabs = array(
            'basic' => array('label' => __('Basic', 'just-likes-and-dislikes')),
            'design' => array('label' => __('Design', 'just-likes-and-dislikes')),
            'help' => array('label' => __('Help', 'just-likes-and-dislikes')),
            'about' => array('label' => __('About', 'just-likes-and-dislikes'))
        );
        /**
         * Filters the tabs
         *
         * @since 1.0.0
         *
         * @param array $jlad_tabs
         */
        $jlad_tabs = apply_filters('jlad_admin_tabs', $jlad_tabs);
        $jlad_tab_counter = 0;
        foreach ($jlad_tabs as $jlad_tab => $jlad_tab_detail) {
            $jlad_tab_counter++;
            ?>
            <a href="javascript:void(0);" class="nav-tab <?php echo ($jlad_tab_counter == 1) ? 'nav-tab-active' : ''; ?> jlad-tab-trigger" data-settings-ref="<?php echo esc_attr( $jlad_tab ); ?>"><?php echo esc_html( $jlad_tab_detail['label'] ); ?></a>
            <?php
        }
        ?>

    </h2>
    <div class="jlad-settings-section-wrap">
        <form class="jlad-settings-form">
            <?php require JLAD_PATH . 'inc/views/backend/boxes/basic.php'; ?>
            <?php require JLAD_PATH . 'inc/views/backend/boxes/design.php'; ?>
            <?php require JLAD_PATH . 'inc/views/backend/boxes/help.php'; ?>
            <?php require JLAD_PATH . 'inc/views/backend/boxes/about.php'; ?>

            <?php
            /**
             * Fires when displaying the tabs section
             *
             * @param array $jlad_settings
             *
             * @since 1.0.0
             */
            do_action('jlad_admin_tab_section', $jlad_settings);
            ?>
            <div class="jlad-field-wrap jlad-settings-action">
                <label></label>
                <div class="jlad-field">
                    <input type="submit" class="jlad-settings-save-trigger button-primary" value="<?php _e('Save settings', 'just-likes-and-dislikes'); ?>"/>
                    <input type="button" class="jlad-settings-restore-trigger button-secondary" value="<?php _e('Restore settings', 'just-likes-and-dislikes'); ?>"/>
                </div>
            </div>
        </form>

    </div>
    <div class="jlad-info-wrap" style="display:none;">
        <img src="<?php echo esc_attr( JLAD_IMG_DIR . '/ajax-loader.gif' ); ?>" class="jlad-loader"/>
        <span class="jlad-info"><?php _e('Please wait.', 'just-likes-and-dislikes'); ?></span>
        <span class="dashicons dashicons-dismiss jlad-close-info"></span>
    </div>
</div>