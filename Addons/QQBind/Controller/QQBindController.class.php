<?php

namespace Addons\QQBind\Controller;
use Home\Controller\AddonsController;

class QQBindController extends AddonsController{
    //登录vpn获取验证码并且保存cookie设置标记
    public function verify(){
        set_time_limit(0);
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,"https://vpn.hpu.edu.cn/por/login_psw.csp");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $content=curl_exec($ch);
        //正则匹配cookie并使用
        preg_match('/Set-Cookie:(.*);/iU',$content,$str); //正则匹配  
        $session = trim($str[1]); //获得COOKIE（SESSIONID）
        //$arr=explode("=", $session);
        //print_r($arr);
        //setcookie($arr[0],$arr[1]);
        //curl_setopt($ch,CURLOPT_COOKIE,$session);
        curl_close($ch);
        //echo $content."<br>";
        /*
            登陆并设置新的TWFID和ENABLE_RANDCODE获取重定向地址
              
        */
        $arr=array(); 
        $arr[0][]="311408000107";
        $arr[0][]="155506";
        $arr[1][]="311502020328";
        $arr[1][]="202570";
        $arr[2][]="311505000609";
        $arr[2][]="196443";
        $arr[3][]="311405040126";
        $arr[3][]="261037";
        $arr[4][]="311413030118";
        $arr[4][]="093815";
        $arr[5][]="311509020427";
        $arr[5][]="190137";
        $arr[6][]="311410040223";
        $arr[6][]="100624";
        $arr[7][]="311503000512";
        $arr[7][]="083715";
        $arr[8][]="311402010418";
        $arr[8][]="030019";
        $arr[9][]="311508071030";
        $arr[9][]="300012";
        $arr[10][]="311503020105";
        $arr[10][]="217724";
        $ran=rand(0,10);
        $ch=curl_init();
        $post="mitm_result=&svpn_name=".$arr[$ran][0]."&svpn_password=".$arr[$ran][1]."&svpn_rand_code="; 
        curl_setopt($ch,CURLOPT_URL,"https://vpn.hpu.edu.cn/por/login_psw.csp?sfrnd=2346912324982305");
        curl_setopt($ch,CURLOPT_REFERER,"https://vpn.hpu.edu.cn/por/login_psw.csp");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0");
        //带上上登陆前的cookie
        curl_setopt($ch,CURLOPT_COOKIE,$session);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $content=curl_exec($ch);
        //正则匹配cookie并使用
        preg_match_all('/Set-Cookie:(.*);/iU',$content,$str1); //正则匹配  
        $session2=trim($str1[1][0]);
        $session3=trim($str1[1][1]);
        curl_setopt($ch, CURLOPT_COOKIE, "$session2;$session3");
        $arr3=explode("=", $session3);
        $arr2=explode("=", $session2);
        curl_close($ch);
        //登录教务处
        $ch=curl_init();
        set_time_limit(0);
        $url="https://vpn.hpu.edu.cn/web/1/http/0/218.196.240.97/";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_REFERER,"https://vpn.hpu.edu.cn/por/login_psw.csp");
        curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0");
        //curl_setopt($ch,CURLOPT_COOKIEFILE, $sessionFile);
        //使用vpn登陆后的cookie
        curl_setopt($ch,CURLOPT_COOKIE,"$session2;$session3"); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $content=curl_exec($ch);
        //正则匹配教务处登陆时设置的cookie
        preg_match('/Set-Cookie:(.*);/iU',$content,$str); //正则匹配  
        $session4 = trim($str[1]); //获得COOKIE（SESSIONID）
        $arr4=explode("=", $session4);
        //global $arr4; 
        //curl_setopt($ch, CURLOPT_COOKIE, $session4);
        //setcookie($arr4[0],$arr4[1]);
        curl_close($ch);

        //获取验证码
        $ch=curl_init();
        $url="https://vpn.hpu.edu.cn/web/1/http/1/218.196.240.97/validateCodeAction.do";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_REFERER,"https://vpn.hpu.edu.cn/por/login_psw.csp");
        curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0");
        curl_setopt($ch,CURLOPT_COOKIE,"$session2;$session3;$session4"); 
        setcookie("isl","1");
        setcookie($arr2[0],$arr2[1]);
        setcookie($arr3[0],$arr3[1]);
        setcookie($arr4[0],$arr4[1]);
        //print_r($_COOKIE);
        //curl_setopt($ch,CURLOPT_COOKIE,$session2); 
        //curl_setopt($ch,CURLOPT_COOKIEFILE,$sessionFile);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $content=curl_exec($ch);
        curl_close($ch);
        echo $content;

    }

    //登录页面
    public function login(){ 
        $this->display();
    }

    // 得到学生个人信息
    function getStudentInfo($mm,$session2,$session3,$session4){
        if(isset($_COOKIE['isl'])){
            $session4="websvr_cookie"."=".$_COOKIE['websvr_cookie'];
            $session2="ENABLE_RANDCODE"."=".$_COOKIE['ENABLE_RANDCODE'];
            $session3="TWFID"."=".$_COOKIE['TWFID'];
        }
        $ch = curl_init ();
        curl_setopt($ch,CURLOPT_URL,"https://vpn.hpu.edu.cn/web/1/http/2/218.196.240.97/xjInfoAction.do?oper=xjxx");
        curl_setopt($ch,CURLOPT_REFERER,"https://vpn.hpu.edu.cn/web/1/http/1/218.196.240.97/loginAction.do");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0");
        curl_setopt($ch,CURLOPT_COOKIE,"$session2;$session3;$session4");
        //curl_setopt($ch, CURLOPT_COOKIEFILE, $sessionFile);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $content=curl_exec($ch);
        curl_close ( $ch );
        $content = iconv("gbk", "utf-8", $content);
        return $content;
      
    }

    public function binding(){
        if(isset($_COOKIE['isl'])){
            $session4="websvr_cookie"."=".$_COOKIE['websvr_cookie'];
            $session2="ENABLE_RANDCODE"."=".$_COOKIE['ENABLE_RANDCODE'];
            $session3="TWFID"."=".$_COOKIE['TWFID'];
        }
        if(isset($_POST['submit'])){
            $openid=$_SESSION['openid'];
            $zjh=$_POST['zjh'];
            $mm=$_POST['mm'];
            $v_yzm=$_POST['v_yzm'];
        }
        $params = array (
            'zjh' => $zjh,
            'mm' => $mm,
            'v_yzm' => $v_yzm 
            ); 
        $ch = curl_init ();
        curl_setopt($ch,CURLOPT_URL,"https://vpn.hpu.edu.cn/web/1/http/1/218.196.240.97/loginAction.do");
        curl_setopt($ch,CURLOPT_REFERER,"https://vpn.hpu.edu.cn/web/1/http/0/218.196.240.97/");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0");
        curl_setopt($ch,CURLOPT_COOKIE,"$session2;$session3;$session4");
        //curl_setopt($ch,CURLOPT_COOKIE,$session1); 
        //curl_setopt($ch,CURLOPT_COOKIE,$session2);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $content=curl_exec($ch);
        curl_close ( $ch );

        $content=$this->getStudentInfo();
        //echo $content;
        $html=new SimpleHtmlController();
        $html->load($content);
        $table=$html->find('table')[5];
        $arr=$this->get_td_array($table);//执行函数
        $data = array(
                "studentid"=>trim($arr[2][2]),
                "password"=>$mm,
                "name"=>trim($arr[2][4]),
                "classId"=>trim($arr[3][55]),
                "IdCard"=>trim($arr[3][7]),
                "high_school"=>trim($arr[3][29]),
                );
        //绑定学生信息
        if(strlen($data['IdCard'])<16){
            $this->error("认证失败，请检查用户名或密码是否正确",U('/addon/QQBind/QQBind/login/'));
        }else{
            $user=M('qqcourselist');
            $openid=$_SESSION['openid'];
            $card = $user->where("openid=".'"'.$openid.'"')->getField('studentid');
            if($card!=0){
                //$name = $user->where("openid=".'"'.$openid.'"')->getField('name');
                $this->error("该账号已经绑定,请勿重复绑定,如需重新绑定请联系客服",'',3);
            }else{
                $courselist=$this->getXuanke2();
                //保存源课表
                $ycouese=$this->getXuanke3();
                //保存历年成绩
                $openid=$_SESSION['openid'];
                $data['courselist']=$courselist;
                $data['ycourse']=$ycouese;
                $data['openid']=$openid;
                $data['nickname']=$_SESSION['nickname'];
                $data['figureurl_1']=$_SESSION['figureurl_1'];
                $data['figureurl_qq_2']=$_SESSION['figureurl_qq_2'];
                $data['gender']=$_SESSION['gender'];
                $bind=$user->add($data);
                if($bind){
                    $this->success($data["name"]."同学绑定成功","http://niool.com/weixin/index.php?s=/addon/QQCourseList/QQCourseList/course.html");
                }     
            }
        } 
    }
    //网页版课表
    function getXuanke2(){
        if(isset($_COOKIE['isl'])){
            $session4="websvr_cookie"."=".$_COOKIE['websvr_cookie'];
            $session2="ENABLE_RANDCODE"."=".$_COOKIE['ENABLE_RANDCODE'];
            $session3="TWFID"."=".$_COOKIE['TWFID'];
        }
        $url="https://vpn.hpu.edu.cn/web/1/http/2/218.196.240.97/xkAction.do?actionType=6";
        //$url = "https://vpn.hpu.edu.cn/web/1/http/2/218.196.240.97/lnkbcxAction.do?zxjxjhh=2015-2016-2-1";
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0");
        curl_setopt($ch,CURLOPT_COOKIE,"$session2;$session3;$session4");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $content = curl_exec ( $ch );
        curl_close ( $ch );
        $content=iconv("gbk", "utf-8", $content);

        $html=new SimpleHtmlController();

        $content=str_replace("一","1",$content);
        $content=str_replace("二","2",$content);
        $content=str_replace("三","3",$content);
        $content=str_replace("四","4",$content);
        $content=str_replace("五","5",$content);
        $content=str_replace("六","6",$content);
        $content=str_replace("七","7",$content);
        $content=str_replace("八","8",$content);
        $content=str_replace("九","9",$content);

        $html->load($content);
        $table=$html->find('table')[7];
        $arr=$this->get_td_array($table);//执行函数
        $con=count($arr);
        //网页版课程表
        $day=array();
        for($i=1;$i<$con;$i++){
            for($d=1;$d<=5;$d++){
                if(count($arr[$i])==72){
                //echo $arr[$i][2].$arr[$i][7]."\n";
                if(trim($arr[$i][66])==$d){
                    //$day[$d][]= "第".trim($arr[$i][12])."节有课:\n".trim($arr[$i][2])."\n".trim($arr[$i][15]).trim($arr[$i][16])."\n".trim($arr[$i][7]).trim($arr[$i][10]);
                    $day[$d][]=array();
                    for($j=1;$j<=9;$j++){
                        if($j==trim($arr[$i][67])){
                            $day[$d][$j]['score'][]=trim($arr[$i][56]);
                            $day[$d][$j]['add'][]=trim($arr[$i][70]).trim($arr[$i][71]);
                            $day[$d][$j]['teacher'][]=trim($arr[$i][61]).trim($arr[$i][65]);
                        }
                        
                    }
                }
                }

                if(count($arr[$i])==54){
                //echo $arr[$i][2].$arr[$i][7]."\n";
                if(trim($arr[$i][48])==$d){
                    //$day[$d][]= "第".trim($arr[$i][12])."节有课:\n".trim($arr[$i][2])."\n".trim($arr[$i][15]).trim($arr[$i][16])."\n".trim($arr[$i][7]).trim($arr[$i][10]);
                    $day[$d][]=array();
                    for($j=1;$j<=9;$j++){
                        if($j==trim($arr[$i][49])){
                            $day[$d][$j]['score'][]=trim($arr[$i][38]);
                            $day[$d][$j]['add'][]=trim($arr[$i][51]).trim($arr[$i][52]);
                            $day[$d][$j]['teacher'][]=trim($arr[$i][43]).trim($arr[$i][47]);
                        }
                        
                    }
                }
                }

                if(count($arr[$i])==36){
                //echo $arr[$i][2].$arr[$i][7]."\n";
                if(trim($arr[$i][30])==$d){
                    //$day[$d][]= "第".trim($arr[$i][12])."节有课:\n".trim($arr[$i][2])."\n".trim($arr[$i][15]).trim($arr[$i][16])."\n".trim($arr[$i][7]).trim($arr[$i][10]);
                    $day[$d][]=array();
                    for($j=1;$j<=9;$j++){
                        if($j==trim($arr[$i][31])){
                            $day[$d][$j]['score'][]=trim($arr[$i][20]);
                            $day[$d][$j]['add'][]=trim($arr[$i][34]).trim($arr[$i][35]);
                            $day[$d][$j]['teacher'][]=trim($arr[$i][25]).trim($arr[$i][29]);
                        }
                        
                    }
                }
                }
                if(count($arr[$i])==18){
                //echo $arr[$i][2].$arr[$i][7]."\n";
                if(trim($arr[$i][12])==$d){
                    //$day[$d][]= "第".trim($arr[$i][12])."节有课:\n".trim($arr[$i][2])."\n".trim($arr[$i][15]).trim($arr[$i][16])."\n".trim($arr[$i][7]).trim($arr[$i][10]);
                    $day[$d][]=array();
                    for($j=1;$j<=9;$j++){
                        if($j==trim($arr[$i][13])){
                            $day[$d][$j]['score'][]=trim($arr[$i][2]);
                            $day[$d][$j]['add'][]=trim($arr[$i][16]).trim($arr[$i][17]);
                            $day[$d][$j]['teacher'][]=trim($arr[$i][7]).trim($arr[$i][11]);
                        }
                        
                    }
                }
                }
                if(count($arr[$i])==7){
                    if(trim($arr[$i][1])==$d){
                        for($j=1;$j<=9;$j++){
                            if($j==trim($arr[$i][2])){
                              if(strlen(trim($arr[$i-1][2]))<2){
                                if(strlen(trim($arr[$i-2][2]))<2){
                                  $day[$d][$j]['score'][]=trim($arr[$i-3][2]);
                                  $day[$d][$j]['teacher'][]=trim($arr[$i-3][7]).trim($arr[$i][0]);
                                }else{
                                  $day[$d][$j]['score'][]=trim($arr[$i-2][2]);
                                  $day[$d][$j]['teacher'][]=trim($arr[$i-2][7]).trim($arr[$i][0]);
                                }
                                
                              }else{
                                $day[$d][$j]['score'][]=trim($arr[$i-1][2]);
                                $day[$d][$j]['teacher'][]=trim($arr[$i-1][7]).trim($arr[$i][0]);
                              }
                                
                                $day[$d][$j]['add'][]=trim($arr[$i][5]).trim($arr[$i][6]);
                                $day[$d][$j]['teacher'][]=trim($arr[$i-1][6]).trim($arr[$i][0]);
                            }
                            
                        }
                    }
                }
            }    
        }
        $day=json_encode($day);
        //$day=addslashes($day);    
        return $day;
    }

    //源课表
    function getXuanke3(){
        if(isset($_COOKIE['isl'])){
            $session4="websvr_cookie"."=".$_COOKIE['websvr_cookie'];
            $session2="ENABLE_RANDCODE"."=".$_COOKIE['ENABLE_RANDCODE'];
            $session3="TWFID"."=".$_COOKIE['TWFID'];
        }
        $url="https://vpn.hpu.edu.cn/web/1/http/2/218.196.240.97/xkAction.do?actionType=6";
        //$url = "https://vpn.hpu.edu.cn/web/1/http/2/218.196.240.97/lnkbcxAction.do?zxjxjhh=2015-2016-2-1";
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0");
        curl_setopt($ch,CURLOPT_COOKIE,"$session2;$session3;$session4");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $content = curl_exec ( $ch );
        curl_close ( $ch );
        $content=iconv("gbk", "utf-8", $content);
        $html=new SimpleHtmlController();
        $html->load($content);
        $content=$html->find('table')[4];
        $content=html_entity_decode($content);
        return $content;
        setcookie('websvr_cookie', NULL);
        setcookie('ENABLE_RANDCODE', NULL);
        setcookie('TWFID', NULL);
    }
    
    
    //正则匹配表格
    public function get_td_array($table) { 
        $table = preg_replace("'<table[^>]*?>'si","",$table); 
        $table = preg_replace("'<tr[^>]*?>'si","",$table); 
        $table = preg_replace("'<td[^>]*?>'si","",$table); 
        $table = str_replace("</tr>","{tr}",$table); 
        //PHP开源代码
        $table = str_replace("</td>","{td}",$table); 
        //去掉 HTML 标记  
        $table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table); 
        //去掉空白字符   
        $table = preg_replace("'([rn])[s]+'","",$table); 
        $table = str_replace(" ","",$table); 
        $table = str_replace("&nbsp;","",$table); 
        $table = str_replace(" ","",$table);
        $table = explode('{tr}', $table); 
        array_pop($table);  
        foreach ($table as $key=>$tr) { 
            $td = explode('{td}', $tr); 
            array_pop($td); 
            $td_array[] = $td; 
        } 
        return $td_array; 
    }
   
}
