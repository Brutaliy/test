<?php

use StaticFunctions as f;

class ArrDouble {

    private $_arr1;
    private $_arr2;
    private $_arr_result;
    private $_pointer1;
    private $_pointer2;
    private $_diff_key;
    private $_unique_value;
    private $_switch_value;

    public function __construct($arr1, $arr2) {
        $this->_arr1 = $arr1;
        $this->_arr2 = $arr2;
        $this->reset_arrays();
    }

    public function set_arr1($arr1) {
        $this->_arr1 = $arr1;
    }

    public function set_arr2($arr2) {
        $this->_arr2 = $arr2;
    }

    public function set_diff_key($diff_key) {
        $this->_diff_key = $diff_key;
    }

    public function set_unique_value($unique_value) {
        $this->_unique_value = $unique_value;
    }

    public function set_switch_value($switch_value) {
        $this->_switch_value = $switch_value;
    }

    private function reset_arrays() {
        reset($this->_arr1);
        reset($this->_arr2);
        $this->_pointer1 = key($this->_arr1);
        $this->_pointer2 = key($this->_arr2);
    }

    public function dump_arrays() {
        f::dump($this->_arr1);
        f::dump($this->_arr2);
    }

    public function dump_result() {
        f::dump($this->_arr_result);
    }

    public function key_value($mode) {
        $this->reset_arrays();
        switch ($mode) {
            case 'set':
            case 'unset':
                $this->_arr1 = $this->new_key_value($this->_arr1, $this->_pointer1, $this->_diff_key, $this->_unique_value, $mode);
                $this->_arr2 = $this->new_key_value($this->_arr2, $this->_pointer2, $this->_diff_key, $this->_unique_value, $mode);
                break;
            case 'remove':
                $this->_arr1 = $this->new_key_value($this->_arr1, $this->_pointer1, $this->_diff_key, $this->_switch_value, $mode);
                $this->_arr2 = $this->new_key_value($this->_arr2, $this->_pointer2, $this->_diff_key, $this->_switch_value, $mode);
                break;
        }
    }

    public function compare_arrays() {
        $this->reset_arrays();
        list($this->_arr1, $this->_arr2) = $this->switch_key_value($this->_arr1, $this->_arr2, $this->_pointer1, $this->_pointer2, $this->_diff_key, $this->_switch_value);
    }

    public function merge() {
        $this->_arr_result = array_merge($this->_arr1, $this->_arr2);
    }

    private function new_key_value($arr, $key, $new_key, $new_val, $mode) {
        switch ($mode) {
            case 'set':
                $arr[$key][$new_key] = $new_val;
                break;
            case 'unset':
                unset($arr[$key][$new_key]);
                break;
            case 'remove':
                if ($arr[$key][$new_key] === $new_val) {
                    unset($arr[$key]);
                }
                break;
        }
        if (next($arr)) {
            return $this->new_key_value($arr, key($arr), $new_key, $new_val, $mode);
        }
        return $arr;
    }

    private function switch_key_value($arr1, $arr2, $arr1_key, $arr2_key, $diff_key, $switch_value) {
        if ($arr2[$arr2_key][$diff_key] !== $switch_value) {
            if ($arr1[$arr1_key][$diff_key] !== $switch_value) {
                $diff = array_diff($arr1[$arr1_key], $arr2[$arr2_key]);
                if (empty($diff)) {
                    $arr1[$arr1_key][$diff_key] = $switch_value;
                    $arr2[$arr2_key][$diff_key] = $switch_value;
                }
                if (next($arr1)) {
                    return $this->switch_key_value($arr1, $arr2, key($arr1), key($arr2), $diff_key, $switch_value);
                }
            }
            if (next($arr2)) {
                return $this->switch_key_value($arr1, $arr2, key($arr1), key($arr2), $diff_key, $switch_value);
            }
        }
        return array($arr1, $arr2);
    }

}
