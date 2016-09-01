<?php

namespace Addons\Lib1;
use Common\Controller\Addon;

/**
 * Lib1插件
 * @author 凡星
 */

    class Lib1Addon extends Addon{

        public $info = array(
            'name'=>'Lib1',
            'title'=>'图书',
            'description'=>'图书馆插件',
            'status'=>1,
            'author'=>'niool',
            'version'=>'0.1',
            'has_adminlist'=>0,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Lib1/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Lib1/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }