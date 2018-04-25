<?php
/*
todo: add option into theme options to add the discalimer {textarea-simple}
todo: validate the option here
todo: add the element
*/
$settings_obj = new C5_theme_options();
$article_disclaimer = $settings_obj->get_meta_option('article_disclaimer');

if ($article_disclaimer!='') { ?>
    <div class="code125-article-disclaimer">
    <p><?php echo "$article_disclaimer";?></p>
    </div>
<?php } ?>
