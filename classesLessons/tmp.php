<?php
echo 123;
class Product
{
    public $name;
    public $price;
    // private только внутри класса. наследлование запрещено
    // protected внутри класса и его дочерних элементов

    public function __construct() {

    }
    public function SetName($name) {
        $this->name = $name;
        return;
    }

    public function GetName() {
        return$this->name;
    }
}

$pr = new Product('gfvdsfgs', 122);
$pr->SetName('Ipone');
print $pr->GetName();

TODO:
// загрузить excel-файл в БД, создать класс message для отдельного вывода информации о загруженных строках, а также чтобы он обрабатывал ошибки

// создать класс для покдлючения к БД, в котором будут обрабатываться ошибки и в который будет улетать массив с CSV-данными из файла

// все это оформить в сайт с input-ом, в который будут улетать excel файлы
?>