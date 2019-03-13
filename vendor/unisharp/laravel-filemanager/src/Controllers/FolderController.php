<?php

namespace UniSharp\LaravelFilemanager\Controllers;

use Illuminate\Support\Facades\File;

/**
 * Class FolderController.
 */
class FolderController extends LfmController
{
    /**
     * Get list of folders as json to populate treeview.
     *
     * @return mixed
     */
    public function getFolders()
    {
        $folder_types = [];
        $root_folders = [];
        $user_folders = [];

        $lfm_share_path = [];

        if (parent::allowMultiUser()) {
            $folder_types['user'] = 'root';
        }

        if (parent::allowShareFolder()) {
            $folder_types['share'] = 'shares';
        }

        foreach ($folder_types as $folder_type => $lang_key) {
            $root_folder_path = parent::getRootFolderPath($folder_type);

            $children = parent::getDirectories($root_folder_path);
            usort($children, function ($a, $b) {
                return strcmp($a->name, $b->name);
            });

            array_push($root_folders, (object) [
                'name' => trans('laravel-filemanager::lfm.title-' . $lang_key),
                'path' => parent::getInternalPath($root_folder_path),
                'children' => $children,
                'has_next' => ! ($lang_key == end($folder_types)),
            ]);
        }

        if ($root_folders && !empty($root_folders)) {
            foreach ($root_folders[0]->children as $folder) {
                $user_folders[] = $folder->name;
            }
        }

        return view('laravel-filemanager::tree')
            ->with(compact('root_folders'))
            ->with('directories', $user_folders)
            ->with('dirs', $user_folders)
            ->with('shares', $lfm_share_path);
    }

    /**
     * Add a new folder.
     *
     * @return mixed
     */
    public function getAddfolder()
    {
        $folder_name = parent::translateFromUtf8(trim(request('name')));
        $path = parent::getCurrentPath($folder_name);

        if (empty($folder_name)) {
            return parent::error('folder-name');
        }

        if (File::exists($path)) {
            return parent::error('folder-exist');
        }

        if (config('lfm.alphanumeric_directory') && preg_match('/[^\w-]/i', $folder_name)) {
            return parent::error('folder-alnum');
        }

        parent::createFolderByPath($path);
        return parent::$success_response;
    }
}
