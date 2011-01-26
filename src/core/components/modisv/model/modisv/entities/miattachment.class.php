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

    public function createNew($file, $message) {
        if (!isset($file['content']) && !file_exists($file['tmp_name']))
            return false;
        if (!$message || !$message->get('id'))
            return false;
        $ticket = $message->getOne('Ticket');
        if (!$ticket || !$ticket->get('id'))
            return false;

        // sanitize name
        $name = preg_replace("/[^A-Za-z0-9_\.]/", "", str_replace(array(" ", ".."), "_", $file['name']));

        // create attchement directory
        $attachmentsDir = miUtilities::joinPaths($this->xpdo->getOption('modisv.ticket_attachments_dir', null, 'assets/tickets'), $ticket->get('id')) . '/';
        if (!miUtilities::createDirectory($attachmentsDir)) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] Failed to create directory for ticket #{$ticket->get('id')}.");
            return false;
        }

        // get new path
        do {
            $newFilename = strtolower(miUtilities::generateRandomId());
            $newPath = miUtilities::joinPaths(MODX_BASE_PATH, $attachmentsDir, $newFilename);
        } while (file_exists($newPath));

        // create/move file
        if (isset($file['content'])) {
            if (!miUtilities::createFile($newPath, $file['content'])) {
                return false;
            }
        } else {
            if (!@move_uploaded_file($file['tmp_name'], $newPath)) {
                return false;
            }
        }

        // create attachment
        $this->set('size', $file['size']);
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
