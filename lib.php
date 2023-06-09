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
 * Main functions are defined here.
 *
 * @package     local_greetings
 * @copyright   2023 Ifraim Solomonov <solomonov@sfedu.ru>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// 1. Запрет на прямой доступ.
defined('MOODLE_INTERNAL') || die();

/**
 * Determines the user's country and returns a string in the corresponding language.
 *
 * @param \stdClass $user
 * @return string
 */
function local_greetings_get_greeting($user) {
    // 2.1 Если юзер не залогинился, возвращаем соответствующую строку.
    if ($user == null) {
        return get_string('greetinguser', 'local_greetings');
    }

    // 2.2 Выясняем страну юзера
    $country = $user->country;

    // 2.3 Перебираем в свиче
    switch ($country) {
        case 'AU':
            $langstr = 'greetingloggedinuserau';
            break;
        case 'ES':
            $langstr = 'greetingloggedinuseres';
            break;
        case 'FJ':
            $langstr = 'greetingloggedinuserfj';
            break;
        case 'NZ':
            $langstr = 'greetingloggedinusernz';
            break;
        case 'RU':
            $langstr = 'greetingloggedinuserru';
            break;
        default:
            $langstr = 'greetingloggedinuser';
            break;
    }

    return get_string($langstr, 'local_greetings', fullname($user));
}

/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
function local_greetings_extend_navigation_frontpage(navigation_node $frontpage) {
    if (isloggedin() && !isguestuser() && get_config('local_greetings', 'showinnavigation')) {
        $frontpage->add(
        get_string('pluginname', 'local_greetings'),
        new moodle_url('/local/greetings/index.php'),
        navigation_node::TYPE_CUSTOM,
        null,
        null,
        new pix_icon('t/message', '')
        );
    }
}

/**
 * Insert a link to index.php on the navigation drawer.
 *
 * @param global_navigation $root
 */
function local_greetings_extend_navigation(global_navigation $root) {
    if (isloggedin() && !isguestuser()) {
        $node = navigation_node::create(
            get_string('pluginname', 'local_greetings'),
            new moodle_url('/local/greetings/index.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            null,
            new pix_icon('t/message', '')
        );

        $node->showinflatnavigation = get_config('local_greetings', 'showinnavigation');
        $root->add_node($node);
    }
}
