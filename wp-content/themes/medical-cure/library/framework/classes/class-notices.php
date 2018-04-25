<?php
/**
 *
 */
class C5_ADMIN_NOTICES
{

    function __construct()
    {
        add_action( 'admin_notices', array($this, 'admin_notices') );
        add_action( 'c5_admin_panel_header', array($this, 'admin_notices_panel') );

    }
    public function admin_notices()
    {
        if (!class_exists('C5_AO_CPT')) {
            return '';
        }
        ?>
        <div id="c5-updates-message" class="notice error warning"><p> <strong>Theme Notice:</strong> We recommend you to deactivate "<strong>Code125 Theme Advanced Options</strong>" plugin as it may lead to some incompatibility with your current theme.</p></div>
        <?php
    }
    public function admin_notices_panel()
    {
        if (!class_exists('C5_AO_CPT')) {
            return '';
        }
        ?>
        <div id="c5-updates-message" class="c5-notice c5-notice-red"><p> <strong>Theme Notice:</strong> We recommend you to deactivate "<strong>Code125 Theme Advanced Options</strong>" plugin as it may lead to some incompatibility with your current theme.</p></div>
        <?php
    }

}
$notice_object = new C5_ADMIN_NOTICES();
 ?>
