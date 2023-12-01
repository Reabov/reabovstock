<?
/**
* Работа с бд
* 
* @copyright    Copyright (c) 2019, Studio Webmaster, https://www.webmaster.md
* @author       Cusnir Simion
* @version      2.3 Date: 2019-02-22
*/
class CDb
{
	
	var $base;
	var $lang;
	
	function __construct() {
		global $db;
		$this->base = $db;
	}
	
	
	public function setlang($lang)
	{
		$this->lang = $lang;
	}
	
	/*
	 * Первая, примитивная адаптация, заменяет очень неуклюжую контркуцию типа "SELECT title_".$CCpu->lang." AS title FROM xxx" на "SELECT title__ AS title FROM xxx"
	 * */
	private function localize($query)
	{
		$query = str_replace("__", "_".$this->lang, $query);
		return $query;
	}
	
	
	/*
	 * простой заменитель длинной конструкции типа $getSome = mysqli_query($db, "SELECT ... ");
	 * */
	public function q($query)
	{
		return mysqli_query($this->base, $this->localize($query), MYSQLI_STORE_RESULT);
	}
	
	public function add($query)
	{
		mysqli_query($this->base, $this->localize($query), MYSQLI_STORE_RESULT);
		return mysqli_insert_id($this->base);
	}
	
	public function getall($query, $params = array())
	{
		$result = array();
		$getResult = mysqli_query($this->base, $this->localize($query), MYSQLI_STORE_RESULT);
		while ($row = mysqli_fetch_assoc($getResult)) {
			$result[]=$row;
		}
		return $result;
	}
	
	
	/*
	 * Возвращает простой массив ключ-значение
	 * */
	public function getpair($query, $field, $key = "id")
	{
		$result = array();
		$getResult = mysqli_query($this->base, $this->localize($query), MYSQLI_STORE_RESULT);
		while ($row = mysqli_fetch_assoc($getResult)) {
			if( isset($row[$field]) ){
				$result[$row[$key]] = $row[$field];
			}
		}
		return $result;
	}
	
	
	/*
	 * Возвращает одну запись
	 * */
	public function getone($query)
	{
		$result = mysqli_query($this->base, $this->localize($query), MYSQLI_STORE_RESULT);
		if( mysqli_num_rows($result) > 0 ){
			return mysqli_fetch_assoc($result);
		}else{
			return NULL;
		}
		
	}
	
	
	/*
	 * Возвращает id
	 * */
	public function getid($query)
	{
		$getRresult = mysqli_query($this->base, $this->localize($query), MYSQLI_STORE_RESULT);
		$result = mysqli_fetch_assoc($getRresult);
		return $result['id'];
	}
	
	
	/*
	 * Получаем простой массив со значением одного поля
	 * */
	public function getfield($query,$key)
	{
		$result = array();
		$getResult = mysqli_query($this->base, $this->localize($query), MYSQLI_STORE_RESULT);
		while ($row = mysqli_fetch_assoc($getResult)) {
			if( isset($row[$key]) ){
				$result[]=$row[$key];
			}
		}
		return $result;
	}
	
	
	
	
}