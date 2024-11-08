<?php

namespace App\Controllers;

class Images extends BaseController
{
    public function get_image(string $image) {

        $filePath = APPPATH . 'Views/components/images/' . $image;

        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        }
        // The image will just return nothing if it doesn't exist
    }
}