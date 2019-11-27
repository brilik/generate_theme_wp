<h1>Генерация валидной темы для WordPress</h1>
<nav class="gtw-generation">
    <h2>Содержание:</h2>
    <ol>
        <li><a href="#use-teg">Используемые теги</a></li>
        <li><a href="#validation">Валидация формы</a></li>
        <li><a href="#plan">План реализации</a></li>
    </ol>
</nav>
<div class="gtw-use-teg" id="use-teg">
    <h4>1. Используемые теги</h4>
    <p>Для изменения шаблона генерируемой темы необходимо знать следующие теги,
     которые будут заменены на текст введенный пользователем в форму:</p> 
    <ol>
    <li>Theme Name: <code>%template_theme_name%</code></li>
    <li>Theme URI: <code>%template_theme_uri%</code></li>
    <li>Author: <code>%template_theme_author%</code></li>
    <li>Author URI: <code>%template_theme_author_uri%</code></li>
    <li>Description: <code>%template_theme_description%</code></li>
    <li>Text Domain: <code>%template_text_domain%</code></li>
    </ol>
    Теги применяются в файлах будущего сгенерированого шаблона по пути: 
    <code>models/template/default</code>.
    <br>
    <br>
    <p>Для расширения тегов, необходимо передать аргументом методу <code>generate($arr)</code> ассоциативный массив с именем тега в ключе в файле по пути: <code>controllers/ajax/request.php</code></p>
</div>
<hr>
<div class="gtw-validation" id="validation">
    <h4>2. Валидация формы</h4>
    <p>Валидация происходит на языке <code>php</code> через <code>ajax</code>
    технологию. Класс валидации описан по пути: 
    <code>controllers/validation/Validation.php</code>.
    Чтобы проверить поле на валидацию, необходимо в файле
    <code>controllers/ajax/request.php</code> обратиться к методу
    <code>
    check(string $str, string $inputType = 'text', int $min = 3, int $max = 15)
    </code>,
    который принимает следующие параметры:</p>
    <ol>
        <li><code>$str</code> - значение с <code>input</code> передаваемый в
        глобальном массиве <code>$_POST</code>;</li>
        <li><code>$inputType</code> - тип тега, от которого зависит способ
        валидации:
            <ul>
                <li><code>text</code>;</li>
                <li><code>checkbox</code>;</li>
                <li><code>url</code>;</li>
                <li><code>description</code>;</li>
            </ul>
        </li>
        <li><code>$min</code> - минимальное число символов;</li>
        <li><code>$max</code> - максимальное число символов.</li>
    </ol>
    и записать в двумерный массив <code>$res['errors']</code> для вывода
    ошибки во фронт.
</div>
<hr>
<div class="gtw-plan" id="plan">
    <h4>3. План реализации</h4>
    <span>В будущем будет реализовано:</span>
    <ul>
    <li>Шаблон для генерации вёрстки для темы</li>
    <li>Шаблон для генерации темы с WooCommerce</li>
    <li>Выбор необходимого функционала для темы, например:
        <ul>
        <li>Отключение лишнего функционала в WordPress</li>
        <li>Возможность заливать svg файлов в WordPress</li>
        <li>Возможность загружать картинку темы</li>
        <li>и т.д. и т.п.</li>
        </ul>
    </li>
    </ul>
</div>