<?php
/**
 * Portfolio Section
 */

$wpparallax_port_args = array('post_type' => 'post', 'cat' => $cat_id, 'order' => 'DESC', 'posts_per_page' => -1);
$wpparallax_port_query = new WP_Query($wpparallax_port_args);

$wpparallax_fil_categories = get_categories(array('type' => 'post', 'parent' => $cat_id, 'hide_empty' => false));
?>
<div class="portfolio">
<?php

    $query = new WP_Query( 'page_id='.$page_id );
    while ( $query->have_posts() ) : $query->the_post(); 
      $section_title = get_the_title();
          if($show_title == 'on'){
          wp_parallax_section_title($section_title);
          }
    endwhile;
    wp_reset_postdata();

 if ($wpparallax_port_query->have_posts() && $cat_id) : ?> 
<!-- Portfolio Filter -->
<div class="portfolio-post-filter clearfix">
    <div class="titles-port fadeInLeft">
        <div class="filter active" data-filter="*"><?php echo esc_html__('All', 'wpparallax'); ?></div>
        <?php foreach ($wpparallax_fil_categories as $wpparallax_fil_cat) : ?>
            <div class="filter" data-filter=".category-<?php echo esc_attr($wpparallax_fil_cat->term_id); ?>"><?php echo esc_attr($wpparallax_fil_cat->name); ?></div>
        <?php endforeach; ?>
    </div>
</div>


    <div class="portfolio-postse wow fadeInUp clearfix">
        <?php $wpparallax_count = 1; ?>
        <?php while ($wpparallax_port_query->have_posts()) : $wpparallax_port_query->the_post(); ?>
            <?php
                $wpparallax_cats = get_the_category();
                $wpparallax_cat_list = '';
                foreach ($wpparallax_cats as $wpparallax_cat) :
                    if ($wpparallax_cat->term_id != $cat_id) {
                        $wpparallax_cat_list .= 'category-' . $wpparallax_cat->term_id . ' ';
                    }
                endforeach;

                $wpparallax_image_size = 'wpparallax-port-thumb2';
                if($wpparallax_count == 1){
                    $wpparallax_hport_img_class = 'hm-port-bg-thumb';
                    
                } else {
                    $wpparallax_hport_img_class = 'hm-port-sm-thumb';
                    
                }
                $wpparallax_img = wp_get_attachment_image_src(get_post_thumbnail_id(), $wpparallax_image_size);
                $wpparallax_img_src = $wpparallax_img[0];
            ?>
            <div class="portfolio-post-wrape <?php echo esc_attr($wpparallax_cat_list); ?> <?php echo esc_attr($wpparallax_hport_img_class); ?>">
                <div class="overflow">
                    <a href="<?php the_permalink(); ?>">
                        <figure>
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php echo esc_url($wpparallax_img_src); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/no-portfolio-thumbnail.png" title="no-image" alt="no-image" />
                            <?php endif; ?>

                            <div class="hm-port-excerpt">
                                <h4 class="hm-port-title" ><?php the_title(); ?></h4>
                                <p><?php echo esc_attr(wp_trim_words(get_the_content(),15)); ?></p>
                            </div>
                        </figure>
                    </a>
                </div>
            </div>
            
            <?php $wpparallax_count++; ?>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
</div>