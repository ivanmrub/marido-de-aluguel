<?php

defined('BASEPATH') OR exit ('Ação não permitida');

class Sistema extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('info', 'Sua sessão expirou');
            redirect('login');
        }
        
        if(!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', 'Você não tem permissão para acessar o menu Sistema');
            redirect('/');
        }
    }
    
    public function index() {
        
        $data = array(
            'titulo' => 'Editar informações do sistema',
            'scripts' => array(
                'vendor/mask/jquery.mask.min.js',
                'vendor/mask/app.js',
            ),
            'sistema' => $this->core_model->get_by_id('sistema', array('sistema_id' => 1)),
        );
       
        
        $this->form_validation->set_rules('sistema_razao_social', 'Razão Social', 'required|min_length[10]|max_length[145]');
        $this->form_validation->set_rules('sistema_nome_fantasia', 'Nome fantasia', 'required|min_length[10]|max_length[145]');
        $this->form_validation->set_rules('sistema_cnpj', '', 'required|exact_length[18]'); // 18 caracteres
        $this->form_validation->set_rules('sistema_ie', '', 'required|max_length[25]');
        $this->form_validation->set_rules('sistema_email', '', 'required|max_length[100]');
        $this->form_validation->set_rules('sistema_site_url', 'URL do site', 'required|valid_url|max_length[100]');
        $this->form_validation->set_rules('sistema_cep', 'CEP', 'required|exact_length[9]');
        $this->form_validation->set_rules('sistema_endereco', 'Endereço', 'required|max_length[100]');
        $this->form_validation->set_rules('sistema_numero', 'Número', 'max_length[25]');
        $this->form_validation->set_rules('sistema_cidade', 'Cidade', 'required|max_length[45]');
        $this->form_validation->set_rules('sistema_estado', 'UF', 'required|exact_length[2]');
        $this->form_validation->set_rules('sistema_txt_ordem_servico', 'Texto da ordem de serviço e venda', 'max_length[500]');
        
        
      
        if($this->form_validation->run()) {
            
            /*
             *  [sistema_razao_social] => System ordem inc
                [sistema_nome_fantasia] => Sistema ordem now
                [sistema_cnpj] => 50.389.234/0001-40
                [sistema_ie] => 2403274731
                [sistema_telefone_fixo] => 
                [sistema_telefone_movel] => 
                [sistema_site_url] => http://localhost/ordem/
                [sistema_email] => ordemnow@contato.com.br
                [sistema_endereco] => Rua da Programação 
                [sistema_cep] => 80429-000
                [sistema_numero] => 38
                [sistema_cidade] => Curitiba
                [sistema_estado] => PR
                [sistema_txt_ordem_servico] =>
            */
            
            $data = elements(                  
                    array(
                'sistema_razao_social',
                'sistema_nome_fantasia',        
                'sistema_cnpj',
                'sistema_ie',        
                'sistema_telefone_fixo',        
                'sistema_telefone_movel',        
                'sistema_site_url',        
                'sistema_email',
                'sistema_endereco',        
                'sistema_cep',        
                'sistema_numero',        
                'sistema_cidade',
                'sistema_estado',        
                'sistema_txt_ordem_servico',        
                    ),$this->input->post()
                    
                    
            );
            
            $data = html_escape($data);
            
            $this->core_model->update('sistema', $data, array('sistema_id => 1'));
            
            redirect('sistema');
           
        }else{  
               
        
        $this->load->view('layout/header',$data);
        $this->load->view('sistema/index');
        $this->load->view('layout/footer');
        
        }
    }           
}
