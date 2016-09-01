<?php

namespace Addons\Houqin\Model;

use Home\Model\WeixinModel;

/**
 * Houqin的微信模型
 */
class WeixinAddonModel extends WeixinModel {
	function reply() {
		$openid=get_openid();
        $user=M('user');
        //判断是否绑定
        $studentid=$user->where("openid=".'"'.$openid.'"')->getField('studentid');
        if($studentid==0){
        	$this->subscribe();
	        $openid=get_openid();
	        $url=addons_url ('Binding://Binding/login?openid='.$openid);
	        $dataArr[0]=array(
	                'Title' => '绑定',
	                'Description' => '点击图片完成账号绑定',
	                'PicUrl' => 'http://www.pp3.cn/uploads/allimg/120129/1-120129232444.jpg',
	                'Url' => $url
	            );
	        $dataArr[1]=array(
	                'Title' => '你还未绑定账号点击图片完成认证',	                
	            );
			$this->replyNews($dataArr);
        }else{
	        $url=addons_url ('Houqin://Houqin/login?openid='.get_openid());
	        $dataArr[0]=array(
	                'Title' => '绩点查询',
	                'PicUrl' => 'http://us.51edu.com.au/sites/51edu.com.au/files/file/GPA.jpg',
	                'Url' => $url
	            );
	        /*$user=M('user');
	        $openid=get_openid();
	        $url=addons_url ('Binding://Binding/login?openid='.$openid);
	        $card = $user->where("openid=".'"'.$openid.'"')->getField('studentid');*/
	        $this->replyNews($dataArr);
	    }
	}
	
	// 关注公众号事件
	public function subscribe() {
		$user=M('user');
        $openid=get_openid();
        $data['openid']=$openid;
        $data['subscribe_time']=date("Y-m-d H:i",time());
        $is=$user->where("openid=".'"'.$openid.'"')->find();
        if(!$is){
            $user->add($data);
        }      
		return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
		return true;
	}
	
	// 上报地理位置事件
	public function location() {
		return true;
	}
	
	// 自定义菜单事件
	public function click() {
		return true;
	}
}
        	