<?php

class Clp_Convertor
{
    public function formatBytes($bytes)
    {
        $size = $bytes;
        switch ($bytes) {
            case $bytes < 1024                :
                $size = $bytes . ' B';
                break;
            case $bytes < 1048576            :
                $size = round($bytes / 1024, 2) . ' KB';
                break;
            case $bytes < 1073741824            :
                $size = round($bytes / 1048576, 2) . ' MB';
                break;
            case $bytes < 1099511627776        :
                $size = round($bytes / 1073741824, 2) . ' GB';
                break;
        }
        return $size;
    }
}
