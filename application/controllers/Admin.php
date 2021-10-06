<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template', ['module' => strtolower($this->router->fetch_class())]);
		$this->load->model(['user', 'project', 'project_category', 'criteria']);
		if (empty($this->session->userdata($this->router->fetch_class())))
		{
			if (!in_array($this->router->fetch_method(), ['login', 'register', 'forgot_password', 'reset_password']))
			{
				redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
			}
		}
	}

	public function index()
	{
		$this->template->load('home');
	}

	public function login()
	{
		if ($this->input->method() == 'post')
		{
			$this->form_validation->set_rules('identity', 'Email / Nama Pengguna', 'trim|required');
			$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required');
			if ($this->form_validation->run() == TRUE)
			{
				$user = $this->user->sign_in($this->input->post('identity'), $this->input->post('password'));
				if ($user->num_rows() >= 1)
				{
					$this->session->set_userdata(strtolower($this->router->fetch_class()), $user->row()->id);
					redirect(base_url($this->router->fetch_class()), 'refresh');
				}
				else
				{
					if ($this->user->search($this->input->post('identity'))->num_rows() >= 1)
					{
						$this->session->set_flashdata('login', array('status' => 'failed', 'message' => 'Kata sandi tidak sesuai'));
						redirect(base_url($this->router->fetch_class().'/'.$this->router->fetch_method()), 'refresh');
					}
					else
					{
						$this->session->set_flashdata('login', array('status' => 'failed', 'message' => 'Akun tidak ditemukan'));
						redirect(base_url($this->router->fetch_class().'/'.$this->router->fetch_method()), 'refresh');
					}
				}
			}
			else
			{
				$this->load->view('admin/login');
			}
		}
		else
		{
			$this->load->view('admin/login');
		}
	}

	public function profile($id = NULL, $option = NULL)
	{
		$data['profile'] = $this->user->read(array('id' => (!empty($id))?$id:$this->session->userdata(strtolower($this->router->fetch_class()))))->row();
		switch ($option)
		{
			case 'edit':
				if ($this->input->method() == 'post')
				{
					if ($id !== $this->session->userdata($this->router->fetch_class()) OR $id > $this->session->userdata($this->router->fetch_class()))
					{
						$this->session->set_flashdata('edit_profile', array('status' => 'failed', 'message' => 'Anda tidak memiliki akses untuk mengubah profil orang lain!'));
						redirect(base_url($this->router->fetch_class().'/profile/'.$id) ,'refresh');
					}

					$this->form_validation->set_data($this->input->post());
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_is_owned_data[user.email.'.strtolower($this->session->userdata($this->router->fetch_class()).']'));
					$this->form_validation->set_rules('username', 'Nama Pengguna', 'trim|required|callback_is_owned_data[user.username.'.strtolower($this->session->userdata($this->router->fetch_class()).']'));
					$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');

					if ($this->form_validation->run() == TRUE)
					{
						$update_data = array(
							'email' => $this->input->post('email'),
							'username' => $this->input->post('username'),
							'full_name' => $this->input->post('full_name')
						);

						if (!empty($this->input->post('password')))
						{
							$update_data['password'] = sha1($this->input->post('password'));
						}

						if (!empty($_FILES['photo']))
						{
							$config['upload_path'] = './uploads/';
							$config['allowed_types'] = 'png|jpg|jpeg';
							$config['file_name'] = url_title('user-profile-'.$id);
							$this->load->library('upload', $config);

							if (!$this->upload->do_upload('photo'))
							{
								$this->session->set_flashdata('upload_photo_error', $this->upload->display_errors());
							}
							else
							{
								// resize
								$config['image_library']	= 'gd2';
								$config['source_image']		= $this->upload->data()['full_path'];
								$config['maintain_ratio']	= TRUE;
								$config['width']			= 160;
								$config['height']			= 160;
								// watermark
								$config['wm_text'] 			= strtolower($this->router->fetch_class());
								$config['wm_type'] 			= 'text';
								$config['wm_font_color'] 	= 'ffffff';
								$config['wm_font_size'] 	= 12;
								$config['wm_vrt_alignment'] = 'middle';
								$config['wm_hor_alignment'] = 'center';
								$this->load->library('image_lib', $config);

								if ($this->image_lib->resize())
								{
									$this->image_lib->watermark();
								}

								$update_data['photo'] = $this->upload->data()['file_name'];
							}
						}

						$this->user->update($update_data, array('id' => $id));
						$this->session->set_flashdata('edit_profile', array('status' => 'success', 'message' => 'Profil berhasil diperbaharui!'));
						redirect(base_url($this->router->fetch_class().'/profile/'.$id) ,'refresh');
					}
					else
					{
						$this->template->load('profile_edit', $data);
					}
				}
				else
				{
					$this->template->load('profile_edit', $data);
				}
			break;

			default:
				$this->template->load('profile', $data);
			break;
		}
	}

	public function project($option = 'view', $id = NULL)
	{
		$deadline = NULL;

		if (!empty($this->input->post('deadline')))
		{
			$deadline = explode('/', $this->input->post('deadline'));
			$deadline_available = array();
			foreach ($deadline as $dl)
			{
				if (!in_array($dl, ['dd', 'mm', 'yyyy']))
				{
					array_push($deadline_available, $dl);
				}
			}

			if (count($deadline_available) == 3)
			{
				$deadline = $deadline[2].'-'.$deadline[1].'-'.$deadline[0];
			}
			else
			{
				$deadline = NULL;
			}
		}

		if (!empty($id))
		{
			// update
			if ($this->input->method() == 'post')
			{
				$this->form_validation->set_rules('name', 'Nama Project', 'trim|required|max_length[40]');
				$this->form_validation->set_rules('category', 'Kategori Project', 'trim|required|integer', array('integer' => 'Bidang {field} dibutuhkan.'));
				$this->form_validation->set_rules('budget', 'Project Budget', 'trim|required|numeric');

				if ($this->form_validation->run() == TRUE)
				{
					$query = $this->project->update(array(
						'name' => $this->input->post('name'),
						'category' => $this->input->post('category'),
						'area' => $this->input->post('area'),
						'budget' => $this->input->post('budget'),
						'deadline' => $deadline
					), array('id' => $id));

					if ($query >= 1)
					{
						$this->session->set_flashdata('project', array('status' => 'success', 'message' => 'Project data updated success!'));
					}
					else
					{
						$this->session->set_flashdata('project', array('status' => 'success', 'message' => 'Failed to update project detail'));
					}

					redirect(base_url($this->router->fetch_class().'/project'), 'refresh');
				}
				else
				{
					$data['project'] = $this->project->read(array('id' => $id))->row();
					$data['projects_category'] = $this->project_category->read()->result();
					$this->template->load('project/edit', $data);
				}
			}
			else
			{
				// edit
				if ($option == 'edit')
				{
					$data['project'] = $this->project->read(array('id' => $id))->row();
					$data['projects_category'] = $this->project_category->read()->result();
					$this->template->load('project/edit', $data);
				}
				// delete
				else
				{
					$this->project->delete(array('id' => $id));
					$this->session->set_flashdata('project', array('status' => 'success', 'message' => 'Project deleted success!'));
					redirect(base_url($this->router->fetch_class().'/project'), 'refresh');
				}
			}
		}
		else
		{
			// create
			if ($this->input->method() == 'post')
			{
				$this->form_validation->set_rules('name', 'Nama Project', 'trim|required|max_length[40]');
				$this->form_validation->set_rules('category', 'Kategori Project', 'trim|required|integer', array('integer' => 'Bidang {field} dibutuhkan.'));
				$this->form_validation->set_rules('budget', 'Project Budget', 'trim|required|numeric');

				if ($this->form_validation->run() == TRUE)
				{
					$query = $this->project->create(array(
						'name' => $this->input->post('name'),
						'category' => $this->input->post('category'),
						'area' => $this->input->post('area'),
						'budget' => $this->input->post('budget'),
						'deadline' => $deadline
					));

					if ($query >= 1)
					{
						$this->session->set_flashdata('project', array('status' => 'success', 'message' => 'Project created success!'));
					}
					else
					{
						$this->session->set_flashdata('project', array('status' => 'failed', 'message' => 'Project created failed!'));
					}

					redirect(base_url($this->router->fetch_class().'/project'), 'refresh');
				}
				else
				{
					$data['projects_category'] = $this->project_category->read()->result();
					$this->template->load('project/add', $data);
				}
			}
			else
			{
				// create view
				if ($option == 'add')
				{
					$data['projects_category'] = $this->project_category->read()->result();
					$this->template->load('project/add', $data);
				}
				// read
				else
				{
					$data['projects'] = $this->project->read()->result();
					$data['projects_category'] = $this->project_category->read()->result();
					$this->template->load('project/home', $data);
				}
			}
		}
	}

	public function project_category($option = 'view', $id = NULL)
	{
		if (!empty($id))
		{
			// update
			if ($this->input->method() == 'post')
			{
				$this->project_category->update(array('name' => $this->input->post('name')), array('id' => $id));
				$this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'data' => $this->project_category->read(array('id' => $id))->row())));
			}
			else
			{
				// edit
				if ($option == 'view')
				{
					$this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'data' => $this->project_category->read(array('id' => $id))->row())));
				}
				// delete
				else
				{
					$this->project_category->delete(array('id' => $id));
					$this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'data' => $this->project_category->read(array('id' => $id))->row())));
				}
			}
		}
		else
		{
			// create
			if ($this->input->method() == 'post')
			{
				$this->project_category->create(array('name' => $this->input->post('name')));
				$this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'data' => $this->project_category->read()->result())));
			}
			else
			{
				// create view
				if ($option == 'add')
				{

				}
				// read
				else
				{
					$this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'data' => $this->project_category->read()->result())));
				}
			}
		}
	}

	public function criteria($option = 'view', $id = NULL)
	{
		if (!empty($id))
		{
			// update
			if ($this->input->method() == 'post')
			{
				$this->form_validation->set_rules('name', 'Criteria Name', 'trim|required|max_length[60]');
				$this->form_validation->set_rules('weight', 'Criteria Weight', 'trim|required');
				$this->form_validation->set_rules('attribute', 'Attribute', 'trim|required|in_list[cost,benefit]');

				if ($this->form_validation->run() == TRUE)
				{
					$query = $this->criteria->update(array(
						'name' => $this->input->post('name'),
						'weight' => $this->input->post('weight'),
						'attribute' => $this->input->post('attribute')
					), array('id' => $id));

					$this->session->set_flashdata('criteria', array('status' => 'success', 'message' => 'Criteria updated success!'));
					redirect(base_url($this->router->fetch_class().'/criteria'), 'refresh');
				}
				else
				{
					$data['criteria'] = $this->criteria->read(array('id' => $id))->row();
					$this->template->load('criteria/edit', $data);
				}
			}
			else
			{
				// edit
				if ($option == 'edit')
				{
					$data['criteria'] = $this->criteria->read(array('id' => $id))->row();
					$this->template->load('criteria/edit', $data);
				}
				// delete
				else
				{
					$this->criteria->delete(array('id' => $id));
					$this->session->set_flashdata('criteria', array('status' => 'success', 'message' => 'Criteria deleted success!'));
					redirect(base_url($this->router->fetch_class().'/criteria'), 'refresh');
				}
			}
		}
		else
		{
			// create
			if ($this->input->method() == 'post')
			{
				$this->form_validation->set_rules('name', 'Criteria Name', 'trim|required|max_length[60]');
				$this->form_validation->set_rules('weight', 'Criteria Weight', 'trim|required');
				$this->form_validation->set_rules('attribute', 'Attribute', 'trim|required|in_list[cost,benefit]');

				if ($this->form_validation->run() == TRUE)
				{
					$query = $this->criteria->create(array(
						'name' => $this->input->post('name'),
						'weight' => $this->input->post('weight'),
						'attribute' => $this->input->post('attribute')
					));

					$this->session->set_flashdata('criteria', array('status' => 'success', 'message' => 'Criteria added success!'));
					redirect(base_url($this->router->fetch_class().'/criteria'), 'refresh');
				}
				else
				{
					$this->template->load('criteria/add');
				}
			}
			else
			{
				// create view
				if ($option == 'add')
				{
					$this->template->load('criteria/add');
				}
				// read
				else
				{
					$data['criterias'] = $this->criteria->read()->result();
					$this->template->load('criteria/home', $data);
				}
			}
		}
	}

	public function saw_freelance($project_id = NULL)
	{
		if (!empty($project_id))
		{
			$this->template->load('saw_freelance/home');
		}
		else
		{
			show_404();
		}
	}

	public function is_owned_data($val, $str)
	{
		$str = explode('.', $str);
		$data = $this->db->get('user', array($str[1] => $val));
		if ($data->num_rows() >= 1)
		{
			if ($data->row()->id == $str[2])
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('is_owned_data', lang('form_validation_is_unique'));
				return FALSE;
			}
		}
		else
		{
			return TRUE;
		}

		return FALSE;
	}

	public function logout()
	{
		session_destroy();
		redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
	}

	public function register()
	{
		if ($this->input->method() == 'post')
		{
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]|max_length[40]', array('is_unique' => 'Email sudah terdaftar!'));
			$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required|max_length[40]');
			$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required');

			if ($this->form_validation->run() == TRUE)
			{
				$this->user->create(array(
					'email' => $this->input->post('email'),
					'password' => sha1($this->input->post('password')),
					'full_name' => $this->input->post('full_name')
				));

				$this->session->set_flashdata('register', array('status' => 'success', 'message' => 'Pendaftaran berhasil!!'));
				redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
			}
			else
			{
				$this->load->view('admin/register');
			}
		}
		else
		{
			$this->load->view('admin/register');
		}
	}

	public function forgot_password()
	{
		if ($this->input->method() == 'post')
		{
			$search = $this->user->search($this->input->post('identity'));

			if ($search->num_rows() >= 1)
			{
				$code = random_string('numeric', 6);
				$this->load->library('email');
				$this->email->set_alt_message('Reset password');
				$this->email->to($search->row()->email);
				$this->email->from('no-reply@medansoftware.my.id', 'Medan Software');
				$this->email->subject('Ganti Kata Sandi');
				$data['link'] = base_url($this->router->fetch_class().'/reset_password/'.$code);
				$data['code'] = $code;
				$data['full_name'] = $search->row()->full_name;
				$this->email->message($this->load->view('email/reset_password', $data, TRUE));
				if (!$this->email->send())
				{
					$this->session->set_flashdata('forgot_password', array('status' => 'failed', 'message' => 'Sistem tidak bisa mengirim email!'));
					redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('forgot_password', array('status' => 'success', 'message' => 'Email permintaan atur ulang kata sandi sudah dikirim, silahkan verifikasi <a href="'.base_url($this->router->fetch_class().'/email_confirm').'">disini</a>'));
					redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('forgot_password', array('status' => 'failed', 'message' => 'Sistem tidak menemukan akun!'));
				redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
			}
		}
		else
		{
			$this->load->view('admin/forgot_password');
		}
	}

	public function email_confirm()
	{
		echo 'Confirm Code';
	}

	public function reset_password($code = NULL)
	{
		echo 'Reset Password';
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */