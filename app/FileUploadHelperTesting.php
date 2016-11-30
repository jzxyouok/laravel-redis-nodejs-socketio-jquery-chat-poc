<?php

namespace App;

class FileUploadHelperTesting extends FileUploadHelper
{

    public function move_uploaded_file($tmp_path, $path)
    {
        if(!rename($tmp_path, $path))
            return false;

        return true;
    }
}
