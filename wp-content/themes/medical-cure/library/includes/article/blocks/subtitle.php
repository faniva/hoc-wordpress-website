<?php
$subtitle = get_post_meta(get_the_ID(), 'subtitle', true);
if ($subtitle != '') {
    echo '<p class="code125-article-subtitle">'.$subtitle.'</p>';
}
?>
