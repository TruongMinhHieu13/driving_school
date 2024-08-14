<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>In thẻ tập lái</title>
	<style>
		body {font-family: 'Times New Roman', sans-serif;font-size: 10px;position: relative;margin: 0;}
		.wrap-content {max-width: 874px;margin: 0 auto;}
		.grid-card {display: grid; grid-template-columns: repeat(2, 1fr); grid-gap: 5px;}
		.items-card {border: 4px solid #000;display: inline-block;margin: 5px 0;}
		.header-card { text-align: center; padding: 10px; font-weight: 500; border-bottom: 3px solid; }
		.header-card p { margin-top: 0; margin-bottom: 5px; }
		.header-card p:nth-child(2) { margin-bottom: 0; }
		.pic-3x4 { width: 113.386px; height: 151.181px; border: 2px solid; }
		.information { width: calc(100% - 130px); }
		.in4-student { display: flex; justify-content: space-between; align-items: center; }
		.in4-student {padding: 8px;}
		.name, .title { font-weight: 700; font-size: 16px; margin-bottom: 12px; }
		.name { margin: 20px 0; }
		.btn-print a {background: #ffc107 linear-gradient(180deg, #ffca2c, #ffc107) repeat-x !important;padding: .25rem .5rem;font-size: .875rem;line-height: 1.5;border-radius: .2rem;font-family: 'Arial';min-width: 150px;display: inline-block;text-align: center;cursor: pointer;}
		.btn-print {position: sticky;top: 0;z-index: 11;background: #fff;padding: 5px 0;box-shadow: 0 7px 10px #ccc;}
		@media print {
			.no-print { display: none; }
		}
	</style>
</head>
	<body>
		<div class="page-print">
			<div class="btn-print no-print">
				<div class="wrap-content">
					<a class="btn btn-sm bg-gradient-warning text-dark ml-1" onclick="window.print();" title="Print"><i class="fa-solid fa-print mr-1"></i>In thẻ</a>
					</div>
			</div>
		
		</div>
	</body>
</html>