<?php
/**
 * Passbolt ~ Open source password manager for teams
 * Copyright (c) Passbolt SA (https://www.passbolt.com)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Passbolt SA (https://www.passbolt.com)
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://www.passbolt.com Passbolt(tm)
 */
use Cake\Core\Configure;

$this->assign('title', $title);
$version = Configure::read('passbolt.version');
$themePath = "themes/$theme/api_main.min.css?v=$version";
$this->Html->css($themePath, ['block' => 'css', 'fullBase' => true, 'id' => 'js_css_theme']);

// See. fetch('scriptBottom')
$this->start('scriptBottom');
// Load the javascript application.
echo $this->Html->script('/js/app/api-vendors.js?v=' . Configure::read('passbolt.version'), ['fullBase' => true, 'cache-version' => Configure::read('passbolt.version')]);
echo $this->Html->script('/js/app/api-app.js?v=' . Configure::read('passbolt.version'), ['fullBase' => true, 'cache-version' => Configure::read('passbolt.version')]);
$this->end();
echo $this->element('Loader/skeleton');
?>
