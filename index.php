<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Main file to view greetings.
 *
 * @package     local_greetings
 * @copyright   2023 Ifraim Solomonov <solomonov@sfedu.ru>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// 1.1 Требование конфиг файла в корне Moodle.
require_once('../../config.php');
// 1.2 Подключаем новый файл lib.php.
require_once($CFG->dirroot . '/local/greetings/lib.php');
// 1.3 Подключаем форму message_form.php
require_once($CFG->dirroot . '/local/greetings/message_form.php');
// 2. Устанавливаем контекст страницы. В данном случае используется системный контекст.
$context = context_system::instance();
$PAGE->set_context($context);
// 3. Задаем URL страницы.
$PAGE->set_url(new moodle_url('/local/greetings/index.php'));
// 4. Устанавливаем макет страницы. В данном случае используется стандартный макет.
$PAGE->set_pagelayout('standard');
// 5. Устанавливаем название страницы.
$PAGE->set_title($SITE->fullname);
// 6. Устанавливаем заголовок.
$PAGE->set_heading(get_string('pluginname', 'local_greetings'));

// 7. Создание объекта формы.
$messageform = new local_greetings_message_form();
// 8. Вывод HTML.
echo $OUTPUT->header();

if (isloggedin()) {
    echo local_greetings_get_greeting($USER);
} else {
    echo get_string('greetinguser', 'local_greetings');
}

$messageform->display(); // 8.1 Вывод формы.

$message = required_param('message', PARAM_TEXT);
echo $OUTPUT->heading($message, 4);

echo $OUTPUT->footer();
