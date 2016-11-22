#!/usr/bin/php
<?php
for ($index = 0; $index <= 202; $index++){
    $relativePath = './'.$index.'.html'; //要执行其它目录下的转码,待转码文件特征
    $fileAbsPath = realpath($relativePath);
    $strFileContents = file_get_contents($fileAbsPath, true);
    $strFileContents = iconv("GB2312", "UTF-8", $strFileContents); //转码的参数细节在这里配置
    file_put_contents($fileAbsPath, $strFileContents);
}
