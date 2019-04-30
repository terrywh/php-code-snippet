<?php

class entity_abstract_collection implements JsonSerializable, Countable, ArrayAccess, Iterator {
    // 公开数据成员，以方便使用 array_* 相关函数
    public $data;
    private $idx;

    function __construct(array $data) {
        $this->data = $data;
        $this->idx  = 0;
    }

    function jsonSerialize() {
        return $this->data;
    }

    function count() {
        return count($this->data);
    }

    function offsetExists($offset) {
        assert(is_integer($offset));
        return isset($this->data[$offset]);
    }

    function offsetGet($offset) {
        assert(is_integer($offset));
        return $this->data[$offset];
    }

    function offsetSet($offset, $value) {
        assert(is_integer($offset));
        $this->data[$offset] = $value;
    }

    function offsetUnset($offset) {
        assert(is_integer($offset));
        array_splice($this->data, $offset, 1);
        if($offset <= $this->idx) {
            --$this->idx; // 删除元素导致位置变更
        }
    }

    function rewind() {
        $this->idx = 0;
    }

    function current() {
        return $this->data[$this->idx];
    }

    function key() {
        return $this->idx;
    }

    function next() {
        ++$this->idx;
    }

    function valid() {
        return isset($this->data[$this->idx]);
    }
}
