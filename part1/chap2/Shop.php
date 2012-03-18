<?php
class Shop implements IteratorAggregate, ArrayAccess, Countable {
  protected $items;
  function __construct($items) {  $this->items = $items; }
  function count() { return count($this->items); }

  function getIterator() {
    return new ArrayIterator($this);
  }

  function offsetExists($key) {
    return array_key_exists($key, $this->items);
  }

  function offsetGet($key){
    if (array_key_exists($key, $this->items)) {
      return $this->items[$key];
    }
  }

  function offsetSet($key, $value){
    if (array_key_exists($key, $this->items)) {
      $this->items[$key] = $value;
    }
  }

  function offsetUnSet($key){
    if (array_key_exists($key, $this->items)) {
      unset($this->items[$key]);
    }
  }  
}
?>
