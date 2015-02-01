<?php
/**
 * Theme wrapper
 *
 * @link http://canvas.io/an-introduction-to-the-canvas-theme-wrapper/
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */
function canvas_template_path() {
  return Canvas_Wrapping::$main_template;
}

function canvas_sidebar_path() {
  return new Canvas_Wrapping('templates/sidebar.php');
}

class Canvas_Wrapping {
  // Stores the full path to the main template file
  public static $main_template;

  // basename of template file
  public $slug;

  // array of templates
  public $templates;

  // Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
  static $base;

  public function __construct($template = 'base.php') {
    $this->slug = basename($template, '.php');
    $this->templates = array($template);

    if (self::$base) {
      $str = substr($template, 0, -4);
      array_unshift($this->templates, sprintf($str . '-%s.php', self::$base));
    }
  }

  public function __toString() {
    $this->templates = apply_filters('canvas/wrap_' . $this->slug, $this->templates);
    return locate_template($this->templates);
  }

  static function wrap($main) {
    // Check for other filters returning null
    if (!is_string($main)) {
      return $main;
    }

    self::$main_template = $main;
    self::$base = basename(self::$main_template, '.php');

    if (self::$base === 'index') {
      self::$base = false;
    }

    return new Canvas_Wrapping();
  }
}
add_filter('template_include', array('Canvas_Wrapping', 'wrap'), 99);
