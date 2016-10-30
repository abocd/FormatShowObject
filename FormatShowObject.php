<?php
/**
 * 格式化输出显示对象、数组的维度，便于定位
 *
 *
 * FormatShowObject.php
 * User: Aboc  mayinhua@eihoo.com
 * Url: https://github.com/abocd/FormatShowObject
 * Date: 16-10-30
 * Time: 上午10:41
 */
class FormatShowObject{

	public $str = '';

	/**
	 * 显示格式的方法
	 *
	 * @param $data
	 */
	function show($data){
		echo '<pre>'.$this->_start($data).'</pre>';
	}

	/**
	 * 开始分析
	 *
	 * @param       $data
	 * @param array $keys
	 *
	 * @return string
	 */
	private function _start($data,$keys=array()){
		$str = '';
		$keys_num = count($keys);
		if(is_array($data)){
			$str .= $this->_repeat("(",$keys_num)."\r\n".$this->_array($data,$keys).$this->_tab($keys_num-1).$this->_repeat(")",$keys_num).$this->_end($keys);
		}
		elseif(is_object($data)){
			$str .= $this->_repeat("(",$keys_num)."\r\n".$this->_object($data,$keys).$this->_tab($keys_num-1).$this->_repeat(")",$keys_num).$this->_end($keys);
		}else{
			$str .= $this->_string($data,$keys);
		}
		return $str;
	}

	/**
	 * 处理数组
	 *
	 * @param       $array
	 * @param array $keys
	 *
	 * @return string
	 */
	private function _array($array,$keys=array()){
		$str = '';
		foreach($array as $k => $v){
			$curr_keys = $keys;
			$curr_keys[] =  $k;
			$str .= $this->_output_key($k,$curr_keys).$this->_start($v,$curr_keys)."\r\n";
		}
		return $str;
	}

	/**
	 * 处理对象
	 *
	 * @param       $object
	 * @param array $keys
	 *
	 * @return string
	 */
	private function _object($object,$keys=array()){
		$str = '';
		foreach($object as $k => $v){
			$curr_keys = $keys;
			$curr_keys[] =  $k;
			$str .= $this->_output_key($k,$curr_keys).$this->_start($v,$curr_keys)."\r\n";
		}
		return $str;
	}

	/**
	 * 处理字符串
	 *
	 * @param $string
	 *
	 * @return string
	 */
	private function _string($string){
		if(!is_string($string)){
			$string = (string)$string;
		}
			return $string;
	}

	/**
	 * 输出键值
	 *
	 * @param       $key
	 * @param array $keys
	 *
	 * @return string
	 */
	private function _output_key($key,$keys=array()){
		return $this->_tab(count($keys)-1)."[<ruby>{$key}<rt style='color:#999;font-size:10px;'>".join(">",$keys)."</rt></ruby>]=";
	}

	/**
	 * 输出模拟tab
	 *
	 * @param $num
	 *
	 * @return string
	 */
	private function _tab($num){
		if($num<0){
			$num = 0;
		}
		return "<i style='color:#999;'>".$this->_repeat("|----",$num)."</i>";
	}

	/**
	 * 重复字符串
	 *
	 * @param $str
	 * @param $num
	 *
	 * @return string
	 */
	private function _repeat($str,$num){
		if($num<0){
			$num = 0;
		}
		return str_repeat($str,$num);
	}

	/**
	 * 输出结束标志
	 *
	 * @param $keys
	 *
	 * @return string
	 */
	private function _end($keys){
		if(!$keys){
			return '';
		}
		return "<i style='color:#999;font-size:10px;'>//".join(">",$keys)."</i>";
	}


}


$formatshowobject = new FormatShowObject();


$formatshowobject->show(
	array(
		1,
		'aaa' => array( "ddss" => array( 777,4=>array("aboc","yinhua"),6=>4444 ), 5, 'ddd' ),
		"last"=>array(1,2)

	)
);

