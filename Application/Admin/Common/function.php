<?php

function check_verify($code, $id = ''){    
	$verify = new \Think\Verify();    
	return $verify->check($code, $id);
}

/**
 * 取验证码hash值
 *
 * @param
 * @return string 字符串类型的返回结果
 */
function getHash(){
	return substr(md5(__SELF__),0,8);
}

/*生成哈希链接*/
function U_hash($link){
	return U($link,array('nchash'=>getHash()));
}

function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}

function makeSeccode($nchash){
	$seccode = random(6, 1);
	$seccodeunits = '';

	$s = sprintf('%04s', base_convert($seccode, 10, 23));
	$seccodeunits = 'ABCEFGHJKMPRTVXY2346789';
	if($seccodeunits) {
		$seccode = '';
		for($i = 0; $i < 4; $i++) {
			$unit = ord($s{$i});
			$seccode .= ($unit >= 0x30 && $unit <= 0x39) ? $seccodeunits[$unit - 0x30] : $seccodeunits[$unit - 0x57];
		}
	}
	session('seccode',$nchash);
	//cookie('seccode'.$nchash, encrypt(strtoupper($seccode)."\t".(time())."\t".$nchash,MD5_KEY),3600);
	return $seccode;
}

/**
 * 加密函数
 *
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function encrypt($txt, $key = ''){
	if (empty($txt)) return $txt;
	if (empty($key)) $key = md5(MD5_KEY);
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
	$ikey ="-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
	$nh1 = rand(0,64);
	$nh2 = rand(0,64);
	$nh3 = rand(0,64);
	$ch1 = $chars{$nh1};
	$ch2 = $chars{$nh2};
	$ch3 = $chars{$nh3};
	$nhnum = $nh1 + $nh2 + $nh3;
	$knum = 0;$i = 0;
	while(isset($key{$i})) $knum +=ord($key{$i++});
	$mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum%8,$knum%8 + 16);
	$txt = base64_encode(time().'_'.$txt);
	$txt = str_replace(array('+','/','='),array('-','_','.'),$txt);
	$tmp = '';
	$j=0;$k = 0;
	$tlen = strlen($txt);
	$klen = strlen($mdKey);
	for ($i=0; $i<$tlen; $i++) {
		$k = $k == $klen ? 0 : $k;
		$j = ($nhnum+strpos($chars,$txt{$i})+ord($mdKey{$k++}))%64;
		$tmp .= $chars{$j};
	}
	$tmplen = strlen($tmp);
	$tmp = substr_replace($tmp,$ch3,$nh2 % ++$tmplen,0);
	$tmp = substr_replace($tmp,$ch2,$nh1 % ++$tmplen,0);
	$tmp = substr_replace($tmp,$ch1,$knum % ++$tmplen,0);
	return $tmp;
}

/**
 * 解密函数
 *
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function decrypt($txt, $key = '', $ttl = 0){
	if (empty($txt)) return $txt;
	if (empty($key)) $key = md5(MD5_KEY);

	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
	$ikey ="-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
	$knum = 0;$i = 0;
	$tlen = @strlen($txt);
	while(isset($key{$i})) $knum +=ord($key{$i++});
	$ch1 = @$txt{$knum % $tlen};
	$nh1 = strpos($chars,$ch1);
	$txt = @substr_replace($txt,'',$knum % $tlen--,1);
	$ch2 = @$txt{$nh1 % $tlen};
	$nh2 = @strpos($chars,$ch2);
	$txt = @substr_replace($txt,'',$nh1 % $tlen--,1);
	$ch3 = @$txt{$nh2 % $tlen};
	$nh3 = @strpos($chars,$ch3);
	$txt = @substr_replace($txt,'',$nh2 % $tlen--,1);
	$nhnum = $nh1 + $nh2 + $nh3;
	$mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum % 8,$knum % 8 + 16);
	$tmp = '';
	$j=0; $k = 0;
	$tlen = @strlen($txt);
	$klen = @strlen($mdKey);
	for ($i=0; $i<$tlen; $i++) {
		$k = $k == $klen ? 0 : $k;
		$j = strpos($chars,$txt{$i})-$nhnum - ord($mdKey{$k++});
		while ($j<0) $j+=64;
		$tmp .= $chars{$j};
	}
	$tmp = str_replace(array('-','_','.'),array('+','/','='),$tmp);
	$tmp = trim(base64_decode($tmp));

	if (preg_match("/\d{10}_/s",substr($tmp,0,11))){
		if ($ttl > 0 && (time() - substr($tmp,0,11) > $ttl)){
			$tmp = null;
		}else{
			$tmp = substr($tmp,11);
		}
	}
	return $tmp;
}

//文章列表xml
function news_xml_encode($data, $root='rows', $item='item', $attr='', $id='id', $encoding='utf-8'){
	if(is_array($attr)){
		$_attr = array();
		foreach ($attr as $key => $value) {
			$_attr[] = "{$key}=\"{$value}\"";
		}
		$attr = implode(' ', $_attr);
	}
	$attr   = trim($attr);
	$attr   = empty($attr) ? '' : " {$attr}";
	$xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
	$xml   .= "<{$root}{$attr}>";
	$xml   .= "<page>".$data['page']."</page>";
	$xml   .= "<total>".$data['total']."</total>";
	foreach($data['data'] as $v){
		$xml.= "<row id='".$v['news_id']."'>"; 
		$xml.= "<cell><![CDATA[<a class='btn blue' href='".U('news/edit',array('id'=>$v['news_id']))."'><i class='fa fa-pencil-square-o'></i>编辑</a><a class='btn red' href='javascript:void(0);' onclick='fg_del(".$v['news_id'].");'><i class='fa fa-trash-o'></i>删除</a>]]></cell>";
		$xml.= "<cell>".$v['sort']."</cell>";
		$xml.= "<cell>".$v['title']."</cell>";
		$xml.= "<cell><![CDATA[<a href='javascript:void(0);' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".$v['pic'].">\")'><i class='fa fa-picture-o'></i></a>]]></cell>";
		$xml.= "<cell>".count($v['attachment'])."</cell>";
		$xml.= "<cell>".$v['category']['cat_name']."</cell>";	
		$xml.= "<cell>".$v['view_times']."</cell>";
		if($v['status']){
			$xml.= "<cell><![CDATA[<span class='yes'><i class='fa fa-check-circle'></i>显示</span>]]></cell>";
		}else{
			$xml.= "<cell><![CDATA[<span class='no'><i class='fa fa-ban'></i>隐藏</span>]]></cell>";
		}
		$xml.= "<cell>".$v['source']."</cell>";
		$xml.= "<cell>".date('Y-m-d H:i:s',$v['update_time'])."</cell>";
		$xml.= "</row>";
	}
	$xml   .= "</{$root}>";
	return $xml;
}

//tour列表xml
function tour_xml_encode($data, $root='rows', $item='item', $attr='', $id='id', $encoding='utf-8'){
	if(is_array($attr)){
		$_attr = array();
		foreach ($attr as $key => $value) {
			$_attr[] = "{$key}=\"{$value}\"";
		}
		$attr = implode(' ', $_attr);
	}
	$attr   = trim($attr);
	$attr   = empty($attr) ? '' : " {$attr}";
	$xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
	$xml   .= "<{$root}{$attr}>";
	$xml   .= "<page>".$data['page']."</page>";
	$xml   .= "<total>".$data['total']."</total>";
	foreach($data['data'] as $v){
		$xml.= "<row id='".$v['tour_id']."'>"; 
		$xml.= "<cell><![CDATA[<a class='btn blue' href='".U('tour/edit',array('id'=>$v['tour_id']))."'><i class='fa fa-pencil-square-o'></i>编辑</a><a class='btn red' href='javascript:void(0);' onclick='fg_del(".$v['tour_id'].");'><i class='fa fa-trash-o'></i>删除</a><a class='btn green' href='".U('kp/file_put_and_show',array('id'=>$v['tour_id']))."'><i class='fa fa-video-camera'></i>预览</a>]]></cell>";
		$xml.= "<cell>".$v['sort']."</cell>";
		$xml.= "<cell>".$v['title']."</cell>";
		$xml.= "<cell><![CDATA[<a href='javascript:void(0);' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".$v['pic'].">\")'><i class='fa fa-picture-o'></i></a>]]></cell>";
		$xml.= "<cell><![CDATA[<a class='btn blue' href='".U('scene/index',array('tid'=>$v['tour_id']))."'><i class='fa fa-pencil-square-o'></i>".count($v['scene'])."</a>]]></cell>";
		$xml.= "<cell>".$v['category']['cat_name']."</cell>";	
		$xml.= "<cell>".$v['view_times']."</cell>";
		if($v['status']){
			$xml.= "<cell><![CDATA[<span class='yes'><i class='fa fa-check-circle'></i>显示</span>]]></cell>";
		}else{
			$xml.= "<cell><![CDATA[<span class='no'><i class='fa fa-ban'></i>隐藏</span>]]></cell>";
		}
		$xml.= "<cell>".date('Y-m-d H:i:s',$v['update_time'])."</cell>";
		$xml.= "</row>";
	}
	$xml   .= "</{$root}>";
	return $xml;
}

//scene列表xml
function scene_xml_encode($data, $root='rows', $item='item', $attr='', $id='id', $encoding='utf-8'){
	if(is_array($attr)){
		$_attr = array();
		foreach ($attr as $key => $value) {
			$_attr[] = "{$key}=\"{$value}\"";
		}
		$attr = implode(' ', $_attr);
	}
	$attr   = trim($attr);
	$attr   = empty($attr) ? '' : " {$attr}";
	$xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
	$xml   .= "<{$root}{$attr}>";
	$xml   .= "<page>".$data['page']."</page>";
	$xml   .= "<total>".$data['total']."</total>";
	foreach($data['data'] as $v){
		$xml.= "<row id='".$v['scene_id']."'>"; 
		$xml.= "<cell>";
		$xml.="<![CDATA[<a class='btn green' href='".U('kp/set_scene',array('id'=>$v['scene_id']))."'><i class='fa fa-video-camera'></i>镜头配置</a>]]>";
		$xml.= "<![CDATA[<a class='btn blue' href='".U('scene/edit',array('id'=>$v['scene_id']))."'><i class='fa fa-pencil-square-o'></i>编辑</a><a class='btn red' href='javascript:void(0);' onclick='fg_del(".$v['scene_id'].");'><i class='fa fa-trash-o'></i>删除</a>]]></cell>";
		$xml.= "<cell>".$v['sort']."</cell>";
		$xml.= "<cell>".$v['title']."</cell>";
		$xml.= "<cell><![CDATA[<a href='javascript:void(0);' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".$v['pic'].">\")'><i class='fa fa-picture-o'></i></a>]]></cell>";
		$xml.= "<cell><![CDATA[<a class='btn blue' href='".U('hotspot/index',array('sid'=>$v['scene_id']))."'><i class='fa fa-pencil-square-o'></i>".count($v['hotspot'])."</a>]]></cell>";
		$xml.= "<cell>".$v['hlookat']."</cell>";
		$xml.= "<cell>".$v['vlookat']."</cell>";
		$xml.= "<cell>".$v['fov']."</cell>";
		$xml.= "<cell>".date('Y-m-d H:i:s',$v['update_time'])."</cell>";
		$xml.= "</row>";
	}
	$xml   .= "</{$root}>";
	return $xml;
}


//文章列表xml
function hotspot_xml_encode($data, $root='rows', $item='item', $attr='', $id='id', $encoding='utf-8'){
	if(is_array($attr)){
		$_attr = array();
		foreach ($attr as $key => $value) {
			$_attr[] = "{$key}=\"{$value}\"";
		}
		$attr = implode(' ', $_attr);
	}
	$attr   = trim($attr);
	$attr   = empty($attr) ? '' : " {$attr}";
	$xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
	$xml   .= "<{$root}{$attr}>";
	$xml   .= "<page>".$data['page']."</page>";
	$xml   .= "<total>".$data['total']."</total>";
	foreach($data['data'] as $v){
		$cat_id=$v['cat_id'];
		$cat_data=D('HotspotCategory')->find($cat_id);
		$cat_name=$cat_data['cat_name'];

		$xml.= "<row id='".$v['hotspot_id']."'>"; 
		$xml.= "<cell>";
		if('导航'==$cat_name) {
			$xml.= "<![CDATA[<a class='btn green' href='".U('kp/set_goto_array',array('id'=>$v['hotspot_id']))."'><i class='fa fa-gear'></i>配置热点</a>]]>";
			$xml.="<![CDATA[<a class='btn green' href='".U('kp/set_goto_scene',array('id'=>$v['hotspot_id']))."'><i class='fa fa-video-camera'></i>配置镜头</a>]]>";
		}
		$xml.="<![CDATA[<a class='btn blue' href='".U('hotspot/edit',array('id'=>$v['hotspot_id']))."'><i class='fa fa-pencil-square-o'></i>编辑</a><a class='btn red' href='javascript:void(0);' onclick='fg_del(".$v['hotspot_id'].");'><i class='fa fa-trash-o'></i>删除</a>]]></cell>";
		$xml.= "<cell>".$v['sort']."</cell>";

		$xml.= "<cell>".$v['title']."</cell>";

		$xml.= "<cell>".$v['category']['cat_name']."</cell>";

		if($v['status']){
			$xml.= "<cell><![CDATA[<span class='yes'><i class='fa fa-check-circle'></i>显示</span>]]></cell>";
		}else{
			$xml.= "<cell><![CDATA[<span class='no'><i class='fa fa-ban'></i>隐藏</span>]]></cell>";
		}
		$xml.= "<cell>".date('Y-m-d H:i:s',$v['update_time'])."</cell>";
		$xml.= "</row>";
	}
	$xml   .= "</{$root}>";
	return $xml;
}



//上传文件
function upload_file($savepath,$field){
	$upload = new \Think\Upload(C('UPLOAD_CONFIG'));
	$upload->savePath = $savepath;
	$upload->subName = $group_id;
	$upload_info = $upload->upload();
	if(!$upload_info) { 
		return $upload->getError();
	}else{
		$file_path = './Uploads'.ltrim($upload_info[$field]['savepath'],'.').$upload_info[$field]['savename'];
		$upload_info[$field]['file_path'] = $file_path;
		return $upload_info[$field];
	}
}

function recurse_copy($src,$dst) {  // 原目录，复制到的目录
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

//循环删除目录和文件函数
function delDirAndFile( $dirName )
{
	if ( $handle = opendir( "$dirName" ) ) {
		while ( false !== ( $item = readdir( $handle ) ) ) {
			if ( $item != "." && $item != ".." ) {
				if ( is_dir( "$dirName/$item" ) ) {
					delDirAndFile( "$dirName/$item" );
				} else {
					unlink( "$dirName/$item" );
				}
			}
		}
		closedir( $handle );
		rmdir( $dirName );
	}
}

//md10加密
function md10($str){
	return 'a'.md5($str);
}