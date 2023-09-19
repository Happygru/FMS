<?php

namespace App\Helpers;

class InstalledFileManager
{

    public function create()
    {
        file_put_contents(storage_path('installed'), 'version6.4');
    }

    public function update()
    {
        return $this->create();
    }
}
