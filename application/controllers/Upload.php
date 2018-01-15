<?php

class Upload extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $this->load->view('upload_form', array('error' => ' '));
    }

    public function onUpload()
    {
        $config['upload_path'] = FCPATH . 'uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10240;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $config['file_name'] = date("Ymd") . "_" . TIMESTAMP;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            echojsondata('err', $this->upload->display_errors(), '上传失败');
        } else {
            $data = $this->upload->data();

            $data['url'] = '/uploads/' . $data['file_name'];
            echojsondata('ok', $data, '上传成功');
        }
    }
}