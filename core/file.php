<?php 
class file{
    function newName($path, $fileName) {
        while(file_exists($path.$fileName)) {
            $fileName ='n'.$fileName;
        }
        return $fileName;
    }
    function moveNew($path, $fileName) {
        while(file_exists($path.$fileName)) {
            $fileName ='n'.$fileName;
        }
        return $path.$fileName;
    }
    function del_file($path) {
        unlink($path);
    }
}
?>