<?php
/**
 * Blog Section
 * 
 * @package Rara_eCommerce
 */

$ed_blog_section = get_theme_mod( 'ed_blog_section', false );
$sec_title       = get_theme_mod( 'blog_section_title', __( 'Latest Articles', 'rara-ecommerce' ) );
$sub_title       = get_theme_mod( 'blog_section_subtitle', __( 'Our recent articles about fashion ideas products.', 'rara-ecommerce' ) );
$blog            = get_option( 'page_for_posts' );
$label           = get_theme_mod( 'blog_view_all', __( 'See More Posts', 'rara-ecommerce' ) );
$image_size      = 'rara-ecommerce-blog-list';

$args = array(
    'post_type'           => 'post',
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => true
);

$qry = new WP_Query( $args );

if( $ed_blog_section && ( $sec_title || $sub_title || $qry->have_posts() ) ){ ?>

<section id="blog_section" class="blog-section">
    <div class="container-sm">        
        <?php if( $sec_title || $sub_title ){ ?>
            <div class="title-wrap">    
                <?php 
                    if( $sec_title ) echo '<h2 class="section-title">' . esc_html( $sec_title ) . '</h2>';
                    if( $sub_title ) echo '<div class="section-desc">' . esc_html( $sub_title ) . '</div>'; 
                ?>
            </div>
        <?php } ?>
        
        <?php if( $qry->have_posts() ){ ?>
            <div class="section-grid">
                <?php 
                while( $qry->have_posts() ){
                    $qry->the_post(); ?>
                    <article class="post">
                        <figure class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                            <?php 
                                if( has_post_thumbnail() ){
                                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                                }else{ 
                                    rara_ecommerce_get_fallback_svg( $image_size );//fallback
                                }                            
                            ?>                        
                            </a>
                        </figure>
                        <header class="entry-header">
                            <div class="entry-meta">
                                <?php rara_ecommerce_posted_on(); ?>
                            </div>
                            <div class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                            <div class="entry-meta">
                                <?php rara_ecommerce_posted_by(); ?>
                            </div>
                        </header>
                    </article>          
                    <?php 
                }
                wp_reset_postdata();
                ?>
            </div>
            
            <?php if( $blog && $label ){ ?>
                <div class="button-wrap">
                    <a href="<?php the_permalink( $blog ); ?>" class="bttn"><?php echo esc_html( $label ); ?></a>
                </div>
            <?php } ?>
        
        <?php } ?>
    </div>
</section>
<?php 
}