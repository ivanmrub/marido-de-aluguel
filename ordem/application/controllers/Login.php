<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SB Admin 2 - Login</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">

    </head>

    <body class="bg-gradient-primary">

        <?php
        defined('BASEPATH') OR exit('Acção não permitida');

        class Login extends CI_Controller {

            public function index() {

                $data = array(
                    'titulo' => 'Login',
                );

                $this->load->view('layout/header', $data);
                $this->load->view('login/index');
                $this->load->view('layout/footer');
            }

            public function auth() {

                $identity = $this->security->xss_clean($this->input->post('email'));
                $password = $this->security->xss_clean($this->input->post('password'));
                $remember = FALSE; //remember the user

                if ($this->ion_auth->login($identity, $password, $remember)) {
                    redirect('home');
                } else {
                    $this->session->set_flashdata('error', 'Erro de validação');
                    redirect('login');
                }
            }

            public function logout() {

                $this->ion_auth->logout();
                redirect('login');
            }

        }
        