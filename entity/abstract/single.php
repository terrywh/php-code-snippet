<?php

class entity_abstract_single implements ArrayAccess, JsonSerializable {
    /**
     * 公开数据成员，以便进行新增字段等操作
     */
    public $data;
    function __construct($data) {
        $this->data = $data;
    }
    function jsonSerialize() {
        return $this->data;
    }
    function __isset($key) {
        return isset($this->data[$key]);
    }
    function offsetExists($key) {
        return isset($this->data[$key]);
    }
    function __unset($key) {
        unset($this->data[$key]);
    }
    function offsetUnset($key) {
        unset($this->data[$key]);
    }
    function __get($key) {
        return $this->data[$key];
    }
    function offsetGet($key) {
        return $this->data[$key];
    }
    function __set($key, $val) {
        $this->data[$key] = $val;
    }
    function offsetSet($key, $val) {
        $this->data[$key] = $val;
    }

    function update($modify) {
        $this->data = array_merge($this->data, $modify);
        return true;
    }
}
