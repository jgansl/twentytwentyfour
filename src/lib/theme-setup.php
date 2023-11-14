<?php

if (!defined('TEXTDOMAIN')) {
  // Replace the version number of the theme on each release.
  define('TEXTDOMAIN', 'incisive-dental'); //match style.css theme root directory
}
if (!defined('IS_LOCAL')) {
  define('IS_LOCAL', wp_get_environment_type() === 'local');
}

if (!defined('REMOTE_URI')) {
  define('REMOTE_URI', 'https://incden.wpengine.com');
}


add_filter('register_post_type_args', 'remove_default_post_type', 0, 2);
function remove_default_post_type($args, $postType)
{
  if ($postType === 'post') {
    // $args['public']                = false;
    // $args['show_ui']               = false;
    // $args['show_in_menu']          = false;
    // $args['show_in_admin_bar']     = false;
    // $args['show_in_nav_menus']     = false;
    // $args['can_export']            = false;
    $args['has_archive']           = false;
    // $args['exclude_from_search']   = true;
    $args['publicly_queryable']    = false;
    // $args['show_in_rest']          = false;
  }

  return $args;
}

// Clean up wordpres <head>
remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version

// remove_action('wp_head', 'generator', 2); // remove PFL generator?
//Remove All Meta Generators
ini_set('output_buffering', 'on'); // turns on output_buffering
function remove_meta_generators($html)
{
  $pattern = '/<meta name(.*)=(.*)"generator"(.*)>/i';
  $html = preg_replace($pattern, '', $html);
  return $html;
}
function clean_meta_generators($html)
{
  ob_start('remove_meta_generators');
}
add_action('get_header', 'clean_meta_generators', 100);
add_action('wp_footer', function () {
  ob_end_flush();
}, 100);

remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
remove_action('wp_head', 'index_rel_link'); // remove link to index page
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

remove_action('wp_head', 'rest_output_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10, 0);
remove_action('wp_head', 'rest_output_link_header', 10, 0);
add_filter('emoji_svg_url', '__return_false');

// remove emoji stuff
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

// auto update plugins / wordpress
add_filter('auto_update_core', '__return_true');
add_filter('auto_update_plugin', '__return_true');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// disable emails when plugins auto-update
add_filter('auto_plugin_update_send_email', '__return_false');

// remove wordpress logo from admin bar
function theme_admin_bar_remove_logo()
{
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'theme_admin_bar_remove_logo', 0);

// image directory shortcut
function gid()
{
  return get_stylesheet_directory_uri() . '/assets/images';
}

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
  /**
   * Enable plugins to manage the document title
   * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
   */
  add_theme_support('title-tag');
  /**
   * Enable post thumbnails
   * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
   */
  add_theme_support('post-thumbnails');
  /*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'script',
      'style',
    )
  );
  // Add support for full and wide align images.
  add_theme_support('align-wide');
  /**
   * Enable selective refresh for widgets in customizer
   * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
   */
  add_theme_support('responsive-embeds');
  add_theme_support('menus');
  add_theme_support('woocommerce');
  add_theme_support('align-wide');
  add_theme_support('custom-line-height');
  add_theme_support('editor-styles');
  add_editor_style('build/admin.css');
}, 20);

// image sizes
add_image_size('fp-xlarge', 1920);
// // Register the new image size for use in the add media modal in wp-admin
function theme_custom_sizes($sizes)
{
  return array_merge(
    $sizes,
    array(
      'medium_large' => __('Medium Large'),
    )
  );
}
add_filter('image_size_names_choose', 'theme_custom_sizes');

/**
 * Increases the threshold for scaling big images to 4000.
 * In this case all the images that are above 4000px (width or height) 
 * will be downscaled to 2000px.
 *
 * @param $threshold
 * @return int
 */
function theme_big_image_size_threshold($threshold)
{
  return 2000; // new threshold
}
add_filter('big_image_size_threshold', 'theme_big_image_size_threshold', 100, 1);

// Remove comments page in menu
function theme_disable_comments_admin_menu()
{
  remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'theme_disable_comments_admin_menu');
// Close comments on the front-end
function theme_disable_comments_status()
{
  return false;
}
add_filter('comments_open', 'theme_disable_comments_status', 20, 2);
add_filter('pings_open', 'theme_disable_comments_status', 20, 2);


// Rest api stuff
add_action('rest_api_init', function () {
  $namespace = 'theme/v1';
  register_rest_route($namespace, '/path/(?P<url>.*?)', array(
    'methods'  => 'GET',
    'callback' => 'get_post_for_url',
    'permission_callback' => function (WP_REST_Request $request) {
      return current_user_can('manage_options');
    },
  ));
});

/**
 * This fixes the wordpress rest-api so we can just lookup pages by their full
 * path (not just their name). This allows us to use React Router.
 *
 * @return WP_Error|WP_REST_Response
 */
function get_post_for_url($data)
{
  $postId    = url_to_postid($data['url']);
  $postType  = get_post_type($postId);
  $controller = new WP_REST_Posts_Controller($postType);
  $request    = new WP_REST_Request('GET', "/wp/v2/{$postType}s/{$postId}");
  $request->set_url_params(array('id' => $postId));
  return $controller->get_item($request);
}


// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
  global $post;
  if (is_home()) {
    // $key = array_search('blog', $classes);
    // if ($key > -1) {
    // 	unset($classes[$key]);
    // }
  } elseif (is_page()) {
    $classes[] = sanitize_html_class($post->post_name);
  } elseif (is_singular()) {
    $classes[] = sanitize_html_class($post->post_name);
  }
  return $classes;
}
add_filter('body_class', 'add_slug_to_body_class');


// Custom Pagination
function theme_pagination($query = null)
{
  global $wp_query;
  if (!$query) {
    $query = $wp_query;
  }

  $big = 999999999; // This needs to be an unlikely integer

  // For more options and info view the docs for paginate_links()
  // http://codex.wordpress.org/Function_Reference/paginate_links
  $paginate_links = paginate_links(
    array(
      'base'      => str_replace($big, '%#%', html_entity_decode(get_pagenum_link($big))),
      'current'   => max(1, get_query_var('paged')),
      'total'     => $wp_query->max_num_pages,
      'mid_size'  => 2,
      'prev_next' => true,
      // 'prev_text' => __( '&laquo;', 'foundationpress' ),
      // 'next_text' => __( '&raquo;', 'foundationpress' ),
      'prev_text' => __('Previous', 'foundationpress'),
      'next_text' => __('Next', 'foundationpress'),
      'type'      => 'list',
    )
  );

  $total_pages = $wp_query->max_num_pages;

  $paginate_links = str_replace("<ul class='page-numbers'>", '<div class="pagination">', $paginate_links);
  $paginate_links = str_replace('</ul>', '</div>', $paginate_links);

  $paginate_links = str_replace('<li>', '', $paginate_links);
  $paginate_links = str_replace('</li>', '', $paginate_links);

  $paginate_links = str_replace("<span ", "<span data-total-pages='$total_pages'", $paginate_links);

  if (!strpos($paginate_links, 'prev')) {
    $paginate_links = str_replace('<div class="pagination">', '<div class="pagination"><span class="prev disabled">Previous</span>', $paginate_links);
  }
  if (!strpos($paginate_links, 'next')) {
    $paginate_links = str_replace('</div>', '<span class="next disabled">Next</span></div>', $paginate_links);
  }

  // Display the pagination if more than one page is found.
  if ($paginate_links) {
    echo $paginate_links;
  }
}


// disable gravity forms scroll position reset
add_filter('gform_confirmation_anchor', '__return_false');

// gform scripts in footer
add_filter('gform_init_scripts_footer', '__return_true');

// custom gravity forms spinner
add_filter('gform_ajax_spinner_url', function () {
  return gid() . '/spinner.svg';
}, 10, 2);


// post updated universal hook
function theme_post_updated($post_id)
{
  if ($post_id === 'options') {
    if (is_plugin_active('litespeed-cache/litespeed-cache.php')) {
      shell_exec('wp litespeed-purge all');
    }
  }
}
add_action('acf/save_post', 'theme_post_updated');

// global theme options
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
    'page_title'   => 'Theme General Options',
    'menu_title'  => 'Theme Options',
    'menu_slug'   => 'theme-general-settings',
    // 'capability'	=> 'edit_posts',
    // 'redirect'		=> false
  ));
}

//set theme locations for wp_nav_menu
function register_my_menus()
{
  register_nav_menus(
    array(
      // 'top-navigation' 	=> __( 'Top Navigation' ),
      'primary-navigation' => __('Primary Navigation'),
      // 'mobile-navigation' 	=> __( 'Mobile Navigation' ),
      'footer-navigation'   => __('Footer Navigation'),
      'legal-navigation'   => __('Legal Navigation'),
    )
  );
}
add_action('init', 'register_my_menus');

/*
format_phone( $input, $html = true )
  Converts any phone number to a 10-digit phone number.
  
    - If $html is true (default), the returned value will be an HTML-formatted phone number, including "tel:+" in the link.
    - Extensions are supported. An extension will be identified starting with one of the following: +, -, x, ex, ext, ext.
    - If a pattern match is not found, the original string will be returned without HTML formatting.
    
  Example:
    <?php var_dump(format_phone("My phone number is: 1 (555)293-1039 ext. 3999. Thank you.")); ?>

Output - With HTML [default] (white space added manually)
<span class="tel">
  <a href="tel:+15552931039" class="tel-link">555-293-1039</a>
  <span class="tel-ext"><span> x</span>3999</span>
</span>

Output - No HTML
555-293-1039 x3999
*/
function format_phone($string, $html = true)
{
  // Pattern to collect digits from a phone number, and optional extension
  // Extensions can be identified using: + - x ex ex. ext ext. extension extension.
  // Now (should) function with country codes!
  $pattern = '/\+?([0-9]{0,3})?[^0-9]*([0-9]{3,3})[^0-9]*([0-9]{3,3})[^0-9]*([0-9]{4,4})[^0-9]*([^0-9]*(-|e?xt?\.?)[^0-9]*([0-9]{1,}))?[^0-9]*$/i';

  if (preg_match($pattern, $string, $matches)) {
    // Input: "1 (541) 123-4567 x999"
    // 1 => 1
    // 2 => 541
    // 3 => 123
    // 4 => 4567
    // 7 => 999
    $result = array();
    if (isset($matches[7])) $ext = $matches[7];
    else $ext = '';
    $countrycode = $matches[1] ? $matches[1] : 1;
    // Output (HTML):
    // <span class="tel"><a href="tel+15411234567" class="tel-link">541-123-4567</a><span class="tel-ext"><span> x</span>999</span></span>
    // Output (Raw):
    // 541-123-4567 x999
    if ($html) $result[] = '<span class="tel">';
    if ($html) $result[] = sprintf('<a href="tel:+%s%s%s%s" class="tel-link">', $countrycode, $matches[2], $matches[3], $matches[4]);
    $result[] = sprintf('(%s) %s-%s', $matches[2], $matches[3], $matches[4]);
    if ($html) $result[] = sprintf('</a>');
    // Note: tel: links cannot *reliably* include an extension, so it comes after the link.
    if ($ext && $html) $result[] = sprintf('<span class="tel-ext"><span> x</span>%s</span>', $ext);
    else if ($ext) $result[] = sprintf(' x%s', $ext);
    if ($html) $result[] = '</span>';
    return implode($result);
  }

  // Pattern not found
  return esc_html($string); // The phone number isn't valid, but that's ok. Keep the original.
}

function encodeURIComponent($str)
{
  $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
  return strtr(rawurlencode($str), $revert);
}

function data_attribute($str)
{
  return htmlspecialchars(json_encode($str), ENT_QUOTES, 'UTF-8');
}

function theme_next_post_link($post_type = 'post', $use_svg = false)
{
  if ($next_post = get_adjacent_post(false, '', true)) {
    $content = $use_svg ? insert_svg('arrow-right', $echo = false) . '<span class="sr-only">next post</span>' : 'Next Post ››';
    echo '<a class="next-link" href="' . get_permalink($next_post) . '" data-wenk="' . get_the_title() . '">' . $content . '</a>';
  } else {
    $last = new WP_Query('posts_per_page=1&order=DESC&post_type=post');
    $last->the_post();
    $content = $use_svg ? insert_svg('arrow-right', $echo = false) . '<span class="sr-only">next post</span>' : 'Next Post ››';
    echo '<a class="next-link" href="' . get_permalink($next_post) . '" data-wenk="' . get_the_title() . '">' . $content . '</a>';
    wp_reset_query();
  };
}

function theme_previous_post_link($post_type = 'post', $use_svg = false)
{
  if ($prev_post = get_adjacent_post(false, '', false)) {
    $content = $use_svg ? insert_svg('arrow-left', $echo = false) . '<span class="sr-only">Previous Post</span>' : '‹‹ Previous Post';
    echo '<a class="prev-link" href="' . get_permalink($prev_post) . '" data-wenk="' . get_the_title() . '">' . $content . '</a>';
  } else {
    $first = new WP_Query('posts_per_page=1&order=ASC&post_type=post');
    $first->the_post();
    $content = $use_svg ? insert_svg('arrow-left', $echo = false) . '<span class="sr-only">Previous Post</span>' : '‹‹ Previous Post';
    echo '<a class="prev-link" href="' . get_permalink($prev_post) . '" data-wenk="' . get_the_title() . '">' . $content . '</a>';
    wp_reset_query();
  };
}

// get youtube video id
function get_youtube_id($youtube_url)
{
  preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtube_url, $match);
  return $match[1];
};

// get vimeo video id
function get_vimeo_id($vimeo_url)
{
  preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $vimeo_url, $match);
  return $match[5];
};

require_once get_template_directory() . "/src/lib/util/svg-includes.php";

require get_template_directory() . '/src/lib/theme-enqueue.php';

//CPT
require get_template_directory() . '/src/lib/theme-cpts.php';

// require get_stylesheet_directory() . '/lib/_s/functions.php';
require_once(get_stylesheet_directory() . '/patterns/_index.php');

$menus_arr = array(
  // 'top-navigation' 	=> __( 'Top Navigation' ),
  'primary-navigation' => __('Primary Navigation', TEXTDOMAIN),
  'legal-navigation' => __('Legal Navigation', TEXTDOMAIN),
  // 'mobile-navigation' 	=> __( 'Mobile Navigation', TEXTDOMAIN ),
  'footer-navigation'   => __('Footer Navigation', TEXTDOMAIN),
);

if (IS_LOCAL) {
  if (file_exists(get_template_directory() . '/src/lib/theme-develop.php')) {
    require get_template_directory() . '/src/lib/theme-develop.php';
  }

  if( defined('REMOTE_URI' ) ) {
    require_once get_template_directory() . "/src/lib/util/remote-media/remote-media.php";
    add_filter(
      'be_media_from_production_url',
      function() {
        return REMOTE_URI;
      }
    );
  }
}

// options
// add_action('template_redirect', 'get_option_fields');
// function get_option_fields() {
//    global $option_fields;
//    if(!defined('option_fields') && function_exists('get_field')) {
// 		$option_fields = get_fields('options');
//    } else {
// 		echo 'Please enable ACF';
// 		error_log('ACF not enabled');
// 	}
// }



/** ADDITIONAL FILE TYPE SUPPORT */
function webp_is_displayable($result, $path)
{
  if ($result === false) {
    $displayable_image_types = array(IMAGETYPE_WEBP);
    $info = @getimagesize($path);
    if (empty($info)) {
      $result = false;
    } elseif (!in_array($info[2], $displayable_image_types)) {
      $result = false;
    } else {
      $result = true;
    }
  }
  return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);

function cc_mime_types($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  $mimes['webp'] = 'image/webp';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
function fix_svg()
{
  echo '
  <style type="text/css">
    .attachment-266x266, .thumbnail img {
      width: 100% !important;
      height: auto !important;
    }
  </style>
  ';
}

//TODO
function social_share($soc_name)
{
  $share_options = [
    "facebook" => "https://www.facebook.com/sharer/sharer.php?u=" . get_the_permalink(),
    "twitter" => "https://twitter.com/intent/tweet?text=" . get_the_title() . "&url=" . get_the_permalink(),
    "linkedin" => "https://www.linkedin.com/cws/share?url=" . get_the_permalink(),
    "email" => "mailto:?subject=I wanted you to see this: " . get_the_title() . "&amp;body=" . get_the_permalink(),
  ];

  if (array_key_exists($soc_name, $share_options) && $link = $share_options[$soc_name]) {
    return $link;
  }

  return '#';
}

// // support for saving external urls open graph images as featured images on post save.
// define('EXTERNAL_IMAGE_ON_SAVE', false);
// define('EXTERNAL_IMAGE_ON_SAVE_POST_TYPES', array('press'));
// define('EXTERNAL_IMAGE_ON_SAVE_ACF_FIELD', 'article_link');
// // fallback image is used if the external url can't be reached or for some reason an open graph image can't be grabbed
// define('EXTERNAL_IMAGE_ON_SAVE_FALLBACK_IMG', 1696); //1696


// if (EXTERNAL_IMAGE_ON_SAVE) {

//   require_once(ABSPATH . 'wp-admin/includes/media.php');
//   require_once(ABSPATH . 'wp-admin/includes/file.php');
//   require_once(ABSPATH . 'wp-admin/includes/image.php');

//   function save_external_image_as_featured_image($post_id)
//   {

//     $fallback_img = false;
//     $image_url = '';

//     // exit the function if not in allowed post types		
//     if (!in_array(get_post_type($post_id), EXTERNAL_IMAGE_ON_SAVE_POST_TYPES)) {
//       return;
//     }

//     $external_url = get_field(EXTERNAL_IMAGE_ON_SAVE_ACF_FIELD, $post_id);

//     if (empty($external_url)) {
//       $fallback_image = true;
//     } else {

//       $response = wp_remote_get($external_url);

//       if (is_wp_error($response)) {
//         $fallback_img = true;
//       } else {

//         // Parse the HTML content
//         $html = wp_remote_retrieve_body($response);
//         $dom = new DOMDocument();

//         libxml_use_internal_errors(true); // Suppress HTML parsing errors
//         $dom->loadHTML($html);
//         libxml_clear_errors();
//         $meta_tags = $dom->getElementsByTagName('meta');

//         foreach ($meta_tags as $meta_tag) {
//           if ($meta_tag->getAttribute('property') == 'og:image') {
//             $image_url = $meta_tag->getAttribute('content');
//             break;
//           }
//         }
//       }
//     }

//     // if fallback image is true, save the fallback image as featured image
//     if ($fallback_img) {
//       set_post_thumbnail($post_id, EXTERNAL_IMAGE_ON_SAVE_FALLBACK_IMG);
//     } else {

//       // Save the image as the featured image
//       if (!empty($image_url)) {
//         $image_id = media_sideload_image($image_url, $post_id, '', 'id');

//         if (!is_wp_error($image_id)) {
//           set_post_thumbnail($post_id, $image_id);
//         }
//       }
//     }
//   }

//   add_action('save_post', 'save_external_image_as_featured_image');
// }

/** Products */
//insert categories
//insert categories
add_action('init', 'insert_products');
function insert_products()
{
  foreach ([
    'Labs & Ortho',
    'Technology',
    'Professional Services',
  ] as $label) {
    $taxonomy = 'product_categories';
    if (!term_exists($label, $taxonomy)) {
      $res = wp_insert_term(
        // string $term, 
        $label,
        // string $taxonomy, 
        $taxonomy,
        // array|string $args = array() 
        []
        /*
           args array|string Optional
              Array or query string of arguments for inserting a term.
           alias_of string
              Slug of the term to make this term an alias of.
              Default empty string. Accepts a term slug.
           description string
              The term description. Default empty string.
           parent int
              The id of the parent term. Default 0.
           slug string
           The term slug to use. Default empty string.
           */
      );
    }
  }

  // $terms_lookup = get_terms([

  // ]);

  // function get_term_id($term) {
  //    return $terms_lookup[$term];//->term_id;
  // }

  // TODO autodraft
  foreach ([
    'Essentials',
    'Good',
    'Best',
    'Ortho',
    'Scanners',
    '3D Printers',
    'IT Support',
    'Consulting',
    'Accounting'
  ] as $title) {
    if (!get_posts([
      'title' => $title,
      'post_type' => 'products_cpt',
      'post_status' => 'publish'
    ])) {
      $pid = wp_insert_post([
        'post_type' => 'products_cpt',
        'post_title' => $title,
        //TODO test length
        'post_excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nibh tortor id aliquet lectus proin.',
        'post_status' => 'publish',
      ]);
      sleep(2);
    }
  }
} //);

// disable author, category, tag, date, custom team cpt, and attachment pages, redirecting the home page
add_action('template_redirect', function () {
  if (
    is_attachment()
    || is_author()
    || is_date()
    || is_tag()
    // || is_post_type_archive('team') || 
    // || is_singular('team') 
  ) {
    wp_redirect(home_url()); // TODO
    exit;
  }
});

function preview_img($filename, $subpath = '')
{
?>
  <figure>
    <!-- TODO -->
    <img style="object-fit: contain; max-width: 100%;" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blocks/<?php echo $filename; ?>.webp" alt="Preview of <?php echo $filename; ?> Block">
  </figure>
<?php
}
