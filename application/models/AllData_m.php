<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AllData_m extends CI_Model {
    public function getDatas($category)
    {
            $where = array(
                'feed.id_jenis_feed'    =>  $category
            );
            $this->db->select('feed.id_feed, feed.jdul_feed, ROUND(AVG(rating), 1) AS rating, feed.desc_feed, feed.almt_feed, feed.jam_publish, feed.tgl_publish, member.unick AS publishr_feed')
            ->join('feed', 'rating.id_feed = feed.id_feed', 'left')
            ->join('member', 'feed.uname = member.uname', 'left')
            ->join('jenisfeed',' feed.id_jenis_feed = jenisfeed.id_jenis_feed', 'left')
            ->where($where)
            ->ORDER_BY('feed.id_feed','DESC')
            ->GROUP_BY('feed.id_feed')
            ->from('rating');   
		return $this->db->get();
    }
    public function getSingleDatas($category, $var)
    {
        $where = array(
            'feed.id_jenis_feed'    => $category,
            'feed.id_feed'          => $var
        );
        $this->db->select('feed.id_feed, feed.jdul_feed, ROUND(AVG(rating), 1) AS rating, feed.desc_feed, feed.almt_feed, feed.jam_publish, feed.tgl_publish, member.unick AS publishr_feed')
        ->join('feed', 'rating.id_feed = feed.id_feed', 'left')
        ->join('member', 'feed.uname = member.uname', 'left')
        ->join('jenisfeed',' feed.id_jenis_feed = jenisfeed.id_jenis_feed', 'left')
        ->from('rating')
        ->ORDER_BY('feed.id_feed','DESC')
        ->GROUP_BY('feed.id_feed')
        ->where($where);
        return $this->db->get();
    }
}