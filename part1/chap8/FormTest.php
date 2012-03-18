<?php
require_once 'phpwebdriver/WebDriver.php';

class FormTest extends PHPUnit_Framework_TestCase {
  protected $driver;

  protected function setUp() {
	$this->driver = new WebDriver("localhost", 4444);
	$this->connect("firefox"); // Firefoxブラウザを選択
  } 

  protected function tearDown() {
    $this->close(); // 接続を閉じる
  }

  public function __call($name, $arguments) { 
      // オブジェクトのメソッドとしてコール
    if (method_exists($this->driver, $name)) {
      return call_user_func_array(array($this->driver, $name), $arguments);
    }
  }

  public function testAdd() {
    $this->get("http://localhost/part1/chap8/form.php"); 
        // テスト対象をロード
    $this->findElementBy(LocatorStrategy::name, "x_val")->sendKeys(
        array("1"));
    $this->findElementBy(LocatorStrategy::name, "y_val")->sendKeys(
        array("2"));
    $this->findElementBy(LocatorStrategy::id, "submit")->submit(); // 投稿
    $result1 = $this->findElementBy(LocatorStrategy::id, "result1");
    $this->assertEquals("3", $result1->getText()); // 値を確認
  }
}
?>