<?php

/*
  Text holder for CTR
 */
include_once 'crt_implemention_text.php';

class CTR_text {

    function lang(){
        return array(
            'en' => 'English'
        );
    }
    
    function en() {
        return array(
            // Deffine where is stored text for implemention page
            'implementation_text' => CTR_implemention_text::en_impl_text(),
            
            'submit' => 'Save',
            'btn_index' => 'Rebuild index',
            'btn_category' => 'Rebuild category',
            'btn_tag' => 'Rebuild tag',
            'btn_apply' => 'Applay',
            'btn_search' => 'Search',
            
			'btn_index_reset_status' => 'Reset index statistics', 			
	        'btn_category_reset_status' => 'Reset category statistics', 			
	        'btn_tag_reset_status' => 'Reset tag statistics', 
            
            
            'suppotr questions' => 'For all support questions please visit our forum: <a href="http://forum.arcadepulse.com" target="_blank">http://forum.arcadepulse.com</a> - <a href="http://forum.arcadepulse.com/forum/wordpress-ctr-sort/wordpress-ctr-sort-change-log/">Changelog</a> <br>Join us today on facebook <a href="https://www.facebook.com/groups/ArcadeWebmastersBiz/" target="_blank">Arcade Webmasters group</a> to meet more fellow webmasters!',
            'buy paid version' => '<p>If you want to remove 2% clicks skimming you need to buy paid version.</p>
                                    <p>Paid version costs $50 per domain.</p> 
                                    <p>To buy paid version send $50 to PayPal info@arcadepulse.com and write note with domain name  and your email so I can send you instructions how to activate it.</p>
                                    <p>Thank you for supporting us!</p>',
            'btn buy paid version' => 'Buy Paid Version',
            
            'lang' => 'Language',
            'licence_posts' => 'Licence for plugin',
            'clicks_total_0' => '',
            'clicks_total_1' => '',
            'clicks_total_2' => '',
            'clicks0' => '',
            'clicks1' => '',
            'clicks2' => '',
            'categoryclicks' => 'Category clicks',
            'tagclicks' => 'Tag clicks',
            'indexclicks' => 'Index clicks',
            'indexmain' => 'Use CTR on index page',
            'categorymain' => 'Use CTR on category page',
            'tagsmain' => 'Use CTR on tag',
            'afterposts' => 'Number of CTR posts before new posts',
            'countposts' => 'Number of new posts',
            'indexposts' => 'How many posts to display on index (home) page',
            'categoryposts' => 'How many posts to display on category page',
            'tagposts' => 'How many posts to display on tags page',
            'ctr_admin_table_posts_per_page' => 'How many posts to display in Statistics (admin) per page',
            'post_template_class' => 'Name of class that triggers click event (Recommended: Default value)',
            
            
            'icon_manage' => '<i class="wp-menu-image dashicons-before dashicons-info"></i>',
            
            'icon_lang' => 'Choose language you wanna use.',
            'icon_licence_posts' => 'You need licence if you want to enjoy plugin without skimming.',
            'icon_clicks_total_0' => '',
            'icon_clicks_total_1' => '',
            'icon_clicks_total_2' => '',
            'icon_clicks0' => '',
            'icon_clicks1' => '',
            'icon_clicks2' => '',
            'icon_categoryclicks' => 'Number of after how many clicks category pages will be rebuilt',
            'icon_tagclicks' => 'Number of after how many clicks tag pages will be rebuilt',
            'icon_indexclicks' => 'Number of after how many clicks index will be rebuilt',
            'icon_indexmain' => 'Use CTR sort on index/home page?',
            'icon_categorymain' => 'Use CTR sort on category page?',
            'icon_tagsmain' => 'Use CTR sort on tag pages?',
            'icon_afterposts' => 'Number of CTR posts before new posts.',
            'icon_countposts' => 'Number of new posts.',
            'icon_indexposts' => 'How many posts to display on index(home) page.',
            'icon_categoryposts' => 'This value is used for calculating CTR value for category CTR.',
            'icon_tagposts' => 'This value is used for calculating CTR value for index CTR.',
            'icon_ctr_admin_table_posts_per_page' => 'How many posts to display in Statistics(admin) per page',
            'icon_post_template_class' => 'Name of class that triggers click event(Recommended: Default value)',
            
            /*
            'icon_lang' => '<i title="Some title..."class="wp-menu-image dashicons-before dashicons-translation"></i>',
            'icon_licence_posts' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-admin-network"></i>',
            'icon_clicks_total_0' => '',
            'icon_clicks_total_1' => '',
            'icon_clicks_total_2' => '',
            'icon_clicks0' => '',
            'icon_clicks1' => '',
            'icon_clicks2' => '',
            'icon_categoryclicks' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-post-status"></i>',
            'icon_tagclicks' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-post-status"></i>',
            'icon_indexclicks' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-post-status"></i>',
            'icon_indexmain' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-pressthis"></i>',
            'icon_categorymain' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-pressthis"></i>',
            'icon_tagsmain' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-pressthis"></i>',
            'icon_afterposts' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-visibility"></i>',
            'icon_countposts' => '<i title="Some title..."class="wp-menu-image dashicons-before dashicons-visibility"></i>',
            'icon_indexposts' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-visibility"></i>',
            'icon_categoryposts' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-clipboard"></i>',
            'icon_tagposts' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-clipboard"></i>',
            'icon_ctr_admin_table_posts_per_page' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-clipboard"></i>',
            'icon_post_template_class' => '<i title="Some title..." class="wp-menu-image dashicons-before dashicons-editor-kitchensink"></i>',
            */
            
            
            'image' => 'Image',
            'post_title' => 'Title',
            'clk_index' => '<span class="tooltip" title="Click - Index">Click - I</span>',
            'clk_category' => '<span class="tooltip"  title="Clicks - Category">Click - C</span>',
            'clk_tag' => '<span class="tooltip"  title="Click - Tag">Click - T</span>',
            
			'displayed_ind' => '<span class="tooltip" title="Display - Index">D - I</span>', 	
		
			'displayed_cat' => '<span class="tooltip" title="Display - Category">D - C</span>', 			
			'displayed_tag' => '<span class="tooltip" title="Display - Tag">D - T</span>',
			
            'ctr_index_data' => '<span class="tooltip"  title="CTR - Index">CTR - I</span>',
            'ctr_cat_value' => '<span class="tooltip"  title="CTR - Category">CTR - C</span>',
            'ctr_tag_value' => '<span class="tooltip"  title="CTR - Tag">CTR - T</span>',
            
            'total_execution_time' => '<b>Total Execution Time:</b> ::time:: sec',
            'loader_reindex_title' => 'Waiting to finish rebuild',
            'search_placeholder' => 'Keywords separated with comma',
            
            'not_lic_text' => 'You are loosing 2% of clicks, purchase paid version.',
            'not_lic_model_text' => '<p>If you want to save all clicks to you.</p>
                                    <p>Paid version costs $25 per domain.</p> 
                                    <p>To buy paid version send $25 to PayPal info@arcadepulse.com and write note with domain name and your email so I can send you instructions how to activate it.</p>
                                    <p>Thank you for supporting us!</p>',
            // titles
            'Wordpress CTR Sort Settings' => 'Wordpress CTR Sort Settings',
            'CTR Options' => 'CTR Options',
            'Wordpress CTR Sort Statistics' => 'Wordpress CTR Sort Statistics',
            'Manual Rebuild' => 'Manual Rebuild',
            'Manual reset status' => 'Reset statistics',
            'Wordpress CTR Sort Implementation' => 'Wordpress CTR Sort Implementation',
                        
            'Rows in table' => 'Rows in table',
            'number_of_clicks_to_reindex' => '<p>Number of clicks on index page <strong>::no_of_clk::</strong> of <strong>::no_of_define_clk::</strong>. To rebuild index page left <strong>::no_of_left_clk::</strong> clicks.</p>',
            
            'index_reindex_msg_true' => 'Index rebuild done.',
            'index_reindex_msg_false' => 'Index rebuild not done.',
            'category_reindex_msg_true' => 'Category rebuild done.',
            'category_reindex_msg_false' => 'Category rebuild not done.',
            'tag_reindex_msg_true' => 'Tag rebuild done.',
            'tag_reindex_msg_false' => 'Tag rebuild not done.',
            
			'index_reset_reindex_msg_true' => 'Index clicks and displays are reset.', 	
		
	        'index_reset_reindex_msg_false' => 'Index clicks and displays are not reset.', 			
	        'category_reset_reindex_msg_true' => 'Category clicks and displays are reset.', 			
	        'category_reset_reindex_msg_false' => 'Category clicks and displays are not reset.', 			
	        'tag_reset_reindex_msg_true' => 'Tag clicks and displays are reset.', 			
	        'tag_reset_reindex_msg_false' => 'Tag clicks and displays are not reset.', 
            
            'No result' => 'No result.',
            
            'confir_reset_index' => 'Are you want to reset index statistic?',
            'confir_reset_category' => 'Are you want to reset category statistic?',
            'confir_reset_tag' => 'Are you want to reset tag statistic?',
            'confir_rebuild_index' => 'Are you want to rebuild index data?',
            'confir_rebuild_category' => 'Are you want to rebuild category data?',
            'confir_rebuild_tag' => 'Are you want to rebuild tag data?',
            
            'update_notice' => 'New WP CTR Sort update is now available. Update now to version %s . <a href="%s">Click here!</a>.',
        );
    }
}
