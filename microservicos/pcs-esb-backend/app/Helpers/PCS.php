<?php

namespace App\Helpers;

class PCS
{
  public static function parseJWT($jwt)
  {
    return json_decode(base64_decode(explode('.', $jwt)[1]));
  }
}
