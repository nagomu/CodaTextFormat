#!/usr/bin/php
<?php
mb_language('Japanese');
mb_internal_encoding('UTF-8');



class TextFormat
{
  /**
   * Convert the given string to alphanumeric.
   *
   * @param   string  $string
   * @return  string
   */
  public static function convertAlphaNumeric($string = '')
  {
    $string = self::normalize($string);

    return mb_convert_kana($string, 'rns', 'UTF-8');
  }

  /**
   * Convert the given string to Hankaku-Kana.
   *
   * @param   string  $string
   * @return  string
   */
  public static function convertJapaneseHankaku($string = '')
  {
    $string = self::normalize($string);

    return mb_convert_kana($string, 'kV', 'UTF-8');
  }

  /**
   * Convert the given string to Zenkaku-Kana.
   *
   * @param   string  $string
   * @return  string
   */
  public static function convertJapaneseZenkaku($string = '')
  {
    $string = self::normalize($string);

    return mb_convert_kana($string, 'KV', 'UTF-8');
  }

  /**
   * Convert the given string to lowercase.
   *
   * @param   string  $string
   * @return  string
   */
  public static function convertLowercase($string = '')
  {
    $string = self::normalize($string);

    return mb_strtolower($string, 'UTF-8');
  }

  /**
   * Convert the given string to uppercase.
   *
   * @param   string  $string
   * @return  string
   */
  public static function convertUppercase($string = '')
  {
    $string = self::normalize($string);

    return mb_strtoupper($string, 'UTF-8');
  }

  /**
   * Convert the given string to title-case.
   *
   * Title Case?
   * Prints MARY HAD A LITTLE LAMB AND SHE LOVED IT SO
   * Prints Mary Had A Little Lamb And She Loved It So
   *
   * @param   string  $string
   * @return  string
   */
  public static function convertTitleCase($string = '')
  {
    $string = self::normalize($string);

    return mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
  }

  /**
   * Convert the given string to camel case.
   *
   * @param   string  $string
   * @return  string
   */
  public static function convertCamelCase($string = '')
  {
    $string = self::convertLowercase(self::normalize($string));

    return lcfirst(str_replace(' ', '', ucwords($string)));
  }

  /**
   * Convert the given string to snake case.
   *
   * @param   string  $string
   * @return  string
   */
  public static function convertSnakeCase($string = '')
  {
    $string = self::convertLowercase(self::normalize($string));
    $string = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1'.'_', $string));

    return str_replace(' ', '_', $string);
  }

  /**
   * Convert the given string to studly caps.
   *
   * @param   string  $string
   * @return  string
   */
  public static function convertStudlyCaps($string = '')
  {
    $string = self::convertLowercase(self::normalize($string));
    $string = ucwords(str_replace(array('-', '_'), ' ', $string));

    return str_replace(' ', '', $string);
  }

  /**
   * Escape the given string to CSS character.
   *
   * @param   string  $string
   * @return  string
   */
  public static function escapeCssCharacter($string = '')
  {
    $string = self::normalize($string);
    $result = '';

    foreach (preg_split('//u', $string, -1, \PREG_SPLIT_NO_EMPTY) as $character) {
      $result .= '\\' . strtoupper(bin2hex(mb_convert_encoding($character, 'UCS-2')));
    }

    return $result;
  }

  /**
   * Get the input value.
   *
   * @return  string
   */
  public static function input()
  {
    $input = '';
    $file_pointer_resource = fopen('php://stdin', 'r');

    while($line = fgets($file_pointer_resource, 1024)) {
      $input .= $line;
    }

    fclose($file_pointer_resource);

    return $input;
  }

  /**
   * Normalize the given string.
   *
   * @param   string  $string
   * @return  string
   */
  private static function normalize($string = '')
  {
    $string = mb_convert_encoding($string, 'UTF-8');
    $string = iconv('UTF-8-MAC', 'UTF-8', $string);

    return iconv('UTF-8-MAC', 'UTF-8', $string);
  }
}

echo TextFormat::escapeCssCharacter(TextFormat::input());
