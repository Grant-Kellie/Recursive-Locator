<?php
/**
 * @author Grant Kellie <contact@cascade.media>
 * @copyright June 26 2022 Cascade Media
 * @license Proprietary
 * You may not copy, distribute, modify or use this code.
 */

/**
 * photonyx_autoload
 * @uses CascadeRecursiveFileLocator::compileFiles
 * uses CascadeRecursiveFileLocator::compileFiles to locate and create a list of CSS & JS.
 * 
 * @param array $paths
 * @return $dataset
 */
function photonyx_autoload(array $paths){    
	$cascadeRecursiveFileLocator = new Theme\Photonyx\CascadeRecursiveFileLocator();
	$dataset = $cascadeRecursiveFileLocator->compileFiles($paths, ['css', 'js']); // Locate all Files under given $paths
	return $dataset;
}


/**
 * photonyx_theme
 * Attempts to load required CSS & JS for theme.
 * @return
 */
function photonyx_theme(){
    $files = photonyx_autoload([
        dirname(__FILE__).('/scripts'), // default script directory, modify with caution.
    ]);

	// Load discovered files
    foreach ($files as $file){
		if($file['extension'] === 'css'){
			if($_ENV['mode'] === 'dev'){ // Clear cached				
				wp_enqueue_style("photonyx_".$file['file'], $file['file_path'], array(), time());
			} else { // Load from cached				
				wp_enqueue_style("photonyx_".$file['file'], $file['file_path']);
			}
		} else if($file['extension'] === 'js'){
			if($_ENV['mode'] === 'dev'){ // Clear cached				
				wp_enqueue_script("photonyx_".$file['file'], $file['file_path'], array(), time());
			} else { // Load from cached				
				wp_enqueue_script("photonyx_".$file['file'], $file['file_path']);
			}
		}
		
	}
}
add_action('wp_enqueue_scripts', 'photonyx_theme');
