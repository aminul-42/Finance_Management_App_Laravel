<?php
if(isset($_GET['file'])) {
    $file = $_GET['file'];
    $zip = new ZipArchive;
    if ($zip->open($file) === TRUE) {
        $zip->extractTo('./');
        $zip->close();
        echo 'Unzipped Successfully!';
    } else {
        echo 'Failed to Unzip!';
    }
} else {
    echo 'No file specified!';
}
?>
