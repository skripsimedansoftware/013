# Skripsi - Codeigniter Starter :coffee:

## Template Loader

```php
$config = array(
	'module' => 'admin'
);
$this->load->library('template', $config);

```

### controllers/Admin.php

```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	/**
	 * constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$config = array(
			'module' => 'admin'
		);
		$this->load->library('template', $config);
	}

	public function index()
	{
		$data['title'] = 'Page Title';
		$this->template->load('home', $data);
	}
}
```

### views/admin/base.php

```html
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Base</title>
</head>
<body>
<?php echo $page; ?>
</body>
</html>
```

### views/admin/home.php

```html
<div class="row">Page Content Here</div>
```