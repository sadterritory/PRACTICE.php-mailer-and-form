<?php
	//namespace app\admin\model;
	///use
	//public, private - доступ только из созданного класса, protected - доступ из класса и его расширений
	// для private, protected надо установить get и set(при необходимости)
	class Product
	{
		private $product_name;
		private $product_price;
		private $product_ean;
		
		/**
			* @param string $product_ean
		*/
		public function setProductEan(string $product_ean)
		{
			$this->product_ean = $product_ean;
		}
		
		/**
			* @param string $product_name
		*/
		public function setProductName(string $product_name)
		{
			$this->product_name = $product_name;
		}
		
		/**
			* @param int $product_price
		*/
		public function setProductPrice(int $product_price)
		{
			$this->product_price = $product_price;
		}
		
		/**
			* @return mixed
		*/
		public function getProductEan()
		{
			return $this->product_ean;
		}
		
		/**
			* @return mixed
		*/
		public function getProductName()
		{
			return $this->product_name;
		}
		
		/**
			* @return mixed
		*/
		public function getProductPrice()
		{
			return $this->product_price;
		}
	}
	class dataBaseConnect {
		private $host;
		
		private $username;
		private $password;
		private $database;
		
		public function __construct($host, $username, $password, $database) {
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
		}
		
		public function connect() {
			$connection = new mysqli($this->host, $this->username, $this->password, $this->database);
			if ($connection->connect_error) {
				die("Ошибка соединения с базой данных: " . $connection->connect_error);
			}
			echo "Соединение с базой данных успешно установлено\n";
			return $connection;
		}
	}
	class ImportCsv{
		private $host;
		
		private $username;
		private $password;
		private $database;
		private $columnArray;
		
		public function __construct($host, $username, $password, $database,$columnArray) {
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
			$this->columnArray = $columnArray;
		}
		
		public function connect() {
			$connection = new mysqli($this->host, $this->username, $this->password, $this->database);
			if ($connection->connect_error) {
				$this->getMessage("Ошибка соединения с базой данных: " . $connection->connect_error);
			}
			// $this->getMessage("Соединение с базой данных успешно установлено\n");
			return $connection;
		}
		
		public function convertToArray($filePath,$columnArray , $delimiter = ';') {
			$dataArray = [];
			$endArray =[];
			if (($handle = fopen($filePath, 'r')) !== false) {
				$head = fgetcsv($handle, 1000, $delimiter);
				while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
					$data = array_combine($head,$row);
					$dataArray[] = $data;
					
				}
				$posName = $columnArray['name'];
				$posPrice = $columnArray['price'];
				$posEan = $columnArray['ean'];
				array_walk($dataArray, function (& $item) use ($posEan, $posPrice, $posName) {
					$item['name'] = $item[$posName];
					$item['price'] = $item[$posPrice];
					$item['ean'] = $item[$posEan];
					unset($item[$posName]);
					unset($item[$posPrice]);
					unset($item[$posEan]);
				});
				print_r($dataArray);
				fclose($handle);
				return $dataArray;
				} else {
				return false;
			}
		}
		
		public function queryInDatabase(){
			$dataArray = $this->convertToArray('test.csv', $this->columnArray);
			foreach ($dataArray as $data ){
				$this->connect()->query("INSERT INTO `test-cass` (`id`, `name`, `price`, `ean`) VALUES (NULL, '{$data['name']}', '{$data['price']}', '{$data['ean']}')");
			}
		}
		// TOD
		public function getMessage($massge){
			var_dump($massge);
		}
	}
	$host = "localhost";
	$username = "sw-stat";
	$password = "jJ2qP0zR6g";
	$database = "sw-stat";
	$columnArray['name'] = 'названия';
	$columnArray['price'] = 'сколько стоит?';
	$columnArray['ean'] = 'уникальный код';
	$connector = new ImportCsv($host, $username, $password, $database, $columnArray);
	$connector->queryInDatabase();
	
?>