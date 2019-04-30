<?php
/**
 * 注意：下述配合 loader 的实现不能继承使用
 */
trait utility_singleton {
    static $_us_ = null;
    static function get() {
        // $class_name = get_called_class();
        if (self::$_us_ === null) {
            self::$_us_ = new self();
        }
        return self::$_us_;
    }
}
