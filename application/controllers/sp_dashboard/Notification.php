<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

	public $project = "sp_dashboard";
	public $category = "notification";
	public $user = "";

	public function __construct(){
		parent::__construct();

		$this->load->model("DashboardModel");
		
		if(!get_superuser_user()->is_superuser == 1){
            redirect(base_url("/login"));
		}
		else{
			$this->user = get_superuser_user();
			$this->notification_alerts = $this->DashboardModel->get_notification_alerts();
			$this->ticket_alerts = $this->DashboardModel->get_ticket_alerts();
		}
	
		$this->load->model("NotificationModel");

	}

	public function list(){
		$items = $this->NotificationModel->get_all();

		$context=array(
			"title"		=>	"Bildirim",
			"sub_title"	=>	"Bildirim Listesi",
			"project" 				=> 	$this->project,
			"category" 				=>	$this->category,
			"view" 					=>  $this->router->fetch_method(),
			"user" 					=>	$this->user,
			"notification_alerts" 	=>	$this->notification_alerts,
			"ticket_alerts" 		=>	$this->ticket_alerts,
			"items" 	=>	$items,
			"DataTablesField"	=> "datatable",
			"page_title_add_button" => 1
		);
		$this->load->view("sp_dashboard/base",$context);
	}

	public function add(){
		if ($this->input->server('REQUEST_METHOD')=='GET'){		
			$context=array(
				"title"		=>	"Bildirim Ekle",
				"sub_title"	=>	"Yeni Bildirim Ekle",
				"project" 				=> 	$this->project,
				"category" 				=>	$this->category,
				"view" 					=>  $this->router->fetch_method(),
				"user" 					=>	$this->user,
				"notification_alerts" 	=>	$this->notification_alerts,
				"ticket_alerts" 		=>	$this->ticket_alerts,
				"CKEditorField"	=>	array(
					"description" => "description"
				),
			);
			$this->load->view("dashboard/base",$context);
		}

		else if ($this->input->server('REQUEST_METHOD')=='POST'){

			$this->load->library("form_validation");

			$this->form_validation->set_rules("title", "Başlık", "required|trim");
			$this->form_validation->set_rules("description", "Bildirim", "required|trim");

			$this->form_validation->set_message(
				array(
					"required"  => "<b>{field}</b> alanı doldurulmalıdır"
				)
			);

			$validate = $this->form_validation->run();

			if($validate){
				$insert = $this->NotificationModel->add(
					array(
						"title"         	 =>	AutoSlugField($this->input->post("title")),
						"description"         	 =>	$this->input->post("description"),
					)
				);

				
				if($insert){
					$ToastField	=	array(
						"status"	=> "success",
						"title"		=>	"İşlem Başarılı.",
						"message"		=>"Başarılı bir şekilde kayıt oldu.",
					);
					$this->session->set_flashdata("ToastField", $ToastField);
					redirect(base_url("sp-admin/notification"));
				} else {
					$ToastField	=	array(
						"status"	=> "error",
						"title"		=>	"İşlem başarısız.",
						"message"		=>"İşlem kayıt olamadı :(",
					);
					$this->session->set_flashdata("ToastField", $ToastField);
					redirect(base_url("sp-admin/notification"));
				}

			} 
			else {
				$context=array(
					"title"		=>	"Bildirim Ekle",
					"sub_title"	=>	"Yeni Bildirim Ekle",
					"project" 				=> 	$this->project,
					"category" 				=>	$this->category,
					"view" 					=>  $this->router->fetch_method(),
					"user" 					=>	$this->user,
					"notification_alerts" 	=>	$this->notification_alerts,
					"ticket_alerts" 		=>	$this->ticket_alerts,
					"CKEditorField"	=>	array(
						"description" => "description"
					),
					"form_errors"	=> validation_errors(),
				);
				$this->load->view("dashboard/base",$context);

			}
		}
	}


	public function update(){
		if ($this->input->server('REQUEST_METHOD')=='GET'){
			
			$id = $this->uri->segment(3);

			$notification = $this->NotificationModel->get(
				array(
					"id"	=> $id,
				)
			);

			$context=array(
				"title"		=>	$notification->title,
				"sub_title"	=>	$notification->title,
				"project" 				=> 	$this->project,
				"category" 				=>	$this->category,
				"view" 					=>  $this->router->fetch_method(),
				"user" 					=>	$this->user,
				"notification_alerts" 	=>	$this->notification_alerts,
				"ticket_alerts" 		=>	$this->ticket_alerts,
				"CKEditorField"	=>	array(
					"description" => "description"
				),
				"notification" 		=>	$notification,
			);
			$this->load->view("dashboard/base",$context);
		}
		else if ($this->input->server('REQUEST_METHOD')=='POST'){

			$id = $this->uri->segment(3);
			$this->load->library("form_validation");
			$this->form_validation->set_rules("title", "Başlık", "required|trim");
			$this->form_validation->set_message(
				array(
					"required"  => "<b>{field}</b> alanı doldurulmalıdır"
				)
			);

			$validate = $this->form_validation->run();

			if($validate){

				$update =$this->NotificationModel->update(
					array(
						"id"    => $id
					),
					array(
						"title"         => AutoSlugField($this->input->post("title")),
					)
				);
								

				if($update){
					$ToastField	=	array(
						"status"	=> "success",
						"title"		=>	"İşlem Başarılı.",
						"message"		=>"Başarılı bir şekilde güncellendi.",
					);
					$this->session->set_flashdata("ToastField", $ToastField);
					redirect(base_url("sp-admin/notification"));
				} else {
					$ToastField	=	array(
						"status"	=> "error",
						"title"		=>	"İşlem başarısız.",
						"message"		=>"Güncelleme olmadı :(",
					);
					$this->session->set_flashdata("ToastField", $ToastField);
					redirect(base_url("sp-admin/notification"));
				}

			} 
			else {
				$id = $this->uri->segment(3);

				$notification = $this->NotificationModel->get(
					array(
						"id"	=> $id,
					)
				);
	
				$context=array(
					"title"		=>	$notification->title,
					"sub_title"	=>	$notification->title,
					"project" 				=> 	$this->project,
					"category" 				=>	$this->category,
					"view" 					=>  $this->router->fetch_method(),
					"user" 					=>	$this->user,
					"notification_alerts" 	=>	$this->notification_alerts,
					"ticket_alerts" 		=>	$this->ticket_alerts,
					"CKEditorField"	=>	array(
						"description" => "description"
					),
					"notification" 		=>	$notification,
					"form_errors"	=> validation_errors(),
				);
				$this->load->view("dashboard/base",$context);
			}
    	}
	}
	

	public function delete(){
		$id = $this->uri->segment(4);
		$delete = $this->NotificationModel->delete(
            array(
                "id"	=>	$id
            )
		);

		if($delete){
			$ToastField	=	array(
				"status"	=> "success",
				"title"		=>	"İşlem Başarılı.",
				"message"		=>"Başarılı bir şekilde silindi.",
			);
			$this->session->set_flashdata("ToastField", $ToastField);
			redirect(base_url("sp-admin/notification"));
		} else {
			$ToastField	=	array(
				"status"	=> "error",
				"title"		=>	"İşlem başarısız.",
				"message"		=>"Silme işlemi olmadı :(",
			);
			$this->session->set_flashdata("ToastField", $ToastField);
			redirect(base_url("sp-admin/notification"));
		}
	}


}