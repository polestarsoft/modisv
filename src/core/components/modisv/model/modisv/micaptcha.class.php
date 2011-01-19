<?php

/**
 * modISV
 *
 * Copyright 2010 by Weqiang Wang <wenqiang@polestarsoft.com>
 *
 * modISV is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * modISV is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * modISV; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package modisv
 */

/**
 * A class that has static utilities functions.
 *
 * @package modisv
 */
class miCaptcha {

    private $captcha = null;
    private $qas = null;
    private $modx;
    public $skipMember = false;     // whether to use captcha for authenticated members
    public $promoteCount = 0;       // the number of correct answers after which the user will be prompted (thus no captcha any more)
    public $maxAttempts = 10;       // the number of wrong answers after which the user will be limited
    public $timeout = 600;          // time out of a captcha session, in default 10 minutes
    public $concurrentLimit = 10;   // max concurrent captcha sessions allowed for a user

    public function __construct($qas = '') {
        // get the modx
        global $modx;
        $this->modx = $modx;

        // get the questions and answers
        if (empty($qas)) {
            $qas = $this->modx->getOption('modisv.captcha_qas');
        }

        $this->qas = array();
        foreach (explode("\n", $qas) as $line) {
            // entry format: Question? Answer1,Answer2,etc
            $pos = strpos($line, '?');
            if ($pos === false)
                continue;
            $part1 = substr($line, 0, $pos + 1);
            $part2 = substr($line, $pos + 1) ? : '';
            $this->qas[trim($part1)] = array_map('trim', explode(',', strtolower($part2)));
        }
        if (empty($this->qas)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, "[modISV] No captcha questions & answers specified.");
        }

        // get the captcha
        $this->captcha = & $_SESSION['modisv.captcha'];
        if (!is_array($this->captcha) || empty($this->captcha)) {
            $this->captcha = array(
                'successes' => 0,
                'errors' => 0,
                'answers' => array());
            $_SESSION['modisv.captcha'] = & $this->captcha;
        }

        // clear expired captcha
        foreach ($this->captcha['answers'] as $ts => $a) {
            if (time() > $ts + $this->timeout)
                unset($this->captcha['answers'][$ts]);
        }

        // limit concurrent captcha count
        if (count($this->captcha['answers']) > $this->concurrentLimit) {
            $this->captcha['answers'] = array_slice($this->captcha['answers'], -$this->concurrentLimit, $this->concurrentLimit, true);
        }
    }

    public function render($tpl = '[[+question]]<input type="text" name="captcha" /><input type="hidden" name="captcha_id" value="[[+id]]" />') {
        if ($this->skipMember && $this->modx->user->isAuthenticated($this->modx->context->get('key')))   // skip memebers
            return '';
        if ($this->promoteCount && $this->promoteCount <= $this->captcha['successes']) // skip if validated for enough times
            return '';

        // get a random question
        $questions = array_keys($this->qas);
        $question = $questions[mt_rand(0, count($questions) - 1)];

        // generate the session id
        $ts = time();
        while (array_key_exists($ts, $this->captcha['answers']))
            $ts++;
        $this->captcha['answers'][$ts] = $this->qas[$question];
        return str_replace(array('[[+question]]', '[[+id]]'), array($question, $ts), $tpl);
    }

    public function validate($id, $answer, &$errorMsg) {
        if ($this->skipMember && $this->modx->user->isAuthenticated($this->modx->context->get('key')))   // skip memebers
            return true;
        if ($this->promoteCount && $this->captcha['successes'] >= $this->promoteCount) // skip if validated for enough times
            return true;
        if ($this->maxAttempts && $this->captcha['errors'] >= $this->maxAttempts) { // max attemps reached
            $errorMsg = 'Maximum number of attempts reached';
            return false;
        }

        if (empty($answer)) {
            $errorMsg = 'Answer is required';
            return false;
        } else if (!array_key_exists($id, $this->captcha['answers'])) {
            $errorMsg = 'The validation has expired.';
            return false;
        } else if (in_array(strtolower(trim($answer)), $this->captcha['answers'][$id])) {
            $this->captcha['successes']++;
            $this->captcha['errors'] = 0;
            unset($this->captcha['answers'][$id]);
            return true;
        } else {
            $this->captcha['errors']++;
            $errorMsg = 'Incorrect answer';
            return false;
        }
    }

}

?>
