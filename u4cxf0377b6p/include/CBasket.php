<?
/**
* Работа с корзиной
*/

class Basket
{
    var $dbTable = "ws_basket";
    
    function __construct() {
        global $Db;
        $this->Db = $Db;
    }
    
    
    /**
     * Добавление в корзину
     * @param $user - идентификатор пользователя
     * @param $productId - 
     * @param $qty - 
     * */
    public function add( $user, $productId, $qty = 1 )
    { 
        $getIfExist = $this->Db->q("SELECT id FROM ".$this->dbTable." WHERE product_id = ".$productId." AND order_id = 0 AND user = '".$user."' LIMIT 1 ");
        if( mysqli_num_rows($getIfExist) == 0 ){
            $this->Db->q("INSERT INTO ".$this->dbTable." (`user`,`product_id`,`qty`,`date`) VALUES ('".$user."', '".$productId."', ".$qty.", NOW() )");
        }else{
            $this->Db->q("UPDATE ws_basket SET qty = qty + ".$qty." WHERE product_id = ".$productId." AND order_id = 0 AND user = '".$user."' ");
        }
        
        return $this->shortList($user); 
    }
    
    
    /**
     * Удаление из корзины
     * @param $user - идентификатор пользователя
     * @param $rowId - ид записи из таблицы dbTable
     * @param $productId - из продукта
     * */
    public function remove( $user, $rowId, $productId = 0 )
    {
        $condition = " id = ".(int)$rowId." ";
        if($rowId==0 && $productId>0){
            $condition = " product_id = ".$productId." ";
        }
        
        $this->Db->q("DELETE FROM ".$this->dbTable." WHERE ".$condition." AND user = '".$user."' AND order_id = 0 ");
        
        return $this->shortList($user);
    }
    
    
    /**
     * Устанавливает кол-во продукта в корзине
     * @param $user - идентификатор пользователя
     * @param $rowId - ид записи из таблицы dbTable
     * @param $productId - из продукта
     * @param $qty - перечисление, принимающее возможные значения: "+1", "-1", финальное число
     * */
    public function setQty( $user, $qty, $rowId, $productId = 0  )
    {
        $idCondition = " id = ".(int)$rowId." ";
        if($rowId==0 && $productId>0){
            $idCondition = " product_id = ".$productId." ";
        }   
            
        switch ($qty) {
            case '+1':
                $operation = " qty = qty + 1 ";
                break;
            
            case '-1':
                $count = $this->Db->getone("SELECT qty FROM ".$this->dbTable." WHERE ".$condition." AND user = '".$user."' AND order_id = 0 LIMIT 1");
                if($count && $count['qty'] > 1 ){
                    $operation = " qty = qty + 1 ";
                }else{
                    $operation = " qty = qty ";
                }
                break;
            
            default:
                $qt = (int)$qty;
                if($qt<1){
                    $qt = 1;
                }
                $operation = " qty = ".$qt." ";
                break;
        }

        $this->Db->q("UPDATE ".$this->dbTable." SET ".$operation."  WHERE ".$idCondition." AND user = '".$user."' AND order_id = 0 ");
        
        
        return $this->shortList($user);
    }
    
    
    
    /**
     * Возвращает кол-во продуктов в корзине и их общую стоимость
     * @param $user - идентификатор пользователя
     * */
    public function shortList( $user )
    {
        $result = array('count'=>0, 'price'=>0);
        
        $Basket = $this->Db->getall("SELECT * FROM ".$this->dbTable." WHERE user = '".$user."' AND order_id = 0 ");
        foreach ($Basket as $BasketItem) {
            $result['count']++;
            //$result['price']+=($BasketItem['price'] * $BasketItem['qty']);
        }
        
        return $result['count'];
    }
    

    public function totalPrice( $user )
    { 
        $price = 0;    
        $Basket = $this->Db->getall("SELECT * FROM ".$this->dbTable." WHERE user = '".$user."' AND order_id = 0 ");
        foreach ($Basket as $BasketItem) { 
            $price+=($BasketItem['price'] * $BasketItem['qty']);
        } 
        return $price;
    }
    
    
    
    
    
    
}