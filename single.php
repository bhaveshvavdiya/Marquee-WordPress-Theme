<?php get_header(); ?>
	<!-- Extra code -->
	<?php the_title();?>

	<?php if(has_post_thumbnail()):?>
		<img src="<?php the_post_thumbnail_url('largest');?>" class="img-fluid">
	<?php endif;?>
	
	<?php if (have_posts()) : while(have_posts()) : the_post();?>
		<?php the_content();?>
	<?php endwhile; endif;?>

<?php get_footer(); ?>