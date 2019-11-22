<?php
/***************** ЗАДАЧА *****************
 * 1. Под каждым инпутом необходимо вывести несколько ошибок
 *    путём расширения и переписания класса Validation
 * 2. Добавить во фронте больше настроек функций
 * 3. Дописать анимацию
 *  3.1 для кнопки advanced
 *  3.2 задний фон
 *  3.3 фокус (по клику и по нажатию клавиши таб)
 */
?>
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
            <h2>Generation Theme</h2>
            <form>
                <div class="form-union-btn">
                    <label for="theme_name"></label>
                    <input id="theme_name" type="text" name="theme_name" placeholder="Input theme name" autocomplete="off">
                    <input type="submit" value="Generate">
                    <div class="center padding-t-10">
                        <a href="javascript:void(0);" class="btn-form-advanced js-show-advanced">Advanced</a>
                    </div>
                </div>
                <div class="box-form-advanced padding-t-10" style="display: none">
                    <label for="theme_uri"></label>
                    <input id="theme_uri" type="url" name="theme_uri" placeholder="Input theme uri" autocomplete="off">
                    <label for="author_name"></label>
                    <input id="author_name" type="text" name="author_name" placeholder="Input author name" autocomplete="off">
                    <label for="author_uri"></label>
                    <input id="author_uri" type="text" name="author_uri" placeholder="Input author uri" autocomplete="off">
                    <div class="overflow-none">
                        <label for="description"></label>
                        <textarea name="description" id="description" cols="30" rows="10" placeholder="Input description..."></textarea>
                    </div>
                    <div class="box-woo">
                        <input class="checkbox" id="checkbox1" type="checkbox" name="woo">
                        <label for="checkbox1" class="checkbox-label">
                            <span class="on">Enable Woo</span>
                            <span class="off">Disable Woo</span>
                        </label>
                    </div>

                </div>
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