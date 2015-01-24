<?php
  header("Content-Type: text/plain; UTF-8");

  /**
   * mb_pathinfo (yet another multi-byte-safe pathinfo alternative)
   *
   * @param string $path    - filename-like complete string (does not need to be actually existing in the OS).
   * @param string $segment - optionally specify just one path-segments ('all' - all of them in an associative array).
   * @param string $concat  - optionally specify any string (filename) to append at the end.
   *
   * @return string|array   - a break-down to path-like component (entire segments, or just one of them).
   * @author Elad Karako (icompile.eladkarako.com)
   */
  function mb_pathinfo($path = __FILE__, $segment = 'all', $concat = '') {
    $placements = ['path', 'dirname', 'basename', 'filename', 'dot_extension', 'extension'];
    $segment = 'all' === $segment ? $segment : in_array($segment, $placements) ? $segment : 'all'; //normalize input (only be whats available initially in placements, or 'all').

    $info = [];
    preg_replace_callback('%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im', function ($arr) use (&$info, $placements) {
      foreach ($placements as $index => $value)
        $info[ $value ] = isset($arr[ $index ]) ? $arr[ $index ] : '';
    }, $path);

    $info['all'] = array_merge([], $info); //copy to place in self (if returning 'all')

//    var_dump($info);

    //we want to use the resolved path, as base to another file.
    $path = rtrim($info['dirname'], '/\\') . DIRECTORY_SEPARATOR . $concat;

    return ('' === $concat) ? $info[ $segment ] : mb_pathinfo($path, $segment); //at most 1 more recursive request.
  }

  print_r(
    mb_pathinfo(__FILE__)
  );
  /* sample output:
   *  Array
   *  (
   *   [path] => C:\WTNMP\WWW\mbpath\index.php
   *   [dirname] => C:\WTNMP\WWW\mbpath
   *   [basename] => index.php
   *   [filename] => index
   *   [dot_extension] => .php
   *   [extension] => php
   *  )
   */

  print_r(
    mb_pathinfo(__FILE__, 'all', 'onpage.php')
  );
  /* sample output:
   *  Array
   *  (
   *   [path] => C:\WTNMP\WWW\mbpath\onpage.php
   *   [dirname] => C:\WTNMP\WWW\mbpath
   *   [basename] => index.php
   *   [filename] => index
   *   [dot_extension] => .php
   *   [extension] => php
   *  )
   */
