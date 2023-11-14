<?php

add_action('init', 'setup_custom_post_types');
function setup_custom_post_types()
{
  /**
   * Make sure to add the messages for any taxonomies declared
   *
   * $menu_icons - @see https://developer.wordpress.org/resource/dashicons/#admin-site
   */

  // /** 
  //  * PLACEHOLDER
  //  */
  // cpt_init(
  //    $slug,
  //    $name,
  //    $singular_name,
  //    $plural_name,
  //    $rest_base,
  //    $menu_icon,
  //    $supports = [ 'title', 'editor', 'thumbnail', 'excerpt' ],
  //    $taxonomies = [
  //       [$tax_slug, [ $post_type_slugs ], $tax_singular_name, $tax_plural_name],
  //       [$tax_slug, [ $post_type_slugs ], $tax_singular_name, $tax_plural_name],
  //    ]
  // );

  /** 
   * FAQs
   */
  cpt_init(
    'faqs_cpt', // $slug
    'FAQs', // $name
    'FAQ',  // $singular_name
    'FAQs', // $plural_name
    'faqs_cpt', // $rest_base
    'dashicons-welcome-learn-more', //$menu_icon,
    $supports = ['title', 'editor'],
    $taxonomies = [
      [
        'faq_categories', // $tax_slug
        ['faqs_cpt'],       // $post_type_slugs,
        'FAQ Category',   // $tax_singular_name, 
        'FAQ Categories'  // $tax_plural_name
      ],
    ],
    false, // $has_archive - disables categories if false
    false, // $publicly_queryable
  );

  /** 
   * Products
   */
  cpt_init(
    'products_cpt', // $slug
    'Products', // $name
    'Product',  // $singular_name
    'Products', // $plural_name
    'products_cpt', // $rest_base
    'dashicons-admin-users', //$menu_icon,
    $supports = ['title', 'editor', 'thumbnail', 'excerpt'],
    $taxonomies = [
      [
        'product_categories', // $tax_slug
        ['products_cpt'],       // $post_type_slugs,
        'Product Category',   // $tax_singular_name, 
        'Product Categories'  // $tax_plural_name
      ],
    ],
    //false, // $has_archive - disables categories if false
    //false, // $publicly_queryable
  );


  /*** Copy and Update for each Taxonomy */
  add_filter('term_updated_messages', 'FAQ_categories_updated_messages');
  function FAQ_categories_updated_messages($messages)
  {

    $slug          = "faq_categories";
    $singular_name = "FAQ Category";
    $plural_name   = "FAQ Categories";

    cpt_updated_messages($messages, $slug, $singular_name, $plural_name);
    return $messages;
  }
  add_filter('term_updated_messages', 'product_categories_updated_messages');
  function product_categories_updated_messages($messages)
  {

    $slug          = "product_categories";
    $singular_name = "Product Category";
    $plural_name   = "Product Categories";

    cpt_updated_messages($messages, $slug, $singular_name, $plural_name);
    return $messages;
  }
}



//TODO

/**
 * Sets the post updated messages for the `slug` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `slug` taxonomy.
 */
function cpt_updated_messages(
  $messages,
  $slug,
  $singular_name,
  $plural_name
) {
  $messages[$slug] = [
    0 => '', // Unused. Messages start at index 1.
    1 => __($singular_name . ' added.', 'reade-theme'),
    2 => __($singular_name . ' deleted.', 'reade-theme'),
    3 => __($singular_name . ' updated.', 'reade-theme'),
    4 => __($singular_name . ' not added.', 'reade-theme'),
    5 => __($singular_name . ' not updated.', 'reade-theme'),
    6 => __($plural_name . ' deleted.', 'reade-theme'),
  ];

  return $messages;
}

function generateTaxonomy(
  $tax_slug,
  $tax_post_type_slugs,
  $tax_singular_name,
  $tax_plural_name
) {
  register_taxonomy($tax_slug, $tax_post_type_slugs, [
    'hierarchical'          => true,
    'public'                => true,
    'show_in_nav_menus'     => true,
    'show_ui'               => true,
    'show_admin_column'     => false,
    'query_var'             => true,
    'rewrite'               => true,
    'capabilities'          => [
      'manage_terms' => 'edit_posts',
      'edit_terms'   => 'edit_posts',
      'delete_terms' => 'edit_posts',
      'assign_terms' => 'edit_posts',
    ],
    'labels'                => [
      'name'                       => __("$tax_plural_name", 'reade-theme'),
      'singular_name'              => _x("$tax_singular_name", 'taxonomy general name', 'reade-theme'),
      'search_items'               => __("Search " . $tax_plural_name, 'reade-theme'),
      'popular_items'              => __("Popular " . $tax_plural_name, 'reade-theme'),
      'all_items'                  => __("All " . $tax_plural_name, 'reade-theme'),
      'parent_item'                => __("Parent " . $tax_singular_name, 'reade-theme'),
      'parent_item_colon'          => __("Parent " . $tax_singular_name . ":", 'reade-theme'),
      'edit_item'                  => __("Edit " . $tax_singular_name, 'reade-theme'),
      'update_item'                => __("Update " . $tax_singular_name, 'reade-theme'),
      'view_item'                  => __("View " . $tax_singular_name, 'reade-theme'),
      'add_new_item'               => __("Add New " . $tax_singular_name, 'reade-theme'),
      'new_item_name'              => __("New $tax_singular_name", 'reade-theme'),
      'separate_items_with_commas' => __("Separate " . strtolower($tax_plural_name) . " with commas", 'reade-theme'),
      'add_or_remove_items'        => __("Add or remove " . strtolower($tax_plural_name), 'reade-theme'),
      'choose_from_most_used'      => __("Choose from the most used " . strtolower($tax_plural_name), 'reade-theme'),
      'not_found'                  => __("No " . strtolower($tax_plural_name) . " found.", 'reade-theme'),
      'no_terms'                   => __("No " . strtolower($tax_plural_name), 'reade-theme'),
      'menu_name'                  => __($tax_plural_name, 'reade-theme'),
      'items_list_navigation'      => __($tax_plural_name . " list navigation", 'reade-theme'),
      'items_list'                 => __($tax_plural_name . " list", 'reade-theme'),
      'most_used'                  => _x("Most Used", $tax_slug, 'reade-theme'),
      'back_to_items'              => __("&larr; Back to " . $tax_plural_name, 'reade-theme'),
    ],
    'show_in_rest'          => true,
    'rest_base'             => $tax_slug, //STARTER
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  ]);

  //cpt_updated_messages( $messages, $tax_slug, $tax_singular_name, $tax_plural_name);
}


function cpt_init(
  $slug,
  $name,
  $singular_name,
  $plural_name,
  $rest_base,
  $menu_icon,
  $supports = ['title', 'editor', 'thumbnail', 'excerpt'],
  $taxonomies = [],
  $has_archive = true,
  $publicly_queryable = true
) {

  register_post_type(
    $slug,
    [
      'labels'                => [
        'name'                  => __("$name", 'reade-theme'),
        'singular_name'         => __("$singular_name", 'reade-theme'),
        'all_items'             => __("All $plural_name", 'reade-theme'),
        'archives'              => __("$name Archives", 'reade-theme'),
        'attributes'            => __("$name Article Attributes", 'reade-theme'),
        'insert_into_item'      => __("Insert into $singular_name", 'reade-theme'),
        'uploaded_to_this_item' => __("Uploaded to this $singular_name", 'reade-theme'),
        'featured_image'        => _x("Featured Image", $slug, 'reade-theme'),
        'set_featured_image'    => _x("Set featured image", $slug, 'reade-theme'),
        'remove_featured_image' => _x("Remove featured image", $slug, 'reade-theme'),
        'use_featured_image'    => _x("Use as featured image", $slug, 'reade-theme'),
        'filter_items_list'     => __("Filter $plural_name list", 'reade-theme'),
        'items_list_navigation' => __("$plural_name list navigation", 'reade-theme'),
        'items_list'            => __("$plural_name list", 'reade-theme'),
        'new_item'              => __("New $singular_name", 'reade-theme'),
        'add_new'               => __("Add New", 'reade-theme'),
        'add_new_item'          => __("Add New $singular_name", 'reade-theme'),
        'edit_item'             => __("Edit $singular_name", 'reade-theme'),
        'view_item'             => __("View $singular_name", 'reade-theme'),
        'view_items'            => __("View $plural_name", 'reade-theme'),
        'search_items'          => __("Search $plural_name", 'reade-theme'),
        'not_found'             => __("No $plural_name found", 'reade-theme'),
        'not_found_in_trash'    => __("No $plural_name found in trash", 'reade-theme'),
        'parent_item_colon'     => __("Parent $singular_name:", 'reade-theme'),
        'menu_name'             => __("$plural_name", 'reade-theme'),
      ],
      'public'                => true,
      'hierarchical'          => true,
      'show_ui'               => true,
      'show_in_nav_menus'     => true,
      'supports'              => $supports,
      'has_archive'           => true, //$has_archive,
      'publicly_queryable'    => $publicly_queryable,
      'rewrite'               => true, //[ 'slug' => $rest_base ],//true,
      'query_var'             => true,
      'menu_position'         => null,
      'menu_icon'             => $menu_icon,
      'show_in_rest'          => true,
      'rest_base'             => $slug, //$rest_base,
      'rest_controller_class' => 'WP_REST_Posts_Controller',
    ]
  );

  foreach ($taxonomies as $idx => $tax) {
    generateTaxonomy(...$tax);
    //    'press_source',  //$slug
    //    [ 'press' ],     //$post_type_slugs
    //    'Press Source',  //$singular_name
    //    'Press Sources', //$plural_name
    // );
  }
}


add_action('wp_enqueue_scripts', function () {
  for ($x = 0; $x  < 20; $x++) {
    foreach ([
      'faqs_cpt',
      'post',
      'products_cpt'
    ] as $post_type) {
      $title = "Example  " . implode(" ", array_map(function ($w) {
        return ucfirst($w);
      }, explode('_', $post_type))) . " " . strval($x);
      if (!get_posts([
        'title' => $title,
        'post_type' => $post_type,
        'post_status' => 'publish'
      ])) {
        wp_insert_post([
          'post_title' => $title,
          'post_type' => $post_type,
          'post_status' => 'publish'
        ]);
        sleep(0.5);
      }
    }
  }
});
