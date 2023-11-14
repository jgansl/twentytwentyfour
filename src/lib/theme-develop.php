<?php

// on theme activation, rest /setup ping
// class AutoSetup {
//   private $site = [
//     //menus - add new items to menu
//     'pages'
//   ];
// }

/**
 * //TODO can run until TEXTDOMAIN is set
 */
//https://stackoverflow.com/questions/49497202/wordpress-theme-activation-hook-in-php-class



// generate pages
// remove default posts

/** TODO list
 * - run wp-cli - generate sitemap, menus, set home page, generate pages, templates
 * 
 */
// delete default sample page and post
// set home and news page

// Rest api stuff - TODO nonce
add_action('rest_api_init', function () {
  $namespace = 'dev/v1';
  register_rest_route($namespace, '/setup', array(
    'methods'  => 'GET',
    'callback' => 'initSetup',
    // 'permission_callback' => function( WP_REST_Request $request ) {
    // 	return current_user_can( 'manage_options' );
    // },
  ));
});

function initSetup()
{
  $auto = new AutoSetup();
  return new WP_REST_Response('complete', 200);
}
class AutoSetup
{

  private $site = [
    "siteTitle" => "Nightjar",
    "pages" => [
      //  "Home",
      "About" => [],
      "News" => [],
      "Location" => [],
      "Loyalty" => [],
      "Careers" => [],
      "Contact" => [],
      "Knowledge" => [],
    ],
    "posts" => [],
    "cpt" => [],
  ];

  // Constructor
  public function __construct()
  {

    //set theme, sync custom fields -> content hero, cta, 

    //setup menus
    if (!has_nav_menu('primary-navigation')) {
      $this->initMenus();
      //'careers'
      $this->TOSPage(); //front-page
      //disable add new items
      //update legal menu
      //egenarte block, setup home page contnet? meta fields mapping
      return;
    } else {
      /* TODO
      did not remove sample page
      did not update privacy policy page
      update peralink stucture? and flush
      */
      //setup pages
      $this->home(); //front-page
      // $this->developerPage(); //? can overwritten every run
      if ($p = get_posts(['title' => 'Hello world!', 'post_type' => 'post'])) {
        $p = $p[0];
        wp_delete_post($p->ID, true);
      }
      $this->generatePages(); //theme.setup.json; call after /setup to /pages
    }


    // // $this->completeMenus();
    // // $this-generateTaxonomies();
    // // $this-generatePosts();
    // $this->theme_options_info();


    //update settings
    //https://developer.wordpress.org/reference/functions/wp_insert_site/
    update_option('blogname', $this->site['siteTitle']);
    update_option('blog_public', '0'); //Discourage Search Engines From Indexing
    //flush permalinks/ changes post permalink
    // sycn fields, theme options, live site download, post migration

  }

  public function initMenus()
  { //TODO sst
    global $menus_arr; //TODO

    // array(
    //    'primary-navigation' => __( 'Primary Navigation' ),
    //    'mobile-navigation' => __( 'Mobile Navigation' ),
    //    'footer' => __( 'Footer Navigation' ),
    // )
    $locations = get_theme_mod('nav_menu_locations');
    // foreach($site['menus']) {
    //    if(!has_nav_menu('primary-navigation')) {
    //       $mid = wp_create_nav_menu( 'Top Navigation' );
    //       $locations['primary-navigation'] = $mid;
    //    }
    // }
    // if(!has_nav_menu('primary-navigation')) {
    //    $mid = wp_create_nav_menu( 'Primary Navigation' );
    //    $locations['primary-navigation'] = $mid;
    // }
    foreach ($menus_arr as $key => $val) {
      if (!has_nav_menu($key)) {
        $mid = wp_create_nav_menu($val);
        $locations[$key] = $mid;
      }
    }
    // if(!has_nav_menu('mobile-navigation')) {
    //    $mid = wp_create_nav_menu( 'Mobile Navigation' );
    //    $locations['mobile-navigation'] = $mid;
    // }
    // if(!has_nav_menu('footer-navigation')) {
    //    $mid = wp_create_nav_menu( 'Footer Navigation' );
    //    $locations['footer-navigation'] = $mid;
    // }
    set_theme_mod('nav_menu_locations', $locations);
  }

  public function generatePages()
  { //TODO nested pages
    $menu_idx = 10;
    foreach (array_keys($this->site['pages']) as $page) {
      if (!get_posts([
        'title' => $page,
        'post_type' => 'page',
        'post_status' => 'publish',
      ])) {
        $pid = wp_insert_post([
          'post_type' => 'page',
          'post_title' => $page,
          'post_status' => 'publish',
          'menu_order' => $menu_idx++,
        ]);

        if ($this->site['pages'][$page]) { //TODO recursive
          foreach ($this->site['pages'][$page] as $subpage) {
            if (!get_posts([ //assumes not the same title
              'title' => $subpage,
              'post_type' => 'page',
              'post_status' => 'publish',
            ])) {
              $subpid = wp_insert_post([
                'post_type' => 'page',
                'post_title' => $subpage,
                'post_status' => 'publish',
              ]);
              //not added to menu -> update after
              wp_insert_post([
                'ID' => $subpid,
                'post_parent' => $pid
              ]);
            }
          }
        }
      }
    }
  }
  public function home()
  {
    $title = 'Home';
    if (!get_page_by_title($title)) {
      wp_insert_post([
        'menu_order' => -90,
        'post_type' => 'page',
        'post_title' => $title,
        'post_status' => 'publish',
      ]);
    }

    if ($home = get_page_by_title($title)) {
      update_option('page_on_front', $home->ID);
      update_option('show_on_front', 'page');
    }
  }

  public function TOSPage()
  {
    $privacy = get_page_by_title('Privacy Policy');
    wp_insert_post([
      'ID' => $privacy->ID,
      'menu_order' => 91,
      'post_status' => 'publish',
    ]);

    $title = 'Terms of Service';
    if (!$page = get_page_by_title($title)) {
      $pid = wp_insert_post([
        'menu_order' => 90,
        'post_type' => 'page',
        'post_title' => $title,
        'post_status' => 'publish',
      ]);
    } else {
      $pid = $page->ID;
    }

    update_post_meta($pid, '_wp_page_template', 'templates/legal.php');
  }

  public function developerPage()
  {
    /** TODO
     * var_dump
     */

    if ($sample = get_page_by_title('Sample Page')) {
      wp_delete_post($sample->ID, true);
    }
    if (!$sample = get_page_by_title('Develop')) {
      $sample_id = wp_insert_post([
        'menu_order' => -99,
        'post_type' => 'page', //TODO post
        'post_title' => 'Develop', //! dup
        'post_status' => 'private',
        //TODO change slug
        'post_content' => "
               <!-- wp:heading {\"level\":1} -->
               <h1>Heading 1</h1>
               <!-- /wp:heading -->
   
               <!-- wp:heading -->
               <h2>Heading 2</h2>
               <!-- /wp:heading -->
   
               <!-- wp:heading {\"level\":3} -->
               <h3>Heading 3</h3>
               <!-- /wp:heading -->
   
               <!-- wp:heading {\"level\":4} -->
               <h4>Heading 4</h4>
               <!-- /wp:heading -->
   
               <!-- wp:heading {\"level\":5} -->
               <h5>Heading 5</h5>
               <!-- /wp:heading -->
   
               <!-- wp:heading {\"level\":6} -->
               <h6>Heading 6</h6>
               <!-- /wp:heading -->
   
               <!-- wp:paragraph -->
               <p>normal body content</p>
               <!-- /wp:paragraph -->
   
            
            "
      ]);
      // $sample = get_page_by_title('Develop');
      // return;
    } else {
      $sample_id = $sample->ID;
    }

    return; //TODO V

    //! overwrite every single run
    $pid = wp_update_post([
      'ID' => $sample_id,
      //TODO change slug
      'post_content' => "
            <!-- wp:heading {\"level\":1} -->
            <h1>Heading 1</h1>
            <!-- /wp:heading -->

            <!-- wp:heading -->
            <h2>Heading 2</h2>
            <!-- /wp:heading -->

            <!-- wp:heading {\"level\":3} -->
            <h3>Heading 3</h3>
            <!-- /wp:heading -->

            <!-- wp:heading {\"level\":4} -->
            <h4>Heading 4</h4>
            <!-- /wp:heading -->

            <!-- wp:heading {\"level\":5} -->
            <h5>Heading 5</h5>
            <!-- /wp:heading -->

            <!-- wp:heading {\"level\":6} -->
            <h6>Heading 6</h6>
            <!-- /wp:heading -->

            <!-- wp:paragraph -->
            <p>normal body content</p>
            <!-- /wp:paragraph -->

         
         "
    ]);
  }

  public function theme_options_info()
  {
    // read json file / CSV template / yaml reader
    // sync menus
    // set social media information, contact email
  }

  public function posts_from_csv($file, $post_type)
  {
    $file = "1_23.csv";
    $csv = file_get_contents($file);
    $array = array_map("str_getcsv", explode("\n", $csv));
    $json = json_encode($array);
    return $json;

    $title = '';
    foreach ($row as $post) {
      $pid = wp_insert_post([
        'post_type' => $post_type,
        'post_title' => 'sample',
        'post_content' => '', //TODO new post autosetup hook
      ]);
    }
    //wp_set_object_terms
  }
}
