<?php
/**
 *  Website: https://grantkellie.dev
 *  Author: Grant Kellie | contact@grantkellie.dev
 *  Created: 02/07/2022
 *  Modified: 28/01/2023 
 *  Version 1.0.0
 *  Copyright 2022 Grant Kellie
 * 
 *  Licence
 *  - You may not alter or remove any copyright or other notice from this file.
 *  - You are free to use and modify this file for non-commercial projects.
 *  - You may not reproduce or distribute any of this file or its contents.
 *  - This file is provided "as is" without warranty or liability of any kind.
 * 
 *  About
 *  This class acts as a recursive file locator.
 *  You can enter in a list of directories & extensions into compileFiles($directories, $extension)
 *  On Doing so, the method shall traverse any and all folders it comes across with valid permissions
 *  then form a list of all files and there properties for later use in an application.
 * 
 *  Class Methods
 *      directoryIterator(string $directory)
 *      - Traverses repeatedly from a specified directory.
 *  
 *      compileFiles (array $directories, array $extensions = ['php'])
 *      - Searches for files with specified file extention types. Files are searched by traversing directories recusrivly.
 *      - Files will be stored on a list once found.
 *  
 *      baseDirectoryFormat(string $directory, object $iterate)
 *      - Makes a base directory lookup the project by removing the subdomain, domain and  
 *      - if it exists the server root directories to the domain, only leaving the project root directory.
 *      
 *      fileSettings(string $directory, object $iterate)
 *      - Creates a list of key information for files being recursivly itterated in order to 
 *      - automatically and automatically locate files.
 * 
 */
namespace Theme\Photonyx;

use DirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class CascadeRecursiveFileLocator {

    /**
     * @method directoryIterator
     * Traverses repeatedly from a specified directory.
     * @param string $directory 
     * @return Class
     */
    public function directoryIterator(string $directory){
        $directoryIterate = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
        return new RecursiveIteratorIterator($directoryIterate);       
    }

    /**
     * @method compileFiles
     * Searches for files with specified file extention types.
     * Files are searched by traversing directories recusrivly.
     * Files will be stored on a list once found.
     * @param String_or_Array $directories
     * @param Array $extentions
     * @return Array $files : file settings
     */  
    public function compileFiles(array $directories, array $extensions = ['php']){
        foreach ($directories as $directory){
            if (is_dir($directory)){
                $iterate = $this->directoryIterator($directory);
                $iterate->rewind();
                
                $files = [];
                while($iterate->valid()) {
                    if (in_array($iterate->getExtension(), $extensions)){                          
                        if (is_file($iterate->key())){                                                       
                            $settings = $this->fileSettings($directory, $iterate);
                            array_push($files, $settings);                                                
                        }
                    } $iterate->next();                                        
                }  
            }
        }     
        
        return $files;
    }
 
    /**
     * @method baseDirectoryFormat
     * Makes a base directory lookup for the project by removing the 
     * subdomain, domain and if it exists the server root directories
     * to the domain, only leaving the project root directory.
     * 
     * @before
     * - dev.example.com/wp-content/themes/photonyx/assets/scripts/css/
     * - /var/www/html/.projects/example.com/dev.example.com/wp-content/themes/photonyx/assets/scripts/css/
     * 
     * @after
     * - /wp-content/themes/photonyx/assets/scripts/css
     * 
     * @param String $directory
     * @param Object $iterate
     * @return Array
     */
    public function baseDirectoryFormat(string $directory, object $iterate){
        preg_match_all('/^(?:\S+\.\S+?\/|\/)?(\S+)$/', $directory, $base_directory);
        return '/'.strstr($iterate->getPath(),$base_directory[1][0]);
    }

    /**
     * @method fileSettings
     * Creates a list of key information for files being
     * recursivly itterated in order to automatically and 
     * automatically locate files.
     * @param String $directory
     * @param Object $iterate
     * @return Array
     */
    public function fileSettings(string $directory, object $iterate){
        $directory = $this->baseDirectoryFormat($directory, $iterate);  
        return [
            'filename' => pathinfo($iterate->getFilename(), PATHINFO_FILENAME),
            'directory' => $directory,
            'file' => $iterate->getFilename(),          
            'file_path' => $directory.'/'.$iterate->getFilename(),
            'file_size_bits' => $iterate->getSize() * 8,
            'extension' => pathinfo($iterate->getPath().'/'.$iterate->getFilename(),PATHINFO_EXTENSION),
        ];
    }
}
