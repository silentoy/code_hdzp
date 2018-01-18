<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class M_Tag extends MY_Model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'hdzp_tags';
    }

    function getListByIn($tagIds = false)
    {
        if (!$tagIds) {
            return array();
        }
        $sql = "select id,name from {$this->table} where id in ({$tagIds}) and `status`=0 order by `orderby` desc";
        return $this->db->query($sql)->result_array();
    }
}