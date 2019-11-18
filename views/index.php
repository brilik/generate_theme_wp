<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>iBryl | Generate WP Theme</title>
    <link rel="stylesheet" href="<?= Project\Methods::get_directory_uri(); ?>css/style.css">
</head>
<body>
<div id="app">
    <header></header>
    <main>
        <div class="form form-generate">
            <form>
                <label for="theme_name"></label>
                <input id="theme_name" type="text" name="theme_name" placeholder="Input theme name" autocomplete="off">
                <input type="submit" value="Generate">
            </form>
            <div id="success"></div>
        </div>
    </main>
    <aside></aside>
    <footer></footer>
</div>
<script src="<?= Project\Methods::get_directory_uri(); ?>js/custom.js"></script>
</body>
</html>