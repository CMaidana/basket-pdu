	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<h2 class="post-title entry-title"><?php the_title(); ?>
					<div class="yuzo_views_post yuzo_icon_views yuzo_icon_views__bottom" style="font-size:11px;float:right"><?php if ( function_exists( "get_Yuzo_Views" ) ) { echo (178 + get_Yuzo_Views()); } ?> visitas </div>		
</h2>
<div class="postmeta clearfix"><?php dynamicnews_display_postmeta(); ?></div>
<?php dynamicnews_display_thumbnail_single(); ?>

		<div class="entry clearfix">
			<?php the_content(); ?>
			<!-- <?php trackback_rdf(); ?> -->
			<div class="page-links"><?php wp_link_pages(); ?></div>			
		</div>
		
		<div class="postinfo clearfix"><?php dynamicnews_display_postinfo_single(); ?></div>

		

	</article>