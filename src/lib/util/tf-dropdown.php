<?php

/**
 * Generates a pseudo dropdown
 *
 * @param array $option - array of options
 * 	width		=> (string) dropdown id, default is tf-dropdown - should always be set
 * 	values		=> (array) key value pair of values array - should always be set
 * 	selected_value => (string) key of value that should be pre-selected, default none
 * 	select_text => (string) text that should be used for "Select", default "select"
 * 	svg			=> (string) svg to use for the dropdown arrow
 * 	show_all 	=> (bool) show an "all" or not, default false
 * 	show_all_text => (string) Default text for "all", default "all"
 * 	width		=> (string) width of dropdown
 */
function tf_dropdown($options)
{

   /* String container for output */
   $output = '';

   /* Set default options */
   $default_options = array(
      'id'      => 'tf-dropdown',
      'values'   => array('0' => 'Set', '1' => 'Some', '2' => 'Values'),
      'selected_value' => '',
      'select_text'   => 'Select',
      'svg'         => '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 960 560" enable-background="new 0 0 960 560" xml:space="preserve">
				<g id="Rounded_Rectangle_33_copy_4_1_">
					<path d="M480,344.181L268.869,131.889c-15.756-15.859-41.3-15.859-57.054,0c-15.754,15.857-15.754,41.57,0,57.431l237.632,238.937
						c8.395,8.451,19.562,12.254,30.553,11.698c10.993,0.556,22.159-3.247,30.555-11.698l237.631-238.937
						c15.756-15.86,15.756-41.571,0-57.431s-41.299-15.859-57.051,0L480,344.181z"/>
				</g>
			</svg>',
      'return'      => false,
      'width'         => '225px',
      'show_all'      => false,
      'show_all_text' => 'All',
      'extra_classes' => array()
   );

   /* fill out all options with defaults if they're not set */
   $opts = array();

   foreach ($default_options as $k => $v) {
      $opts[$k] = (!isset($options[$k]) || (empty($options[$k]) === true))
         ? $default_options[$k]
         : $options[$k];
   }

   // do we need to load css?
   if (!defined('TF_DROPDOWN_CSS')) {
      $output .= tf_dropdown_css($opts['return'], $opts['width']);
   } else {
      // additional dropdown is being added, add specific width for this one
      if (!empty($opts['width'])) {
         $output .= '<style>#' . $opts['id'] . ' { width: ' . $opts['width'] . ' }</style>';
      }
   }

   $output .= '<dl id="' . $opts['id'] . '" class="tf-dropdown' . (!empty($opts['extra_classes']) ? ' ' . implode(' ', $opts['extra_classes']) : '') . '">
		<dt>';

   if ($opts['selected_value'] && empty($opts['selected_value']) !== true) {
      $output .= '<p>' . $opts['values'][$opts['selected_value']] . '</p>';
   } else {
      $output .= '<p>' . $opts['select_text'] . '</p>';
   }

   $output .= $opts['svg'];

   $output .= '</dt>
		<dd>
			<div class="tf-dropdown-list">
				<ul>';

   if (!empty($opts['values'])) {
      if ($opts['show_all']) {
         $output .= '<li data-key="all">' . ($opts['show_all_text'] ? $opts['show_all_text'] : 'All') . '</li>';
      }
      foreach ($opts['values'] as $key => $value) {
         $output .= '<li data-key="' . $key . '"';
         //echo $opts['select_text'] . '<br />' . $value . '<br /><br />';
         if (str_replace('&nbsp;&nbsp;&nbsp;', '', strtolower($value)) == str_replace('&nbsp;&nbsp;&nbsp;', '', strtolower($opts['select_text']))) {
            $output .= ' class="tf-li-selected"';
         }
         $output .= '>' . $value . '</li>';
      }
   }

   $output .= '</ul>
			</div>
		</dd>
	</dl>';

   if (!defined('TF_DROPDOWN_JS')) {
      $output .= tf_dropdown_js($opts['return']);
   }

   if ($opts['return']) {
      return $output;
   }

   echo $output;
}

/**
 * Loads css only once in the case of multiple dropdowns
 * 
 * @param bool $return - passed from tf_dropdown()
 * @return string|null
 */
function tf_dropdown_css($return, $width)
{

   define('TF_DROPDOWN_CSS', true);

   $css = '<style>.tf-dropdown{display:inline-block;border:1px solid #aeaeae;border-radius:10px;user-select:none;cursor:pointer;position:relative;transform:ease .35s}.tf-dropdown dt{display:flex;align-items:center;padding:5px;box-sizing:border-box}.tf-dropdown dt svg{margin-left:auto;padding-right:5px;transition:.35s;transform:scaleY(1)}.tf-dropdown dd,.tf-dropdown dt{min-width:' . $width . '}.tf-dropdown dt p{margin:0}.tf-dropdown dd{width:100%;transform:scaleY(0);transform-origin:top left;margin:0;border:1px solid #aeaeae;position:absolute;top:100%;left:-1px;border-bottom-right-radius:10px;border-bottom-left-radius:10px;transition:.35s;background-color:#fff;z-index:1}.tf-dropdown dd ul li,.tf-dropdown-open{border-bottom-left-radius:0;border-bottom-right-radius:0}.tf-dropdown dd ul{padding-left:0;list-style-type:none;margin-top:0;margin-bottom:0}.tf-dropdown dd ul li{min-height:30px;line-height:20px;padding-left:5px;padding-right:5px;display:flex;align-items:center}.tf-dropdown dd ul li:last-of-type{margin-bottom:0;border-bottom-left-radius:6px;border-bottom-right-radius:6px}.tf-dropdown dd ul li:hover{background-color:#aeaeae;font-weight:800}.tf-dropdown-open dt svg{transform:scaleY(-1)}.tf-dropdown-open dd{transform:scaleY(1)}</style>';

   echo $css;
}

/**
 * Loads js only once in the case of multiple dropdowns
 * 
 * @param bool $return - passed from tf_dropdown()
 * @return string|null
 */
function tf_dropdown_js($return)
{

   define('TF_DROPDOWN_JS', true);
   $js = '<script>
    let clickOutside = function(e) {
        e.preventDefault();
        let alldd = document.getElementsByClassName("tf-dropdown");
        if (alldd.length) {
         for (let k = 0; k < alldd.length; k++) {
            if (alldd[k].getAttribute("id") != document.sorterID) {
               alldd[k].classList.remove("tf-dropdown-open");
            }
         }
      }
        if(!document.getElementById(document.sorterID).contains(e.target)) {
         document.getElementById(document.sorterID).classList.remove("tf-dropdown-open");
         document.removeEventListener("click", clickOutside);
        }
    };

    function toggleDropdown(e) {
     
        let t = document.getElementById(e);
        if (t.classList.contains("tf-dropdown-open")) {
         t.classList.remove("tf-dropdown-open");
         document.removeEventListener("click", clickOutside);
         document.sorterID = t.getAttribute("id");
        } else {
         t.classList.add("tf-dropdown-open");
         document.addEventListener("click", clickOutside);
         document.sorterID = t.getAttribute("id");
        }
    }
    document.addEventListener("DOMContentLoaded", function() {
        let e = document.getElementsByClassName("tf-dropdown");
        if (e.length)
            for (let t = 0; t < e.length; t++) {
               let origvalue = e[t].querySelector("dt p").innerText;
                e[t].addEventListener("click", function(z) {
                  if (e[t].getAttribute("id") != "sorterx") {
                     if(z.target.tagName.toLowerCase() != "li") {
                       toggleDropdown(e[t].getAttribute("id"))
                     }
                  } else {
                     toggleDropdown(e[t].getAttribute("id"));
                  }
                  
                });
                let n = e[t].querySelectorAll("li");
                if (n.length)
                    for (let o = 0; o < n.length; o++) n[o].addEventListener("click", function() {
                        e[t].querySelector("dt p").innerText = n[o].innerText;
                        toggleDropdown(e[t].getAttribute("id"));
                    })
            }
    });
  </script>';

   echo $js;
}