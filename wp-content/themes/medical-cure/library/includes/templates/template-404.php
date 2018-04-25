<?php

$template_404 = ot_get_option('404_template');
if ($template_404!='') {
	echo do_shortcode('[c5ab_template id="'.$template_404.'"]');
	return;
}
 ?>

<!-- 404 Page -->
<section class="c5-error c5-no-padding">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- col-md-12 -->
            <div class="col-md-12 col-sm-12">
                <div class="c5-error-content">
                    <div class="c5-data">
						<h1><?php esc_html_e('404', 'medical-cure') ?></h1>
                        <h2><?php esc_html_e('The page can\'t be found.', 'medical-cure') ?></h2>
                        <p><?php esc_html_e('Nothing was found at this address. Maybe try a search? or head back to ', 'medical-cure'); ?><a href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_html_e('Homepage', 'medical-cure') ?></a></p>

                    </div>
					<div class="c5-form-style">
						<form method="get" action="<?php echo esc_url( home_url('/') ); ?>">

							<input type="text" name="s" id="with-label" placeholder="<?php echo ot_get_option('search_placeholder', 'Try Our Search'); ?>">
							<button class="c5-btn-theme" type="submit">
								<span class="fa fa-search"></span>
							</button>

						</form>
					</div>
                </div>
            </div>
            <!-- ./col-md-12 -->
        </div>
        <!-- ./row -->

    </div>
    <!-- ./container -->
</section>
<!-- ./404 Page -->
