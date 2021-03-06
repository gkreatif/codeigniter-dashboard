<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserSettings extends CI_Controller {

	public $project = "sp_dashboard";
	public $category = "settings";
	public $user = "";

	public function __construct(){
		parent::__construct();

		$this->load->model("DashboardModel");
		
		if(!get_active_user()){
            redirect(base_url("/login"));
		}
		else{
			$this->user = get_active_user();
			$this->notification_alerts = $this->DashboardModel->get_notification_alerts();
			$this->ticket_alerts = $this->DashboardModel->get_ticket_alerts();
		}
	
		$this->load->model("UserModel");

	}

	public function list(){
		$items = $this->UserModel->get_all();

		$context=array(
			"title"		=>	"Kullanıcılar",
			"sub_title"	=>	"Kullanıcı Listesi",
			"project" 				=> 	$this->project,
			"category" 				=>	$this->category,
			"view" 					=>  $this->router->fetch_method(),
			"user" 					=>	$this->user,
			"notification_alerts" 	=>	$this->notification_alerts,
			"ticket_alerts" 		=>	$this->ticket_alerts,
			"items" 	=>	$items,
			"DataTablesField"	=> "datatable"
		);
		$this->load->view("dashboard/base",$context);
	}

	public function update()
	{
		if ($this->input->server('REQUEST_METHOD')=='GET'){
			
			$item = $this->UserModel->get(
				array(
					"id"	=> $this->user->id,
				)
			);
			
			$context=array(
				"title"		=>	"Kullanıcı Güncelle",
				"sub_title"	=>	"Kullanıcı Güncelle",
				"project"	=>	$this->project,
				"category"	=>	$this->category,
				"view"		=>	$this->router->fetch_method(),
				"user" 					=>	$this->user,
				"notification_alerts" 	=>	$this->notification_alerts,
				"ticket_alerts" 		=>	$this->ticket_alerts,
				"CKEditorField"	=>	array(
					"description" => "description"
				),
				"item" 		=>	$item,
			);
			$this->load->view("dashboard/base",$context);
		}
		else if ($this->input->server('REQUEST_METHOD')=='POST'){
			$this->load->library("form_validation");

			$this->form_validation->set_rules("first_name", "İsim", "required|trim");
			$this->form_validation->set_rules("last_name", "Soyisim", "required|trim");
			$this->form_validation->set_rules("email", "Eposta", "required|trim");
			
			$this->form_validation->set_message(
				array(
					"required"  => "<b>{field}</b> alanı doldurulmalıdır"
				)
			);

			$validate = $this->form_validation->run();
			if($validate){
				$update =$this->UserModel->update(
					array(
						"id"    => $this->user->id
					),
					array(
						"first_name"         => $this->input->post("first_name"),
						"last_name"   => $this->input->post("last_name"),
						"email"   => $this->input->post("email"),
					)
				);
				
				
				if($update){
					$ToastField	=	array(
						"status"	=> "success",
						"title"		=>	"İşlem Başarılı.",
						"message"		=>"Başarılı bir şekilde güncellendi.",
					);
					$this->session->set_flashdata("ToastField", $ToastField);
					redirect(base_url("admin/page"));
				} 
				else {
					$ToastField	=	array(
						"status"	=> "error",
						"title"		=>	"İşlem başarısız.",
						"message"		=>"Güncelleme olmadı :(",
					);
					$this->session->set_flashdata("ToastField", $ToastField);
					redirect(base_url("admin/page"));
				}
			}
			else{
				$item = $this->UserModel->get(
					array(
						"id"	=> $this->user->id,
					)
				);
				
				$context=array(
					"title"		=>	"Kullanıcı Güncelle",
					"sub_title"	=>	"Kullanıcı Güncelle",
					"project"	=>	$this->project,
					"category"	=>	$this->category,
					"view"		=>	$this->router->fetch_method(),
					"user" 					=>	$this->user,
					"notification_alerts" 	=>	$this->notification_alerts,
					"ticket_alerts" 		=>	$this->ticket_alerts,
					"CKEditorField"	=>	array(
						"description" => "description"
					),
					"item" 		=>	$item,
					"form_errors"	=> validation_errors(),
				);
				$this->load->view("dashboard/base",$context);

			}
			 
			}
	}

	public function change_password()
	{
		if ($this->input->server('REQUEST_METHOD')=='GET'){
			
			$item = $this->UserModel->get(
				array(
					"id"	=> $this->user->id,
				)
			);
			
			$context=array(
				"title"		=>	"Kullanıcı Güncelle",
				"sub_title"	=>	"Kullanıcı Güncelle",
				"project"	=>	$this->project,
				"category"	=>	$this->category,
				"view"		=>	$this->router->fetch_method(),
				"user" 					=>	$this->user,
				"notification_alerts" 	=>	$this->notification_alerts,
				"ticket_alerts" 		=>	$this->ticket_alerts,
				"CKEditorField"	=>	array(
					"description" => "description"
				),
				"item" 		=>	$item,
			);
			$this->load->view("dashboard/base",$context);
		}
		else if ($this->input->server('REQUEST_METHOD')=='POST'){
			$this->load->library("form_validation");

			$this->form_validation->set_rules("old_password", "Eski Şifre", "required|trim");
			$this->form_validation->set_rules("new_password", "Yeni Şifre", "required|trim|matches[confirm_new_password]");
			$this->form_validation->set_rules("confirm_new_password", "Yeni Şifre (Tekrar)", "required|trim");
	
			$this->form_validation->set_message(
				array(
					"required"  => "<b>{field}</b> alanı doldurulmalıdır",
					"matches"   => "{field} & {param} uyuşmuyor",
				)
			);

			$validate = $this->form_validation->run();
			
			if($validate){
				if(md5($this->input->post("old_password")) == $this->user->password){

					$update =$this->UserModel->update(
						array(
							"id"    => $this->user->id
						),
						array(
							"password"   => md5($this->input->post("password")),
						)
					);
					
		
					if($update){
						$ToastField	=	array(
							"status"	=> "success",
							"title"		=>	"İşlem Başarılı.",
							"message"		=>"Başarılı bir şekilde güncellendi.",
						);
						$this->session->set_flashdata("ToastField", $ToastField);
						redirect(base_url("admin/page"));
					} 
					else {
						$ToastField	=	array(
							"status"	=> "error",
							"title"		=>	"İşlem başarısız.",
							"message"		=>"Güncelleme olmadı :(",
						);
						$this->session->set_flashdata("ToastField", $ToastField);
						redirect(base_url("admin/page"));
					}

				}
				else {
					$ToastField	=	array(
						"status"	=> "error",
						"title"		=>	"İşlem başarısız.",
						"message"		=>"Güncelleme olmadı :(",
					);
					$this->session->set_flashdata("ToastField", $ToastField);
					redirect(base_url("admin/user/change_password"));
				}
			}
			else{
				$item = $this->UserModel->get(
					array(
						"id"	=> $this->user->id,
					)
				);
				
				$context=array(
					"title"		=>	"Kullanıcı Güncelle",
					"sub_title"	=>	"Kullanıcı Güncelle",
					"project"	=>	$this->project,
					"category"	=>	$this->category,
					"view"		=>	$this->router->fetch_method(),
					"user" 					=>	$this->user,
					"notification_alerts" 	=>	$this->notification_alerts,
					"ticket_alerts" 		=>	$this->ticket_alerts,
					"CKEditorField"	=>	array(
						"description" => "description"
					),
					"item" 		=>	$item,
					"form_errors"	=> validation_errors(),
				);
				$this->load->view("dashboard/base",$context);	
			}
		}
		
	}

}