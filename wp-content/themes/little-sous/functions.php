<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/timber.php', 			// Twig magic
  'lib/ajax-functions.php',
  'lib/class-dfp.php',
  'lib/class-LittleSousUser.php',
  'lib/class-LittleSousPost.php',
  'lib/class-LittleSousTerm.php',
  'lib/assets.php',    	// Scripts and stylesheets
  'lib/extras.php',    	// Custom functions
  'lib/setup.php',     	// Theme setup
  'lib/titles.php',    	// Page titles
  'lib/customizer.php', // Theme customizer,
  'lib/widgets.php'
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

function me_pretty_dump($data) {
  echo '<pre>' . var_export($data, true) . '</pre>';
}