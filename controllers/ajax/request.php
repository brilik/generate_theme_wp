<?php
if ( ! isset( $_POST['theme_name'] ) ) {
    die( 'Чувак, да ты крут :P' );
}

include_once "../generator/Theme.php";
include_once "../validation/Validation.php";

$theme_name = $_POST['theme_name'];
$theme      = new Generator\Theme();
$error      = new Validation();

$error->check( $theme_name, 'text', 4, 15 );

if ( $error->get_error() ) {
    
    if ( is_array( $error->get_error() ) ) {
        $errors['errors'] = [];
        foreach ( $error->get_error() as $err ) {
            $errors['errors'][] = $err;
        }
        echo json_encode($errors);
    } else {
        echo $error->get_error();
    }
    
    return false;
}

echo $theme->generate( array(
    'template_theme_name' => $theme_name,
    'template_theme_uri'  => 'https://github.com/brilik',
    'template_theme_author' => 'Vitalii Bryl',
    'template_theme_description' => 'This is theme best of the best!',
    'template_theme_author_uri' => 'https://iBryl.store/profile/'
) );

unset($theme_name, $theme, $error);
die;