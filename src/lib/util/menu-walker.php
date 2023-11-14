<?php

/* Custom menu walker to add svgs to menu items */
class Nav_Menu_With_SVG extends Walker_Nav_Menu
{

   private $svgs;

   public function __construct($svgs = array())
   {
      $this->svgs = $svgs;
   }

   public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object = 0)
   {
      $item = $data_object;
      $classes = empty($item->classes) ? array() : (array) $item->classes;
      $classes = array_filter($classes);
      $classFound = false;

      if (!empty($this->svgs)) {
         foreach ($classes as $class) {
            if (in_array($class, array_keys($this->svgs))) {
               $classFound = $class;
            }
         }

         if ($classFound) {
            $output .= '<li class="' . implode(' ', $classes) . '">';
            $output .= '<a href="' . $item->url . '">' . $item->title . $this->svgs[$classFound] . '</a>';
         } else {
            $output .= '<li class="' . implode(' ', $classes) . '">';
            $output .= '<a href="' . $item->url . '">' . $item->title . '</a>';
         }
      } else {
         $output .= '<li class="' . implode(' ', $classes) . '">';
         $output .= '<a href="' . $item->url . '">' . $item->title . '</a>';
      }
   }
}
