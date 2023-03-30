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
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_greetings
 * @copyright   2023 Ifraim Solomonov <solomonov@sfedu.ru>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// 1. Требование конфиг файла в корне Moodle.
require_once('../../config.php');
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

// 7. Вывод HTML.
echo $OUTPUT->header();

if (isloggedin()) {
    echo '<h2>Здарова, '.fullname($USER).'!</h2>';
} else {
    echo '<h2>Здарова, кто бы ты ни был!</h2>';
}

echo $OUTPUT->footer();
