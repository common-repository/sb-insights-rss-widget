<?php

class InsightsSamsungFeedWidget extends WP_Widget{

    function InsightsSamsungFeedWidget(){
        parent::__construct( false, 'Insights Samsung Feed' , array('description'=>'Insight Samsung RSS Feed'));
    }

    function widget( $args, $instance ) {

        $feed_url = $instance['feed_select'];

        $feed = fetch_feed($feed_url);
        $feed->set_cache_duration(apply_filters('wp_feed_cache_transient_lifetime',$instance['feed_cache_input']*HOUR_IN_SECONDS),$feed_url);

        if(!is_wp_error($feed)){


            //retrieve only 3 items
            $maxitems = $feed->get_item_quantity(3);

            $rss_items = $feed->get_items(0,$maxitems);

            if($instance['feed_date_sort_select'] == 'asc'){
                $rss_items = array_reverse($rss_items);
            }

            $feed_items = array();

            if($maxitems > 0){
                foreach($rss_items as $item){
                    //fetch the description
                    $description = $item->get_description();
                    //check if there's an image in the description raw html
                    if(preg_match('/src="(.*?)"/s',$description,$matches)){
                        //get the image name from the img source attribute
                        $image_name = pathinfo($matches[1], PATHINFO_BASENAME);
                        //get the image url
                        $image_url = pathinfo($matches[1], PATHINFO_DIRNAME).'/';
                        //check if there's an instance of a dash and a numeric field at the end of the filename i.e -1240x720.jpg
                        if(preg_match('/-(\d+x\d+)\./s',$image_name,$matches)){
                            //if found replace with thumbnail size
                            $image_url .= preg_replace('/-(\d+x\d+)\./s', '-52x50.',$image_name);
                        }else{
                            //if not append the thumbnail size string
                            $image_name_array = explode('.',$image_name);
                            $ext_pos = count($image_name_array)-1;
                            $ext = '.'.$image_name_array[$ext_pos];

                            $image_url .= str_replace($ext,'-52x50'.$ext,$image_name);
                        }
                    }

                    //check if image alt comes in the raw html
                    if(preg_match('/alt="(.*?)"/s',$description,$matches)){
                        $image_alt = $matches[1];
                    }


                    $feed_data = (object) array(
                        'permalink' => $item->get_permalink(),
                        'title'     => $item->get_title(),
                        'date'      => date('F jS, Y',strtotime($item->get_date())),
                        'image_url' => $image_url,
                        'image_alt' => $image_alt
                    );
                    array_push($feed_items,$feed_data);
                }
            }

        }

        $category_url = str_replace('feed/','',$instance['feed_select']);

        wp_enqueue_style('insights-samsung-feed',plugins_url('assets/styles/insights-samsung-feed.css',__FILE__));
        wp_enqueue_style('insights-samsung-feed-font','https://fonts.googleapis.com/css?family=PT+Sans');
        include dirname( __FILE__ ) . '/views/insights-samsung-feed.widget.view.php';
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['feed_select'] = strip_tags($new_instance['feed_select']);
        $instance['feed_date_sort_select'] = strip_tags($new_instance['feed_date_sort_select']);

        if(is_numeric($new_instance['feed_cache_input'])){
            $instance['feed_cache_input'] = strip_tags($new_instance['feed_cache_input']);
        }else{
            $instance['feed_cache_input'] = strip_tags($old_instance['feed_cache_input']);
        }

        return $instance;

    }

    function form( $instance ) {
        $options = array(
            array(
                'category'  => 'Display',
                'url'       => 'http://insights.samsung.com/category/solutions/digital-signage/feed/'
            ),
            array(
                'category'  => 'Mobility',
                'url'       => 'http://insights.samsung.com/category/solutions/mobility/feed/'
            ),
            array(
                'category'  => 'Storage',
                'url'       => 'http://insights.samsung.com/category/solutions/storage/feed/'
            )
        );
        if(empty($instance)){
            $instance = array(
                'feed_select'           => '',
                'feed_date_sort_select' =>'desc',
                'feed_cache_input'      =>1
            );
        }

        include dirname( __FILE__ ) . '/views/insights-samsung-feed.widget.form.php';
    }



}

function InsightsSamsungFeedWidget_register_widgets() {
    register_widget( 'InsightsSamsungFeedWidget' );
}

add_action( 'widgets_init', 'InsightsSamsungFeedWidget_register_widgets' );