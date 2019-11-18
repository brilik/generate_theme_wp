<?php

namespace Project;

class Methods {
    
    /**
     * Подключение файла
     *
     * @param string $path
     * @param string $file_name
     * @param string $extensions
     */
    public static function include_file( string $path, string $file_name = 'index', string $extensions = 'php' ) {
        
        $file = $path . $file_name . '.' . $extensions;
        
        try {
            
            if ( ! strripos( $file_name, '.' ) === false ) {
                throw new \Exception( 'Расширения файла во втором параметре не допустимо. Расширение указывается третим параметром.' );
            }
            
            if ( ! file_exists( $file ) ) {
                throw new \Exception( 'Проверьте правильность в названии файла или каталога.' );
            }
            
        } catch ( \Exception $e ) {
            echo '<b>Ошибочка</b>: ', $e->getMessage(), "\n<br>";
        }
        
        include_once( $file );
        
        unset( $file );
    }
    
    /**
     * Получить путь к шаблону страницы.
     *
     * @param bool $need_full_path
     *
     * @return string
     */
    public static function get_directory_uri( bool $need_full_path = false ) {
        if ( $need_full_path ) {
            return dirname( __FILE__ ) . '../../../' . DIR_VIEW;
        }
        
        return DIR_VIEW;
    }
    
}