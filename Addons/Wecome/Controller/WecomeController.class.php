<?php

namespace Addons\Wecome\Controller;
use Home\Controller\AddonsController;

class WecomeController extends AddonsController{
	public function demo(){
		/*$user=D('user');
		$where=array(
			'studentid'=>array('gt','311300000000'),
			'id'=>array('eq',rand(1000,9000)),
			);
		$list = $user->where($where)->getField('studentid,IdCard');
		print_r($list);*/
		$Model = M();
		//$query="SELECT * FROM wp_user  WHERE id >= ((SELECT MAX(id) FROM wp_user )-(SELECT MIN(id) FROM wp_user )) * RAND() + (SELECT MIN(id) FROM wp_user )  LIMIT 5";
		$rand=rand(10,9000);
		$data=$Model->query("SELECT studentid,IdCard FROM wp_user WHERE('studentid'>'311300000000' and 'IdCard'!='') ORDER BY RAND() LIMIT 1");
		//echo $Model->getLastSql();
		print_r($data);
	}
        
}
