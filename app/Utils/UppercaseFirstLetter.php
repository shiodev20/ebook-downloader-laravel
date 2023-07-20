<?php

namespace App\Utils;

class UppercaseFirstLetter {
  
  public static function make(string $str, ?string $encoding = null): string {
    $result = '';

    $splited = explode(' ', $str);

    foreach ($splited as $item) {
      $result = $result . ' ' . mb_strtoupper(mb_substr($item, 0, 1, $encoding), $encoding) . mb_substr($item, 1, null, $encoding);
    }

    return $result;
  }

}

// return mb_strtoupper(mb_substr($item, 0, 1, $encoding), $encoding) . mb_substr($str, 1, null, $encoding);
