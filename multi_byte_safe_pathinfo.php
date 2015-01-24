<?php
  header("Content-Type: text/plain; UTF-8");

  /**
   * mb_pathinfo (yet another multi-byte-safe pathinfo alternative)
   *
   * @param string $path - filename-like string (does not need to be actually existing in the OS).
   *
   * @return array       - a break-down to path-like component
   * @author Elad Karako (icompile.eladkarako.com)
   */
  function mb_pathinfo($path = __FILE__) {
    $placements = ['path', 'dirname', 'basename', 'filename', 'dot_extension', 'extension'];
    $info = [];
    preg_replace_callback('%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im', function ($arr) use (&$info, $placements) {
      foreach ($placements as $index => $value)
        $info[ $value ] = isset($arr[ $index ]) ? $arr[ $index ] : '';
    }, $path);

    return $info;
  }

  var_dump(
    mb_pathinfo(__FILE__)
  );
