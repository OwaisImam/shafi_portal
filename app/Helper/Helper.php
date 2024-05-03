<?php

namespace App\Helper;

use App\Models\Upload;
use Goutte\Client;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function uploadFile($file): Upload
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('uploads', $fileName, 'public');

        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $extension = $file->getClientOriginalExtension();
        $type = $file->getMimeType();

        return Upload::create([
                 'file_original_name' => $originalName,
                 'file_name' => $fileName,
                 'upload_by' => (auth()->check()) ? auth()->user()->id : null,
                 'file_size' => $fileSize,
                 'extension' => $extension,
                 'type' => $type,
         ]);
    }

    public static function getUploadedFile($fileID)
    {
        $upload = Upload::where('id', $fileID)->first();

        return Storage::url('uploads/' . $upload->getFileName());
    }

    public static function getClientIpAddress()
    {
        $ipAddress = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ip) {
                if (!empty($ip)) {
                    $ipAddress = $ip;
                    break;
                }
            }
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }

        return $ipAddress;
    }

}
