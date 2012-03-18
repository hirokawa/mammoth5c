<?php
class MyClassLoader {
  protected $ns = null, $path = null;

  public function __construct($ns = null, $path = null) {
    $this->ns = $ns;
    $this->path = $path;
  }
  
  public static function register($ns = null, $path = null) { 
      // ローダを登録
    spl_autoload_register(array(new self($ns, $path), 'load'));
  }

  protected function load($class) {
    if ($this->ns !== null && 
      substr($class,0,strlen($this->ns.'\\')) !== $this->ns.'\\') {
      return; // 指定された名前空間と一致しない場合は読み込まない
    }
    $file = ($this->path !== null) ? $this->path . 
       DIRECTORY_SEPARATOR : null;
    $file .= str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    require_once $file;
  }
}
?>