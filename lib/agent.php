<?php
function _slimwriter_parseUserAgent($ua)
  {

    $userAgent = array();
    $agent = $ua;
    $products = array();

    $pattern  = "([^/[:space:]]*)" . "(/([^[:space:]]*))?"
      ."([[:space:]]*\[[a-zA-Z][a-zA-Z]\])?" . "[[:space:]]*"
      ."(\\((([^()]|(\\([^()]*\\)))*)\\))?" . "[[:space:]]*";

    while( strlen($agent) > 0 )
      {
        if ($l = ereg($pattern, $agent, $a))
          {
            // product, version, comment
            array_push($products, array($a[1],    // Product
                                        $a[3],    // Version
                                        $a[6]));  // Comment
            $agent = substr($agent, $l);
          }
        else
          {
            $agent = "";
          }
      }

    // Directly catch these
    foreach($products as $product)
      {
        switch($product[0])
          {
          case 'Firefox':
          case 'Netscape':
          case 'Safari':
          case 'Camino':
          case 'Mosaic':
          case 'Galeon':
          case 'Opera':
            $userAgent[0] = $product[0];
            $userAgent[1] = $product[1];
            break;
          }
      }

    if (count($userAgent) == 0)
      {
        // Mozilla compatible (MSIE, konqueror, etc)
        if ($products[0][0] == 'Mozilla' &&
            !strncmp($products[0][2], 'compatible;', 11))
          {
            $userAgent = array();
            if ($cl = ereg("compatible; ([^ ]*)[ /]([^;]*).*",
                           $products[0][2], $ca))
              {
                $userAgent[0] = $ca[1];
                $userAgent[1] = $ca[2];
              }
            else
              {
                $userAgent[0] = $products[0][0];
                $userAgent[1] = $products[0][1];
              }
          }
        else
        {
          $userAgent = array();
          $userAgent[0] = $products[0][0];
          $userAgent[1] = $products[0][1];
        }
      }

    return $userAgent;
  }
?>
