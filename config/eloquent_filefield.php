<?php

return [
    'disk' => app('config')->get('filesystems.default'),
    'path' => 'uploads/:class_slug/:attribute/:unique_id-:file_name',
    'default_path' => 'uploads/default.png'
];