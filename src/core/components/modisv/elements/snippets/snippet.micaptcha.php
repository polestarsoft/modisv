<?php

// get modISV service
$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, '[[+question]]<input type="text" name="captcha" /><input type="hidden" name="captcha_id" value="[[+id]]" />');
$skipMember = (bool) $modx->getOption('skipMember', $scriptProperties, false);
$promoteCount = (int) $modx->getOption('promoteCount', $scriptProperties, 0);
$maxAttempts = (int) $modx->getOption('maxAttempts', $scriptProperties, 10);
$timeout = (int) $modx->getOption('timeout', $scriptProperties, 60 * 10);
$concurrentLimit = (int) $modx->getOption('timeout', $scriptProperties, 10);

$captchaClass = $modx->loadClass('modisv.miCaptcha', $modisv->config['modelPath'], true, true);
$captcha = new $captchaClass();
$captcha->skipMember = $skipMember;
$captcha->promoteCount = $promoteCount;
$captcha->maxAttempts = $maxAttempts;
$captcha->timeout = $timeout;
$captcha->concurrentLimit = $concurrentLimit;

return $captcha->render($tpl);
