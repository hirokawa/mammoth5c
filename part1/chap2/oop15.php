<?php
trait commonAccess {
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}
	public function __get($name) {
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		} else {
			throw new RuntimeException('undefined property: '.$name);
		}
	}
}

class MyShop {
	use commonAccess;
	private $data = ['name'=>'バナナ', 'price'=>100];
}

$obj = new MyShop();
$obj->name = 'りんご';
print_r($obj); // 出力: ['name'=>りんご, 'price'=>100]
?>