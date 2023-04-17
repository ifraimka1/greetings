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
 * Plugin strings are defined here.
 *
 * @package     local_greetings
 * @category    string
 * @copyright   2023 Ifraim Solomonov <solomonov@sfedu.ru>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// 1. Название плагина. Отображается администратору.
$string['pluginname'] = 'Greetings';
// 2. Строки для авторизованного и неавторизованного пользователей.
$string['greetinguser'] = 'Hey, dude!';
$string['greetingloggedinuser'] = 'Hey, {$a}!';
// 3. Локализованные приветствия для Австралии, Фиджи, Новой Зеландии, Испании и России.
$string['greetingloggedinuserau'] = 'Hello, {$a}!';
$string['greetingloggedinuseres'] = 'Hola, {$a}!';
$string['greetingloggedinuserfj'] = 'Bula, {$a}!';
$string['greetingloggedinusernz'] = 'Kia Ora, {$a}!';
$string['greetingloggedinuserru'] = 'Здарова, {$a}!';
// 4. Строка для текстового поля формы message_form.
$string['yourmessage'] = 'Your message';
// 5. Строка автора.
$string['postedby'] = 'Posted by {$a}';
$string['postedbyru'] = 'Чирканул {$a}';
// 6. Для возможностей (access.php).
$string['greetings:viewmessages'] = 'View messages on the Greetings wall';
$string['greetings:postmessages'] = 'Post a new message on the Greetings wall';
$string['greetings:deleteanymessage'] = 'Delete any message on the Greetings wall';
$string['greetings:deletemessage'] = 'Delete user\'s message on the Greetings wall';
$string['greetings:editanymessage'] = 'Edit any message on the Greetings wall';
$string['greetings:editmessage'] = 'Edit user\'s message on the Greetings wall';
// 7. Для настроек.
$string['showinnavigation'] = 'Show in navigation';
$string['showinnavigationdesc'] = 'When enabled will show link in navigation';
