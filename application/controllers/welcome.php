<?php

class Welcome extends Controller
{

    function __construct()
    {
        parent::Controller();

    }

    function index()
    {  $this->load->model('news_syndication','ns');
       //
       $this->template->write_view('usermenu', 'loginbox');
       $this->template->write_view('futures', 'news');
       $this->template->render();
    }

    function rss()
    {
        $this->load->library('wxml');
        //echo 'Initiate class';
        $xml = new WXml();
        $xml->setRootName('rss');
        $xml->initiate();
        $xml->writeAttribute('version',"2.0");
        $xml->startBranch('channel');
        $xml->addNode('title',"Help Doc Assistent Articles");
        $xml->addNode('description',"HDA articles rss system notify");
        $xml->addNode('language',"ru-ru");
        $xml->addNode('pubDate',date(DATE_RSS));
        $xml->addNode('lastBuildDate',date(DATE_RSS));
        $xml->addNode('docs',site_url());
        $xml->addNode('generator',"PHP Site rss system");
        $xml->addNode('managingEditor',"pussbb@gmail.com (_pussbb)");
        $xml->addNode('webMaster',"_pussbb@mail.ru (_pussbb)");
        $query=$this->db->query("SELECT * FROM ci_news where datepost <= NOW() ORDER BY datepost DESC limit 25; ");
        if($query->num_rows()>0) {
            foreach($query->result()  as $row) {
                $xml->startBranch('item');
                $xml->addNode('title',$row->title);
                $xml->addNode('link',site_url());
                $xml->addNode('description',html_entity_decode($row->text),array(),true);
                $xml->addNode('pubDate',$row->datepost);
                $xml->addNode('guid' ,$row->id,array('isPermaLink'=>"false"),true);
                $xml->endBranch();
            }
        }
        $xml->endBranch();
        // $xml->endBranch();
        $xml->getXml(true);
    }

   
    
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
