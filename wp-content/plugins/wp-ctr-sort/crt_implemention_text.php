<?php

/*
  Text holder for CTR
 */

class CTR_implemention_text {

    function en_impl_text() {
        $text = '
            <div class="card">
                <h2>Required</h2>
                
                <ol>
                    <li><a href="http://www.ioncube.com/" target="_blank">ionCube loader</a></li>
                </ol>

                <h2>Installation</h2>
                
                <ol>
                    <li>Get WP CTR Sort</li>
                    <li>Go to Plugins</li>
                    <li>Activate Wordpress CTR Sort</li>
                    
                    <li>Go to file of your home page.<br/> 
                        Usually path of file => /path to folder where Wordpress is installed/wp-content/themes/name of theme/name of index page of theme.php<br/>
                        Example of path: .../wp-content/themes/arcade-polse/content-games-index.php</li>
                    <li>
                        <ol>
                            <li>
                                
                                <div class="example">
                                    <h2 class="example">New line of code</h2>
                                    <div class="example_code notranslate">
                                        $loop = GetPostsCTRIndex();
                                    </div>
                                    <br>
                                </div>
                        
                                <div class="example">
                                    <h2 class="example">Where to insert</h2>
                                    <div class="example_code notranslate">
                                        <h4>WITH NO DEFINED VARIABLE</h4>
                                            ...<br/>
                                                // Comment default loop <br/>
                                                // while ( have_posts() ) : the_post(); // DEFAULT LOOP<br/>
                                                // Set new code<br/>
                                                <br/>
                                                <strong>$loop = GetPostsCTRIndex();//<=== NEW CODE LINE<br/>
                                                while ($loop->have_posts()) : $loop->the_post(); //<=== NEW CODE LINE</strong><br/>
                                                <br/>
                                                    /*<br/>
                                                     * Include the Post-Format-specific template for the content.<br/>
                                                     * If you want to override this in a child theme, then include a file<br/>
                                                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.<br/>
                                                     */<br/>
                                                    get_template_part( "content"", get_post_format() );<br/>
                                                <br/>
                                                // End the loop.<br/>
                                                endwhile;<br/>
                                            ...<br/>
                                            <br/>
                                            <br/>
                                        <h4>WITH DEFINED VARIABLE</h4>
                                        If in thema is defined variable for collecting data for posts,<br/>
                                        than is needed to add new code after declaring variables.<br/>
                                        <br/>EXAMPLE:<br/><br/>
                                        // Checking if is index (home) page<br/>
                                        if (is_home()) {<br/>
                                            // Getting data to variable called $loop (name of variable can be different)<br/>
                                            $loop = clone $wp_query;<br/>
                                            // Inserting new line that will collect all data sorted by CTR roles<br/>
                                            <strong>$loop = GetPostsCTRIndex();//<=== NEW CODE LINE</strong><br/>
                                    </div>
                                    <br/><strong></strong>
                                </div>
    
                            </li>
                        </ol>
                    </li>
                    
                    <li>Go to file of your category and tag page.<br/> 
                        Usually path of file => /path to folder where Wordpress is installed/wp-content/themes/name of theme/name of category and tag page of theme.php (this file is usually call archive.php)<br/>
                        Example of path: .../wp-content/themes/arcade-polse/archive.php</li>
                    <li>
                        <ol>
                            <li>
                                
                                <div class="example">
                                    <h2 class="example">New line of code</h2>
                                        <div class="example_code notranslate">
                                            $categories = GetPostsCTRCategory();
                                        </div>
                                        <br>
                                </div>
                                

                                <div class="example">
                                    <h2 class="example">Where to insert</h2>
                                        <div class="example_code notranslate">
                                        <h4>WITH NO DEFINED VARIABLE</h4>
                                            ...<br/>
                                                // Comment default loop <br/>
                                                // while ( have_posts() ) : the_post(); // DEFAULT LOOP<br/>
                                                // Set new code<br/>
                                                <br/>
                                                <strong>$categories = GetPostsCTRCategory();//<=== NEW CODE LINE<br/>
                                                while ($categories->have_posts()) : $categories->the_post(); //<=== NEW CODE LINE</strong><br/>
                                                <br/>
                                                    /*<br/>
                                                     * Include the Post-Format-specific template for the content.<br/>
                                                     * If you want to override this in a child theme, then include a file<br/>
                                                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.<br/>
                                                     */<br/>
                                                    get_template_part( "content"", get_post_format() );<br/>
                                                <br/>
                                                // End the loop.<br/>
                                                endwhile;<br/>
                                            ...<br/>
                                            <br/>
                                            <br/>
                                        <h4>WITH DEFINED VARIABLE</h4>
                                        If in thema is defined variable for collecting data for posts,<br/>
                                        than is needed to add new code after declaring variables.<br/>
                                        <br/>EXAMPLE:<br/><br/>
                                        // Checking if is category page<br/>
                                        if (is_category()) {<br/>
                                            // Getting data to variable called $categories (name of variable can be different)<br/>
                                            $categories = clone $wp_query;<br/>
                                            // Inserting new line that will collect all data sorted by CTR roles<br/>
                                            <strong>$categories = GetPostsCTRCategory();//<=== NEW CODE LINE</strong><br/>
                                    </div>
                                        <br/><strong></strong>
                                </div>

                            </li>
                        </ol>
                    </li>


                    <li>Now refresh you home page, click to some post.</li>
                    <li>Go to WP CTR Sort => Statistic</li>
                    <li>If in table is a row with data of clicked post. You are finished.</li>
                    
                    <li>Else you need to do one more thing.</li>
                    <li>You need to connect your posts with WP CTR Sort.</li>
                    
                    <li>You need to check witch class name you have on your post.</li>
                        <ol>
                            <li>Go to home page of your site and inspect the post class names</li>
                            <li>

                                <div class="example">
                                    <h2 class="example">Example</h2>
                                    <div class="example_code notranslate">
                                        
                                            &lt;div class="small-thumb post-961 post type-post status-publish format-standard 
                                            has-post-thumbnail hentry category-other tag-dolls tag-dress-up tag-dresses tag-steampunk game"
                                            data-id="961"&gt;<br/>
                                                &lt;a href="" class="link-over2"&gt;&lt;span&gt;&lt;/span&gt;&lt;/a&gt;<br/>
                                                ...
                                            &lt;/div&gt;
                                        
                                    </div>
                                    <br><strong>You can see in attribute class witch name post div have.</strong>
                                </div>

                            </li>
                            <li>Choose one that is displayeng in every post.</li>
                            <li>Go to WP CTR Sort / Manage</li>
                            <li>In field "Name of class that trigger click event" set choosen class name</li>
                                
                                <div class="example">
                                    <h2 class="example">Example</h2>
                                    <div class="example_code notranslate">
                                        
                                            We have class names "small-thumb post-961 post type-post ... tag-dresses tag-steampunk game", <br/>
                                            asome that we take class name "game", <br/>
                                            because we want to collect CTR  for all posts that have that class name,<br/>
                                            go to field "Name of class that trigger click event" and set value to be "game".
                                        
                                    </div>
                                    <br>
                                </div>
                        </ol>
                    </li>
                    
                    <li>Now refresh you home page, click to some post.</li>
                    <li>Go to WP CTR Sort => Statistic</li>
                    <li>If in table is a row with data of clicked post. You are finished.</li>
                    <li>If you have some problem, contact our <a href="http://forum.arcadepulse.com" target="_blank">support team</a>.</li>
                </ol>

            </div>
                ';

        return $text;
    }

    function it_impl_text() {
        $text = 'Italiano';

        return $text;
    }

}
