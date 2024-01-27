# About Recursive Locators
This class acts as a recursive file locator.  
You can enter in a list of directories & extensions into compileFiles($directories, $extension) On Doing so, the method shall traverse any and all folders it comes across with valid permissions, then forms a list of all files and there properties for later use in an application.  

## Class Methods
### directoryIterator(string $directory)  
Traverses repeatedly from a specified directory.  
  
### compileFiles (array $directories, array $extensions = ['php'])  
Searches for files with specified file extention types. Files are searched by traversing directories recusrivly.  
Files will be stored on a list once found.  
  
### baseDirectoryFormat(string $directory, object $iterate)  
Makes a base directory lookup the project by removing the subdomain, domain and if it exists the server root directories to the domain, only leaving the project root directory.  
  
### fileSettings(string $directory, object $iterate)  
Creates a list of key information for files being recursivly itterated in order to automatically and automatically locate files.  
