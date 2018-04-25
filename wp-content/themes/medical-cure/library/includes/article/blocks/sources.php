<?php

$article_sources = get_post_meta(get_the_ID(), 'sources_article', true );

if (is_array($article_sources) && count($article_sources) > 0 ) {
    ?>
    <div class="code125-article-sources">
        <ul>
            <li><?php echo esc_html__('Sources: ','medical-cure')?></li>
            <?php
            foreach( $article_sources as $source){
                if ($source['url'] == '' ) {
                    ?>
                    <li><span class="title-sources"><?php echo $source['title'];?></span></li>
                    <?php
                } else {
                    ?>
                    <li>
                        <a class="code125-article-sources-url" href="<?php echo esc_url($source['url']); ?>">
                            <span class="title-sources"><?php echo $source['title']; ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
    <?php
}
