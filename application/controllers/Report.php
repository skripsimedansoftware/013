<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('AlphaPDF');
		$this->load->model(['user', 'project', 'project_category', 'freelancer_project', 'criteria', 'alternative_data']);
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
			$this->alphapdf->CellFitScale(32, 8, "\t".number_format($project->budget, 2, ',', '.'), 1, 0, 'R');
			$this->alphapdf->CellFitScale(20, 8, "\t".nice_date($project->deadline, 'd/m/Y'), 1, 0, 'L');
			$this->alphapdf->CellFitScale(22, 8, "\t".$status, 1, 0, 'L');
			$this->alphapdf->Ln();
		}

		$this->alphapdf->Output();
	}

	public function saw($project_id = NULL)
	{
		$project_owner = NULL;
		$project_detail = $this->project->read(array('id' => $project_id));

		if ($project_detail->num_rows() >= 1)
		{
			$project_detail = $project_detail->row_array();
			$project_owner = $this->user->read(array('id' => $project_detail['owner']))->row_array();;
		}

		$saw = new Algorithm\SAW;

		foreach ($this->criteria->read()->result() as $criteria_key => $criteria) :
			$saw->addCriteria($criteria->attribute, $criteria->weight, $criteria->name);
		endforeach;

		$saw->addCriteria('cost', 2.5, 'Banyaknya proyek yang dikerjakan');

		foreach ($this->user->read(array('role' => 'freelancer'))->result() as $user) :
			$user_criteria = array();
			foreach ($this->criteria->read()->result() as $criteria) :
				array_push($user_criteria, $this->alternative_data->read(array('user_id' => $user->id, 'criteria_id' => $criteria->id))->row()->weight);
			endforeach;
			$user_project = $this->freelancer_project->count(array('user_id' => $user->id, 'rating' => NULL));

			if ($user_project == 0)
			{
				$user_project = 1;
			}

			array_push($user_criteria, $user_project);
			$saw->addAlternative((array) $user, $user_criteria);
		endforeach;


		$matrix_x = array(
			'assigned' => array(),
			'unassigned' => array()
		);

		$normalized_r = array(
			'matrix' => array(),
			'preference' => array(),
			'criteria' => array()
		);

		foreach ($saw->getCriteria()->get() as $criteria_key => $criteria)
		{
			$matrix_x['assigned'][$criteria_key] = array();
			$matrix_x['unassigned'] = array();

			$normalized_r['matrix'][$criteria_key] = array();

			foreach ($saw->getAlternative()->get() as $alternative_key => $alternative)
			{
				// unassigned alternative to criteria
				array_push($matrix_x['unassigned'], $alternative['criteria']);

				// assign alternative to criteria
				array_push($matrix_x['assigned'][$criteria_key], $saw->getAlternative()->get($alternative_key)['criteria'][$criteria_key]);
			}

			foreach ($matrix_x['assigned'][$criteria_key] as $row_x)
			{
				// benefit = max size
				if ($criteria['attribute'] == 'benefit')
				{
					array_push($normalized_r['matrix'][$criteria_key], round($row_x/max($matrix_x['assigned'][$criteria_key]), 2));
				}
				// cost = min size
				else
				{
					array_push($normalized_r['matrix'][$criteria_key], round(min($matrix_x['assigned'][$criteria_key])/$row_x, 2));
				}
			}
		}

		foreach ($saw->getAlternative()->get() as $alternative_key => $alternative)
		{
			foreach ($normalized_r['matrix'] as $normalized_key => $normalize)
			{
				array_push($normalized_r['preference'], $normalized_r['matrix'][$normalized_key][$alternative_key]);
			}
		}

		$normalized_r['preference'] = array_chunk($normalized_r['preference'], count($saw->getCriteria()->get()));

		foreach ($saw->getCriteria()->get() as $criteria_key => $criteria)
		{
			array_push($normalized_r['criteria'], $criteria['weight']);
		}

		$sum_prefrence = array();

		foreach ($normalized_r['preference'] as $pkey => $preference)
		{
			$sum_prefrence[$pkey] = array();
			foreach ($normalized_r['criteria'] as $ckey => $criteria)
			{
				array_push($sum_prefrence[$pkey], $preference[$ckey]*$criteria);
			}
		}

		for ($pkey = 0; $pkey < count($normalized_r['preference']); $pkey++)
		{
			$sum_prefrence[$pkey] = array();

			for ($ckey = 0; $ckey < count($normalized_r['criteria']); $ckey++)
			{
				array_push($sum_prefrence[$pkey], $normalized_r['preference'][$pkey][$ckey]*$normalized_r['criteria'][$ckey]);
			}
		}

		for ($i = 0; $i < count($sum_prefrence); $i++)
		{
			$sum_prefrence[$i] = array_sum($sum_prefrence[$i]);
		}

		$this->alphapdf->SetFillColor(255, 249, 247);

		$this->alphapdf->SetAuthor('KamiSpace');
		$this->alphapdf->SetTitle('Laporan Hasil Rekomendasi Freelancer');
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
		$this->alphapdf->Cell(60, 8, ":\tLaporan Hasil Rekomendasi Freelancer", 0, 0, 'L');

		$this->alphapdf->Ln(16); // Line Break

		$this->alphapdf->SetFont('Arial', 'B', 10);
		$this->alphapdf->Cell(40, 8, "\tNama Studio", 0, 0, 'L');

		$this->alphapdf->SetFont('Arial', '', 10);
		$this->alphapdf->Cell(60, 8, ":\t".$project_owner['full_name']);

		$this->alphapdf->Ln(8); // Line Break

		$this->alphapdf->SetFont('Arial', 'B', 10);
		$this->alphapdf->Cell(40, 8, "\tTanggal Deadline", 0, 0, 'L');

		$this->alphapdf->SetFont('Arial', '', 10);
		$this->alphapdf->Cell(60, 8, ":\t".nice_date($project_detail['deadline'], 'd F Y'), 0, 0, 'L');

		$this->alphapdf->Ln(8); // Line Break

		$this->alphapdf->SetFont('Arial', 'B', 10);
		$this->alphapdf->Cell(40, 8, "\tProyek", 0, 0, 'L');

		$this->alphapdf->SetFont('Arial', '', 10);
		$this->alphapdf->Cell(60, 8, ":\t".$project_detail['name']);

		$this->alphapdf->Ln(16); // Line Break

		$this->alphapdf->SetFont('Times', 'B', 10);
		$this->alphapdf->CellFitScale(16, 8, "\tKriteria", 1, 0, 'L');
		$this->alphapdf->CellFitScale(80, 8, "\tDeskripsi", 1, 0, 'L');
		$this->alphapdf->CellFitScale(22, 8, "\tBobot", 1, 0, 'L');
		$this->alphapdf->CellFitScale(26, 8, "\tAttribut", 1, 0, 'L');
		$this->alphapdf->Ln();

		$this->alphapdf->SetFont('Times', '', 10);

		foreach ($saw->getCriteria()->get() as $criteria_key => $criteria) :
			$this->alphapdf->CellFitScale(16, 8, "\tC".($criteria_key+1), 1, 0, 'C');
			$this->alphapdf->CellFitScale(80, 8, "\t".$criteria['name'], 1, 0, 'L');
			$this->alphapdf->CellFitScale(22, 8, "\t".$criteria['weight'], 1, 0, 'L');
			$this->alphapdf->CellFitScale(26, 8, "\t".$criteria['attribute'], 1, 0, 'L');
			$this->alphapdf->Ln();
		endforeach;

		$this->alphapdf->Ln(16); // Line Break

		$this->alphapdf->SetFont('Times', 'B', 10);

		$this->alphapdf->CellFitScale(20, 8, "\tRangking", 1, 0, 'L');
		$this->alphapdf->CellFitScale(60, 8, "\tNama Freelancer", 1, 0, 'L');
		foreach ($saw->getCriteria()->get() as $criteria_key => $criteria) :
			$this->alphapdf->CellFitScale(10.68, 8, "\tC".($criteria_key+1), 1, 0, 'C');
		endforeach;
		$this->alphapdf->CellFitScale(40, 8, "\tTotal Perhitungan SAW", 1, 0, 'L');
		$this->alphapdf->Ln();

		$this->alphapdf->SetFont('Times', '', 10);

		$sort_from_big = arsort($sum_prefrence);
		$rank = 1;
		foreach ($sum_prefrence as $key => $value) :
			$freelancer = array_merge($saw->getAlternative()->get($key), array('value' => $value));
			$project_has_rating = $this->freelancer_project->has_rating($freelancer['data']['id']);
			$project_on_going = $this->freelancer_project->on_going($freelancer['data']['id']);

			$this->alphapdf->CellFitScale(20, 8, "\t".$rank, 1, 0, 'C');
			$this->alphapdf->CellFitScale(60, 8, "\t".$freelancer['data']['full_name'], 1, 0, 'L');
			foreach ($freelancer['criteria'] as $freelancer_criteria) :
				$this->alphapdf->CellFitScale(10.68, 8, "\t".$freelancer_criteria, 1, 0, 'L');
			endforeach;
			$this->alphapdf->CellFitScale(40, 8, "\t".$value, 1, 0, 'L');
			$rank++;
			$this->alphapdf->Ln();
		endforeach;

		$this->alphapdf->Output('I', 'project-'.$project_detail['id']);
	}
}

/* End of file Report.php */
/* Location: ./application/controllers/Report.php */
