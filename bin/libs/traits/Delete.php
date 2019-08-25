<?php

namespace traits;

trait Delete {

    private function delete($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $unlink = $dir . DIRECTORY_SEPARATOR . $file;
            (is_dir($unlink)) ? $this->delete_dir($unlink) : unlink($unlink);
        }
        return rmdir($dir);
    }

}
