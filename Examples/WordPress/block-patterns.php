/**
 * @method CascadeIterator
 * Auto Searches for files and directories within a given directory
 * @return Json encoded
 * 
 * @author Grant Kellie <contact@cascade.media>
 * @copyright June 26 2022 Cascade Media
 * @license Proprietary
 * You may not copy, distribute, modify or use this code.
 */
function photonyx_locate_block_patterns(){
	$paths = [
		get_theme_file_path('/blocks/patterns'), // 
	];
	$files = new Theme\Photonyx\CascadeRecursiveFileLocator();
	$data = $files->compileFiles($paths, ['html', 'css', 'js', 'php', 'json']); // Locate all Files under $path
	$decoded_data = $data;
	
	// json_decode($data);

	$block_patterns = [];
	foreach ($decoded_data as $data) {
		array_push($block_patterns,$data['filename']);     
	}

	return $block_patterns;
}
