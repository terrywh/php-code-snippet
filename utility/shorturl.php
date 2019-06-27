<?php

function short_url($url) {
    static $source = [5786724301, 2849184197, 211160679, 202088835];
    $r = flame\http\get("http://api.weibo.com/2/short_url/shorten.json?source=".$source[ array_rand($source) ]."&url_long=".urlencode($url));
    return $r->body["urls"][0]["result"] ? $r->body["urls"][0]["url_short"] : null;
}

flame\go(function() {
var_dump(short_url("http://www.baidu.com/?aaa=bbbbb"));
});

flame\run();
