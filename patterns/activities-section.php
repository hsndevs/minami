<?php
/**
 * Title: Activities Section
 * Slug: minami/activities-section
 * Categories: hidden
 * Inserter: no
 */
?>
<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"0","right":"0"}},"background":{"backgroundImage":{"url":"<?php echo get_theme_file_uri( '/assets/images/activities-bg.webp' ); ?>","id":213,"source":"file","title":"image"},"backgroundSize":"400px","backgroundAttachment":"scroll","backgroundPosition":"50% 40%","backgroundRepeat":"no-repeat"}},"layout":{"type":"constrained","contentSize":"1352px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--70);padding-right:0;padding-bottom:var(--wp--preset--spacing--70);padding-left:0"><!-- wp:heading {"textAlign":"center","fontSize":"3x-large"} -->
<h2 class="wp-block-heading has-text-align-center has-3-x-large-font-size">Association Activities</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":4,"query":{"perPage":4,"pages":0,"offset":0,"postType":"activity","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"name":"Small image and title"},"className":"is-style-default","layout":{"type":"default"}} -->
<div class="wp-block-query is-style-default"><!-- wp:post-template {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<!-- wp:group {"className":"min-post-list-item","style":{"spacing":{"margin":{"bottom":"0"},"padding":{"bottom":"var:preset|spacing|30","top":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group min-post-list-item" style="margin-bottom:0;padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"className":"min-post-item-thumb","style":{"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"default"}} -->
<div class="wp-block-group min-post-item-thumb"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","width":"370px","style":{"layout":{"selfStretch":"fixed","flexSize":"300px"},"border":{"width":"2px","radius":"10px"}}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fill","flexSize":null},"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:post-date {"format":"n/j/Y","fontSize":"small"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"layout":{"selfStretch":"fill","flexSize":null}},"fontSize":"large"} /-->

<!-- wp:post-excerpt {"moreText":"\u003cstrong\u003eRead more...\u003c/strong\u003e","excerptLength":10,"fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-btn-default"} -->
<div class="wp-block-button is-style-btn-default"><a class="wp-block-button__link wp-element-button" href="/activities">See More...</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
