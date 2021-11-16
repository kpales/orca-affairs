<?php
function theme_enqueue_styles() {
    wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style('custom_css_code', get_stylesheet_directory_uri() . '/assets/css/style.css',array());
    wp_enqueue_style('bootstrap_cdn', "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css");
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

 function custom_mcb_events() {
    ob_start();?>
<?php
global $post;
?>

    <?php
    $events = array(
        'post_type' => 'tribe_events',
        'posts_per_page' => 3
    );
    $events_loop = new WP_Query($events);
    ?>
    <div class="container-fluid">
        <div class="row">

    <?php while ($events_loop->have_posts()) : $events_loop->the_post(); ?>
        <?php $tribeDate = tribe_get_start_date(null,true,'d.m.Y',null);?>
        <?php $tribeHour = tribe_get_start_date(null,true,'H:m',null); ?>
        <div class="col-12 col-lg-4" style="margin:10px 0; padding:0;">
            <div class="card events-card">
                <img class="card-img-top" src="<?php echo get_the_post_thumbnail_url(get_the_ID());?>" alt="Card image cap">
                <div class="card-body">
                   <div class="card-date">
                       <span class="card-date"><?php echo $tribeDate?></span><span class="mx-3"> | </span> <span class="card-hour"><?php echo $tribeHour?></span><span class="mx-1">Uhr</span>
                   </div>
                    <span class="card-title"><?php echo get_the_title();?></span>
                    <span class="card-excerpt"><?php echo wp_trim_words(get_the_content(),35); ?></span>
                    <a class="card-link" href="<?php the_permalink($events_loop->ID); ?>">
                        Zum Event  <i class="fas fa-long-arrow-alt-right"></i></a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
        </div>
    </div>
<?php
return ob_get_clean();
}
add_shortcode( 'custom_mcb_events', 'custom_mcb_events' );

// Custom news shortocde - Aleš
function custom_boxes() {
    ob_start();?>
    <?php
    global $post;
    $args_first_boxes = array(
        'post_type' => 'post',
        'posts_per_page' => 7,
        'orderby' => 'date',
        'order' => 'desc',
        'category_name' => 'kategorie1'
    );
    $custom_boxes_post = new WP_Query($args_first_boxes);
    ?>
    <?php while ($custom_boxes_post->have_posts()) : $custom_boxes_post->the_post(); ?>

        <div class="col-12 col-lg-3 px-0">
            <a href="<?php the_permalink($custom_boxes_post->ID);?>">
            <div class="card news-card">
                <img class="card-img-top" src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="Card image cap">
                <div class="card-body">
                    <!--<span class="card-date"><?php /*echo get_the_date();*/?></span>-->
                    <span class="card-title"><?php echo get_the_title();?></span>
                    <!--<a class="card-link" href="<?php /*the_permalink($custom_boxes_post->ID); */?>">
                        Mehr erfahren <i class="fas fa-long-arrow-alt-right"></i></a>-->
                </div>
            </div>
            </a>
        </div>

    <?php endwhile;?>
    <?php wp_reset_postdata(); ?>
        <?php
        $background = get_field('background');
        $text = get_field('text');
        $link = get_field('link');
    ?>
    <div class="col-12 col-lg-3 px-0">
        <a href="<?php echo $link;?>">
        <div class="card news-card">
            <img class="card-img-top" src="<?php echo $background; ?>" alt="Card image cap">
            <div class="card-body">
               <!-- <span class="card-date">1.11.2021</span>-->
                <span class="card-title"><?php echo $text?></span>
               <!-- <a class="card-link" href="<?php /*echo $link; */?>">
                    Mehr erfahren <i class="fas fa-long-arrow-alt-right"></i></a>-->
            </div>
        </div>
        </a>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode( 'custom_boxes', 'custom_boxes' );
