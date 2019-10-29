<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<style>
	html,body,.container{
		height: 100%;
		width: 100%;
	}
	.header{
		background-color: black;
		color: white;
		height: 20%;
		width: 100%;
	}
	.content{
		height: 80%;
		width: 100%;
		display: block;
	}
	.content-tabs{
		width: 100%;
		background-color: rgb(240, 238, 233);
	}
	#frm_search{
		width: 100%;
	}
	.dashboard-image{
		width: 50%;
		height: 50%;
	}
</style>
</head>
<body>
	<div class="container">
		<div class="row header align-items-center">
			<div class="pl-5">
				<h1>Repo Statistics Using Github REST Api</h1>
			</div>	
		</div>
		<div class="row content">
			<div class="content-tabs p-3 border-bottom border-light">
				<h3>Cari Statistik</h3>
				<form class="mt-3" id="frm_search">
					<div>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Nama Organisasi, Perusahaan atau lainnya" aria-label="Recipient's username">
							<div class="input-group-append">
								<button class="btn btn-success">Cari Statistik</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="content-tabs p-3">
				<h3>Detail Organisasi</h3>
				<div class="row p-3">
					<div class="col">
						<div class="row align-items-center justify-content-center">
								<img class="dashboard-image" src="<?php echo base_url('images/icon_repo.png'); ?>">
						</div>		
					</div>
					<div class="col">
						<div class="row align-items-center justify-content-center">
						<img class="dashboard-image" src="<?php echo base_url('images/icon_project.png'); ?>">
						</div>
					</div>
					<div class="col">
						<div class="row align-items-center justify-content-center">
						<img class="dashboard-image" src="<?php echo base_url('images/icon_team_member.png'); ?>">	
						</div>
					</div>
				</div>
				<div class="row p-3">
					<div class="col">
						<div class="row justify-content-center">
							123 Repository
						</div>	
					</div>
					<div class="col">
						<div class="row justify-content-center">
							123 Project
						</div>	
					</div>
					<div class="col">
						<div class="row justify-content-center">
							123 Anggota Tim
						</div>	
					</div>			
				</div>
			</div>
		</div>
	</div>
</body>
</html>