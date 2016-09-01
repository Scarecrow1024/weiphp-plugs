<?php

namespace Addons\Weather\Model;

use Home\Model\WeixinModel;

/**
 * Weather的微信模型
 */
class WeixinAddonModel extends WeixinModel {
	function reply() {
		$url="http://apix.sinaapp.com/weather/?appkey=aithinking&city=焦作";
		$weatherArray=$this->httpCurl($url);
		$weatherArray[6]=array(
                'Title' => '默认显示焦作天气预报,回复【天气城市名】查询其它城市如：天气淮北',
            );
		$this->replyNews($weatherArray);
	}

	function httpCurl($url,$data = null)
		{
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			if(!empty($data))
			{
				curl_setopt($ch,CURLOPT_POST,1);//模拟POST
				curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//POST内容
			}
			$outopt = curl_exec($ch);
			curl_close($ch);
			$outoptArr = json_decode($outopt,true);
			if(is_array($outoptArr))
			{
				return $outoptArr;
			}
			else
			{
				return $outopt;
			}
		}
	
	// 关注公众号事件
	public function subscribe() {
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
        	