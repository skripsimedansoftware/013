<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('AlphaPDF');
		$this->load->model(['user', 'project', 'project_category', 'freelancer_project']);
	}

	public function index($user = 'admin', $user_id = NULL, $filter = NULL)
	{
		/**
		 * Refrence image background : http://www.fpdf.org/en/script/script74.php
		 */

		$user_info = $this->user->read(array('id' => $user_id));

		if ($user_info->num_rows() >= 1)
		{
			$user_info = $user_info->row_array();
		}

		$this->alphapdf->SetAuthor('KamiSpace');
		$this->alphapdf->SetTitle('Laporan Daftar Projek');
		$this->alphapdf->AddPage();
		// $this->alphapdf->SetLineWidth(1.5);
		$this->alphapdf->Image(FCPATH.'LAPORAN.jpg', 2, 6, 206, 284);

		// restore full opacity
		$this->alphapdf->SetAlpha(1);
		$this->alphapdf->Ln(48.8);

		// print name
		$this->alphapdf->SetFont('Arial', 'B', 10);
		$this->alphapdf->Cell(40, 8, "\tHal", 0, 0, 'L');

		$this->alphapdf->SetFont('Arial', '', 10);
		$this->alphapdf->Cell(60, 8, ":\tLaporan Daftar Projek", 0, 0, 'L');

		$this->alphapdf->Ln(8); // Line Break

		$this->alphapdf->SetFont('Arial', 'B', 10);
		$this->alphapdf->Cell(40, 8, "\tTanggal", 0, 0, 'L');

		$this->alphapdf->SetFont('Arial', '', 10);
		$this->alphapdf->Cell(60, 8, ":\t".date('d F Y'), 0, 0, 'L');

		$this->alphapdf->Ln(8); // Line Break

		$this->alphapdf->SetFont('Arial', 'B', 10);
		$this->alphapdf->Cell(40, 8, "\tNama ".ucfirst($user), 0, 0, 'L');

		$this->alphapdf->SetFont('Arial', '', 10);
		$this->alphapdf->Cell(60, 8, ":\t".$user_info['full_name'], 0, 0, 'L');
		$this->alphapdf->Ln(16); // Line Break

		$this->alphapdf->SetFont('Times', 'B', 10);
		$this->alphapdf->CellFitScale(10, 8, "\tNo", 1, 0, 'L');
		$this->alphapdf->CellFitScale(24, 8, "\tNama Projek", 1, 0, 'L');
		$this->alphapdf->CellFitScale(26, 8, "\tStudio", 1, 0, 'L');
		$this->alphapdf->CellFitScale(22, 8, "\tCategory", 1, 0, 'L');
		$this->alphapdf->CellFitScale(26, 8, "\tArea", 1, 0, 'L');
		$this->alphapdf->CellFitScale(40, 8, "\tBudget", 1, 0, 'L');
		$this->alphapdf->CellFitScale(20, 8, "\tDeadline", 1, 0, 'L');
		$this->alphapdf->CellFitScale(22, 8, "\tStatus", 1, 0, 'L');
		$this->alphapdf->Ln();

		$this->alphapdf->SetFont('Times', '', 10);

		switch ($user)
		{
			case 'studio':
				$query = $this->project->read(array('owner' => $user_id))->result();
			break;

			case 'freelancer':
				$freelancer_project = array();
				$project = $this->freelancer_project->read(array('user_id' => $user_id))->result();

				if (!empty($project))
				{
					foreach ($project as $value)
					{
						array_push($freelancer_project, $value->project_id);
					}

					$query = $this->project->in($freelancer_project)->result();
				}
				else
				{
					$query = array();
				}
			break;

			default:
				if (!empty($filter))
				{
					if ($filter == 'except-completed')
					{
						$query = $this->project->except_completed()->result();
					}
					elseif ($filter == 'only-completed')
					{
						$query = $this->project->only_completed()->result();
					}
				}
				else
				{
					$query = $this->project->read()->result();
				}
			break;
		}

		foreach ($query as $key => $project)
		{
			$studio = $this->user->read(array('id' => $project->owner));

			if ($studio->num_rows() >= 1)
			{
				$studio = $studio->row()->full_name;
			}
			else
			{
				$studio = '-';
			}

			$category = $this->project_category->read(array('id' => $project->category));
			$category = ($category->num_rows() >= 1) ? $category->row()->name : '-';

			$status = '-';

			if ($project->status == 'search-freelance')
			{
				$status = 'Mencari Pekerja';
			}
			elseif ($project->status == 'pending')
			{
				$status = 'Menunggu Konfirmasi';
			}
			elseif ($project->status == 'canceled')
			{
				$status = 'Dibatalkan';
			}
			elseif ($project->status == 'in-progress')
			{
				$status = 'Dalam Proses';
			}
			elseif ($project->status == 'not-completed')
			{
				$status = 'Tidak Selesai';
			}
			else
			{
				$status = 'Selesai';
			}

			$this->alphapdf->CellFitScale(10, 8, "\t".($key+1), 1, 0, 'L');
			$this->alphapdf->CellFitScale(24, 8, "\t".$project->name, 1, 0, 'L');
			$this->alphapdf->CellFitScale(26, 8, "\t".$studio, 1, 0, 'L');
			$this->alphapdf->CellFitScale(22, 8, "\t".$category, 1, 0, 'L');
			$this->alphapdf->CellFitScale(26, 8, "\t".$project->area.' m2', 1, 0, 'L');
			$this->alphapdf->CellFitScale(8, 8, "\tIDR", 1, 0, 'L');
			$this->alphapdf->CellFitScale(32, 8, "\t".number_format($project->budget, 2), 1, 0, 'R');
			$this->alphapdf->CellFitScale(20, 8, "\t".nice_date($project->deadline, 'd/m/Y'), 1, 0, 'L');
			$this->alphapdf->CellFitScale(22, 8, "\t".$status, 1, 0, 'L');
			$this->alphapdf->Ln();
		}

		$this->alphapdf->Output();
	}
}

/* End of file Report.php */
/* Location: ./application/controllers/Report.php */
