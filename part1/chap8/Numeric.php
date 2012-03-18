<?php
class Numeric {
  /**
   * @assert(1,2) == 3
   */
  public function add($x, $y) {
    return ($x+$y);
  }
  /**
   * @assert(4,2) == 2
   * @assert(6,0) throws RuntimeException
   */
  public function div($x, $y) {
    if ($y == 0) { // ゼロ割防止
      throw new RuntimeException;
    }
    return ($x/$y);
  }
}
?>