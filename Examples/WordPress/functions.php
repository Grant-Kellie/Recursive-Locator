/* ----- Environment ----- */
/**
 * @param $mode
 * Sets the environment conditions
 */
$_ENV['mode'] = 'dev';


/* ----- Classes -----  */
/**
 * photonyx_styles
 * Enqueue style.css, loading the theme core.
 * @return void
 */
// CascadeRecursiveFileLocator : Requires / Autoloads files
require 'classes/CascadeRecursiveFileLocator.php';
