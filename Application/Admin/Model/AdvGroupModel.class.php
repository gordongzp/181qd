<?php
namespace Admin\Model;
use Think\Model;

class AdvGroupModel extends Model{
		
	protected $_validate = array(
        array('gname','require','请填写广告位名称'),
        array('gtype','require','请选择广告类别'),
    );

}