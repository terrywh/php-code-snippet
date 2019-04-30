<?php

class utility_loader {
    private $dmax;
    private $rcur;
    private $init;
    /**
     * 创建加载器，可选的递归、层数、初始化限制；
     */
    function __construct($r = false, $d = 3, $i = true) {
        $this->dmax = $d;
        $this->rcur = $r;
        $this->init = $i;
    }

    private function load_dir($path, $prefix, $depth = 0) {
        if($depth >= $this->dmax) return;
        $dir = opendir($path);
        while($file = readdir($dir)) {
            if($file[0] == ".") {
                // 忽略 . 开头的文件
            }
            else if(is_dir($path . "/" . $file)) {
                if($this->rcur) $this->load_dir($path . "/" . $file, $prefix . "_" . $file);
            }
            else if (substr($file, -4) == ".php") {
                require($path ."/" . $file);
                if($this->init) $this->init_file($prefix, $file);
            }
        }
    }
    // 以指定前缀（类名）加载对应路径下的文件
    function load($path, $prefix = null) {
        $path = rtrim($path, "/");
        if($prefix == null) {
            $prefix = explode("/", $path);
            $prefix = array_pop($prefix);
        }
        $this->load_dir($path, $prefix);
    }

    private function init_file($prefix, $file) {
        $name = $prefix . "_" . substr($file, 0, -4);
        $xins = new $name();
        if(property_exists($xins, "_us_")) $name::$_us_ = $xins;
        $xins->init();
    }
}
