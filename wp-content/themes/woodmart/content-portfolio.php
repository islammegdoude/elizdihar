<?php
/**
 * The default template for displaying content
 */

global $woodmart_portfolio_loop, $post;

$size  = woodmart_loop_prop( 'portfolio_image_size' );
$img   = woodmart_otf_get_image_html( get_post_thumbnail_id(), woodmart_loop_prop( 'portfolio_image_size' ), woodmart_loop_prop( 'portfolio_image_size_custom' ) );
$style = woodmart_loop_prop( 'portfolio_style' );

$classes[] = 'wd-project';
$classes[] = 'portfolio-entry';
$classes[] = 'wd-col';
$classes[] = 'masonry-item';
$classes[] = 'portfolio-' . $style;

$cats = wp_get_post_terms( get_the_ID(), 'project-cat' );

if ( ! empty( $cats ) ) {
	foreach ( $cats as $key => $cat ) {
		$classes[] = 'proj-cat-' . $cat->slug;
	}
}

$info_classes = '';

if ( 'text-shown' !== $style ) {
	$info_classes .= ' color-scheme-light';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
			<figure class="entry-thumbnail color-scheme-light">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="portfolio-thumbnail">
					<?php echo $img; ?>
				</a>
				<div class="wd-portfolio-btns">
					<div class="portfolio-enlarge wd-action-btn wd-style-icon wd-enlarge-icon wd-tltp wd-tltp-left">
						<a href="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ); ?>" data-elementor-open-lightbox="no"><?php esc_html_e( 'View Large', 'woodmart' ); ?></a>
					</div>
					<?php if ( woodmart_is_social_link_enable( 'share' ) ) : ?>
						<div class="social-icons-wrapper wd-action-btn wd-style-icon wd-share-icon wd-tltp <?php echo is_rtl() ? 'wd-tltp-right' : 'wd-tltp-left'; ?>">
							<a></a>
							<div class="wd-tooltip-label">
								<?php
								if ( function_exists( 'woodmart_shortcode_social' ) ) {
									echo woodmart_shortcode_social(
										array(
											'size'  => 'small',
											'style' => 'default',
											'color' => 'light',
										)
									);}
								?>
							</div>
						</div>
					<?php endif ?>
				</div>
			</figure>
		<?php endif; ?>

		<div class="portfolio-info<?php echo esc_attr( $info_classes ); ?>">
			<?php if ( ! empty( $cats ) ) : ?>
				<div class="wrap-meta">
					<ul class="proj-cats-list">
						<?php foreach ( $cats as $key => $cat ) : ?>
							<?php $classes[] = 'proj-cat-' . $cat->slug; ?>
							<li><?php echo esc_html( $cat->name ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<div class="wrap-title">
				<h3 class="wd-entities-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h3>
			</div>
		</div>
	</header>
</article>
