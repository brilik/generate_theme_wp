<?php

namespace Generator;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

include_once "../../consts.php";

/**
 * Class Theme
 *
 * For replace:
 * Theme Name: %template_theme_name%
 * Theme URI: %template_theme_uri%
 * Author: %template_theme_author%
 * Author URI: %template_theme_author_uri%
 * Description: %template_theme_description%
 * Text Domain: %template_text_domain%
 *
 * @package Generator
 */
class Theme {
    public $ThemeName;
    public $ThemeURI;
    public $Author;
    public $AuthorURI;
    public $Description;
    public $TextDomain;
    private $archiveName;
    private $tplDIR = DIR_APP . '/' . DIR_TPL_DEFAULT;
    private $dwnlDIR = DIR_APP . '/' . DIR_DOWNLOADS;

    /**
     * Generation theme.
     *
     * @param $arr
     *
     * @return string
     * @uses arr['template_theme_name']
     * @uses arr['template_theme_uri']
     *
     */
    public function generate( $arr ) {
        $this->ThemeName   = $arr['template_theme_name'];
        $this->TextDomain  = $arr['template_text_domain'] = $this->get_replace_str_to_slug( $this->ThemeName );
        $this->ThemeURI    = $arr['template_theme_uri'] ?? '';
        $this->Author      = $arr['template_theme_author'] ?? '';
        $this->AuthorURI   = $arr['template_theme_author_uri'] ?? '';
        $this->Description = $arr['template_theme_description'] ?? '';

        $this->copy_content_dir( $this->tplDIR, $this->dwnlDIR );

        foreach ( $arr as $key => $item ) {
            $this->replace_tag_name( $this->dwnlDIR, $key, $item );
        }

        $this->archive( $this->dwnlDIR );

        return json_encode( [
            'themeName'  => $this->ThemeName,
            'getArchive' => self::get_url() . 'downloads/' . $this->archiveName
        ] );
    }

    /**
     * Renaming theme name to slug name and get.
     *
     * @param $str
     *
     * @return mixed
     */
    private function get_replace_str_to_slug( $str ) {
        $str = mb_strtolower( $str );

        return str_replace( ' ', '_', $str );
    }

    /**
     * Coping all content with template in folder for download.
     *
     * @param $source
     * @param $target
     */
    private function copy_content_dir( $source, $target ) {
        if ( is_dir( $source ) ) {
            @mkdir( $target );
            $d = dir( $source );
            while ( false !== ( $entry = $d->read() ) ) {
                if ( $entry == '.' || $entry == '..' ) {
                    continue;
                }
                $this->copy_content_dir( "$source/$entry", "$target/$entry" );
            }
            $d->close();
        } else {
            copy( $source, $target );
        }
    }

    /**
     * Change tag name (with form).
     *
     * @param $dirname
     * @param $text
     * @param $retext
     * @param string $separator
     */
    private function replace_tag_name( $dirname, $text, $retext, $separator = '%' ) {

        $tag = $separator . $text . $separator;
        // Открываем текущую директорию
        $dir = opendir( $dirname );
        // Читаем в цикле директорию
        while ( ( $file = readdir( $dir ) ) !== false ) {
            if ( $file != "." && $file != ".." ) {
                // Если имеем дело с файлом - производим в нём замену
                if ( is_file( $dirname . "/" . $file ) ) {
                    // Читаем содержимое файла
                    $content = file_get_contents( $dirname . "/" . $file );
                    // Осуществляем замену
                    $content = str_replace( $tag, $retext, $content );
                    // Перезаписываем файл
                    file_put_contents( $dirname . "/" . $file, $content );
                }
                // Если перед нами директория, вызываем рекурсивно функцию $this->replace_tag_name()
                if ( is_dir( $dirname . "/" . $file ) ) {
                    $this->replace_tag_name( $dirname . '/' . $file, $text, $retext );
                }
            }
        }
        // Закрываем директорию
        closedir( $dir );
    }

    /**
     * Archive all content.
     *
     * @param $source
     * @param string $archiveName
     *
     * @return bool
     */
    private function archive( $source, $archiveName = '' ) {

        if ( ! extension_loaded( 'zip' ) || ! file_exists( $source ) ) {
            return false;
        }

        $archiveName = empty( $archiveName ) ? $this->TextDomain . '.zip' : $archiveName . '.zip';

        $this->archiveName = $archiveName;

        $zip = new ZipArchive();
        if ( ! $zip->open( $this->dwnlDIR . '/' . $archiveName, ZIPARCHIVE::CREATE ) ) {
            return false;
        }

        $source = str_replace( '\\', '/', realpath( $source ) );

        if ( is_dir( $source ) === true ) {
            $files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $source ), RecursiveIteratorIterator::SELF_FIRST );

            foreach ( $files as $file ) {
                $file = str_replace( '\\', '/', $file );

                // Ignore "." and ".." folders
                if ( in_array( substr( $file, strrpos( $file, '/' ) + 1 ), array( '.', '..' ) ) ) {
                    continue;
                }

                $file = realpath( $file );
                $file = str_replace( '\\', '/', $file );

                if ( is_dir( $file ) === true ) {
                    $zip->addEmptyDir( str_replace( $source . '/', '', $file . '/' ) );
                } else if ( is_file( $file ) === true ) {
                    $zip->addFromString( str_replace( $source . '/', '', $file ), file_get_contents( $file ) );
                }
            }
        } else if ( is_file( $source ) === true ) {
            $zip->addFromString( basename( $source ), file_get_contents( $source ) );
        }

        return $zip->close();
    }

    /**
     * Get url suit.
     *
     * @return string
     */
    private static function get_url() {
        // output: /myproject/index.php
        // $currentPath = $_SERVER['PHP_SELF'];

        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
        // $pathInfo = pathinfo($currentPath);

        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];

        // output: http://
        $protocol = strtolower( substr( $_SERVER["SERVER_PROTOCOL"], 0, 5 ) ) == 'https' ? 'https' : 'http';

        // return: http://localhost/myproject/
        return $protocol . '://' . $hostName . "/";
        // return $protocol.'://'.$hostName.$pathInfo['dirname']."/";
    }
}