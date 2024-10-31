<div id="insight-samsung-feed-widget" class="widget widget_insight_samsung_feed_widget">
    <div class="tab-holder tabs-widget">
        <div class="tab-hold tabs-wrapper">
            <div class="tab-box-header">
                <a href="<?php echo $category_url; ?>" target="_blank"><img src="<?php echo plugins_url('assets/img/samsung-logo.png',dirname(__FILE__)) ?>" alt=""/></a>
            </div>
            <div class="tab-box tabs-container">
                <div class="tab_content">
                    <ul class="news-list">
                        <?php if($maxitems == 0): ?>
                            <li><?php _e( 'No items', 'my-text-domain' ); ?></li>
                        <?php else: ?>
                            <?php foreach($feed_items as $item): ?>
                                <li>
                                    <div class="image">
                                        <a href="<?php echo $item->permalink ?>" target="_blank">
                                            <img width="52" height="50" src="<?php echo $item->image_url ?>" class="attachment-tabs-img wp-post-image" alt="<?php echo $item->image_alt ?>"></a>
                                    </div>
                                    <div class="post-holder">
                                        <a href="<?php echo $item->permalink ?>" target="_blank"><?php echo $item->title; ?></a>
                                        <div class="meta">
                                            <?php echo $item->date ?>
                                        </div>
                                    </div>
                                </li>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </ul>

                </div>
            </div>
        </div>
    </div>

</div>