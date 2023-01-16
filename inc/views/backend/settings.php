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
            'about' => array('label' => __('About', 'just-likes-and-dislikes'))
        );

        $jlad_tab_counter = 0;
        foreach ($jlad_tabs as $jlad_tab => $jlad_tab_detail) {
            $jlad_tab_counter++;
            ?>
            <a href="javascript:void(0);" class="nav-tab <?php echo ($jlad_tab_counter == 1) ? 'nav-tab-active' : ''; ?> jlad-tab-trigger" data-settings-ref="<?php echo esc_attr($jlad_tab); ?>"><?php echo esc_html($jlad_tab_detail['label']); ?></a>
            <?php
        }
        ?>

    </h2>
    <div class="jlad-settings-section-wrap">
        <form method="post" class="jlad-settings-form">
            <?php settings_fields( 'just-likes-and-dislikes' ); ?>

            <?php require JLAD_PATH . 'inc/views/backend/boxes/basic.php'; ?>
            <?php require JLAD_PATH . 'inc/views/backend/boxes/design.php'; ?>
            <?php require JLAD_PATH . 'inc/views/backend/boxes/about.php'; ?>

            <div class="jlad-field-wrap jlad-settings-action">
                <label></label>
                <div class="jlad-field">
                    <?php submit_button( '', 'primary', '', false );; ?>
                </div>
            </div>
        </form>

    </div>
    <div class="jlad-info-wrap" style="display:none;">
        <img src="<?php echo esc_attr(JLAD_IMG_DIR . '/ajax-loader.gif'); ?>" class="jlad-loader"/>
        <span class="jlad-info"><?php _e('Please wait.', 'just-likes-and-dislikes'); ?></span>
        <span class="dashicons dashicons-dismiss jlad-close-info"></span>
    </div>
</div>