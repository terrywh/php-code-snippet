<?php

class utility_extractor {
    // 常用数据解析流程
    static function object($format, $data, $prefix = "", $suffix = "") {
        $rv = [];
        foreach($format as $key=>$type) {
            $val = $data[$prefix.$key.$suffix] ?? null;
            switch($type) {
            case "integer":
                $rv[$key] = @intval($val);
                break;
            case "string":
                $rv[$key] = $val ?: "";
                break;
            case "boolean":
                $rv[$key] = filter_var($val, FILTER_VALIDATE_BOOLEAN);
                break;
            case "timestamp":
                $rv[$key] = @intval($val);
                break;
            case "timestamp@flame\mongodb\date_time":
                $val = @intval($val) * 1000;
                $rv[$key] = new flame\mongodb\date_time($val);
                break;
            case "timestamp_ms@flame\mongodb\date_time":
                $val = @intval($val);
                $rv[$key] = new flame\mongodb\date_time($val);
                break;
            case "timestamp@DateTime":
                $val = @intval($val);
                $rv[$key] = new DateTime("@".$val);
                break;
            case "object_id":
            case "flame\mongodb\object_id":
                $rv[$key] = new flame\mongodb\object_id($val);
                break;
            default:
                $rv[$key] = null;
            }
        }
        return $rv;
    }

    // 列数据提取
    static function column($rows, $key) {
        $data = [];
        foreach($rows as $row) {
            if(is_object($row) && isset($row->$key)) {
                array_push($data, $row->$key);
            }else if(is_array($row) && isset($row[$key])) {
                array_push($data, $row[$key]);
            }
        }
        return $data;
    }

}
