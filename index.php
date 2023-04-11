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
// 6.5.1 Требуем от пользователей входа в систему
require_login();

// 6.5.2 Запрещаем доступ гостю
if (isguestuser()) {
    throw new moodle_exception('noguest');
}

// 7. Создание объекта формы.
$messageform = new local_greetings_message_form();

if ($data = $messageform->get_data()) {
    require_capability('local/greetings:postmessages', $context);

    $message = required_param('message', PARAM_TEXT);

    if (!empty($message)) {
        $record = new stdClass;
        $record->message = $message;
        $record->timecreated = time();

        $DB->insert_record('local_greetings_messages', $record);
    }
}

// 8. Вывод HTML.
echo $OUTPUT->header();

if (isloggedin()) {
    echo local_greetings_get_greeting($USER);
} else {
    echo get_string('greetinguser', 'local_greetings');
}

// 9.1 Проверка возможности делать публикации.
$allowpost = has_capability('local/greetings:postmessages', $context);
// 9.2 Проверка возможности смотреть публикации.
$allowview = has_capability('local/greetings:viewmessages', $context);
// 9.2 Проверка возможности удалять любые сообщения.
$deleteanypost = has_capability('local/greetings:deleteanymessage', $context);

$action = optional_param('action', '', PARAM_TEXT);

if ($action == 'del') {
    $id = required_param('id', PARAM_TEXT);

    if ($deleteanypost) {
        $params = array('id' => $id);

        $DB->delete_records('local_greetings_messages', $params);
    }
}

if ($allowpost) {
    $messageform->display();
}

if ($allowview) {
    $userfields = \core_user\fields::for_name()->with_identity($context);
    $userfieldssql = $userfields->get_sql('u');

    $sql = "SELECT m.id, m.message, m.timecreated, m.userid {$userfieldssql->selects}
            FROM {local_greetings_messages} m
        LEFT JOIN {user} u ON u.id = m.userid
        ORDER BY timecreated DESC";

    $messages = $DB->get_records_sql($sql);

    echo $OUTPUT->box_start('card-columns');

    foreach ($messages as $m) {
        echo html_writer::start_tag('div', array('class' => 'card'));
        echo html_writer::start_tag('div', array('class' => 'card-body'));
        echo html_writer::tag('p', format_text($m->message, FORMAT_PLAIN), array('class' => 'card-text'));
        echo html_writer::tag('p', get_string('postedby', 'local_greetings', $m->firstname), array('class' => 'card-text'));
        echo html_writer::start_tag('p', array('class' => 'card-text'));
        echo html_writer::tag('small', userdate($m->timecreated), array('class' => 'card'));
        echo html_writer::end_tag('p');
        echo html_writer::end_tag('div');
        if ($deleteanypost) {
            echo html_writer::start_tag('p', array('class' => 'card-footer text-center'));
            echo html_writer::link(
                new moodle_url(
                    '/local/greetings/index.php',
                    array('action' => 'del', 'id' => $m->id)
                ),
                $OUTPUT->pix_icon('t/delete', '') . get_string('delete')
            );
            echo html_writer::end_tag('p');
        }
        echo html_writer::end_tag('div');
    }

    echo $OUTPUT->box_end();
}

echo $OUTPUT->footer();
