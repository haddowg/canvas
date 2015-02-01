<?php
/**
 * Clean up the_excerpt()
 */
function canvas_excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'canvas') . '</a>';
}
add_filter('excerpt_more', 'canvas_excerpt_more');
