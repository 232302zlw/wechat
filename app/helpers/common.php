<?php

    /*文件上传方法*/
    function upload($name)
    {
        if (request()->file($name)->isValid()) {
            $headimg = request()->file($name);
            // $extension = $headimg->extension();
            // $store_result = $headimg->syore('headimg');
            $store_result = $headimg->store('','public');
            return $store_result;
        }
        exit('未上传文件');
    }