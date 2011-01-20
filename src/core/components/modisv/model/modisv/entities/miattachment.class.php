<?php

/**
 * @package modisv
 */
class miAttachment extends xPDOSimpleObject {

    public function save($cacheFlag = null) {
        $this->set('updatedon', time());
        if ($this->isNew()) {
            $this->set('createdon', time());
        }

        return parent::save($cacheFlag);
    }

    public function remove(array $ancestors = array()) {
        $path = $this->get('path');
        $removed = parent::remove($ancestors);

        if ($removed) {
            // remove file
            miUtilities::removeFile($path);
        }

        return $removed;
    }

    public function getFileName() {
        return $this->get('name');
    }

    public function getUrl() {
        $ticket = $this->getOne('Ticket');
        $url = $ticket->getUrl() . '&file=' . $this->get('id');
        return $url;
    }

    public function getFullPath() {
        return MODX_BASE_PATH . $this->get('path');
    }

    public function fromFile($path, $message, $name = null, $size = null) {
        if (!file_exists($path))
            return false;
        if (!$message || !$message->get('id'))
            return false;
        $ticket = $message->getOne('Ticket');
        if (!$ticket || !$ticket->get('id'))
            return false;

        if ($name === null)
            $name = basename($path);
        if ($size === null)
            $size = @filesize($path);

        // sanitize name
        $name = ereg_replace("[^A-Za-z0-9_\.]", "", str_replace(" ", "_", $name));

        // create attchement directory
        $attachmentsDir = miUtilities::joinPaths($this->xpdo->getOption('modisv.ticket_attachments_dir', null, 'assets/tickets'), $ticket->get('id')) . '/';
        if (!miUtilities::createDirectory($attachmentsDir)) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] Invalid directory for ticket #{$ticket->get('id')}.");
            return false;
        }

        // move file
        $newFilename = strtolower(miUtilities::generateRandomId()) . '_' . miUtilities::sanitizePath($name);
        $newPath = miUtilities::joinPaths(MODX_BASE_PATH, $attachmentsDir, $newFilename);
        if (is_uploaded_file($path)) {
            if (!@move_uploaded_file($path, $newPath)) {
                return false;
            }
        } else {
            if (!rename($path, $newPath)) {
                return false;
            }
        }

        // create attachment
        $this->set('size', $size);
        $this->set('name', $name);
        $this->set('path', $attachmentsDir . $newFilename);
        $this->set('message', $message->get('id'));
        $this->set('ticket', $ticket->get('id'));

        return true;
    }

    public function toArray($keyPrefix= '', $rawValues= false, $excludeLazy= false) {
        $result = parent::toArray($keyPrefix, $rawValues, $excludeLazy);

        // extra fields
        $result[$keyPrefix . 'url'] = $this->getUrl();

        return $result;
    }

}
