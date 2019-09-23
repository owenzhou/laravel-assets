<?php
namespace Owenzhou\LaravelAsset;
use File;
use App;
use Request;

class MyAsset{

	const DEFAULT_BASEPATH='assets';

	public $_published = [];

	//发布resources/view/layouts/assets

	//获取静态资源路径
	public function getSrc($name='app'){
		if( !isset($this->_published[$name]) ){
			return trigger_error('resource:'. $name .' not find', E_USER_ERROR);
		}
		return $this->_published[$name];
	}

	//发布静态资源路径
	public function publish($name, $src, $forceCopy=null){
		if( isset($this->_published[$name]) )
			return;

		if( !File::isDirectory($src) )
			return trigger_error('src:'. $src .' error', E_USER_ERROR);

		$dir=$this->hash($src.filemtime($src));
		$dstDir=App::publicPath() .DIRECTORY_SEPARATOR .self::DEFAULT_BASEPATH .DIRECTORY_SEPARATOR .$dir;
		if( !File::isDirectory($dstDir) || $forceCopy ){
			File::copyDirectory($src, $dstDir);
		}
		return $this->_published[$name] = Request::getRequestUri().self::DEFAULT_BASEPATH.'/'.$dir;
	}

	public function __get($name){
		$getter = 'get'.ucfirst($name);
		if( !method_exists($this, $getter) ){
			return trigger_error('method:'.$getter.' not exists', E_USER_ERROR);
		}
		return $this->$getter();
	}

	protected function hash($path){
		return sprintf('%x',crc32($path.App::version()));
	}

	//获取resources/views/layouts/assets 路径
	public function appPath(){
		return resource_path('/views/layouts/'. self::DEFAULT_BASEPATH);
	}

	//获取resources/views/themes/xxxx/layouts/assets
	public function themePath($name){
		return resource_path('/views/themes/'. $name .'/layouts/'. self::DEFAULT_BASEPATH);
	}

}