<?php
  header("Content-Type: text/plain; UTF-8");

  /**
   * mb_pathinfo (yet another multi-byte-safe pathinfo alternative)
   *
   * @param string $path    - filename-like complete string (does not need to be actually existing in the OS).
   * @param string $segment - optionally specify just one path-segments ('all' - all of them in an associative array).
   *
   * @return string|array   - a break-down to path-like component (entire segments, or just one of them).
   * @author Elad Karako (icompile.eladkarako.com)
   */
  function mb_pathinfo($path = __FILE__, $segment = 'all') {
    $placements = ['path', 'dirname', 'basename', 'filename', 'dot_extension', 'extension'];
    $segment = 'all' === $segment ? $segment : in_array($segment, $placements) ? $segment : 'all'; //normalize input (only be whats available initially in placements, or 'all').

    $info = [];
    preg_replace_callback('%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im', function ($arr) use (&$info, $placements) {
      foreach ($placements as $index => $value)
        $info[ $value ] = isset($arr[ $index ]) ? $arr[ $index ] : '';
    }, $path);

    $info['all'] = array_merge([], $info); //copy to place in self (if returning 'all')

//    var_dump($info);

    return $info[ $segment ];
  }

  var_dump(
    mb_pathinfo(__FILE__)
  );
