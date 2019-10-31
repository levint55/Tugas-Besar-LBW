<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/e23a4bb5fc.js" crossorigin="anonymous"></script>
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
				<form class="mt-3" id="frm_search" method="POST" action="form_submit">
					<div>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Nama Organisasi, Perusahaan atau lainnya" aria-label="Recipient's username" name="org_name">
							<div class="input-group-append">
								<button class="btn btn-success">Cari Statistik</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="content-tabs p-3">
				<h3>Detail Organisasi</h3>
				<?php 
					if(isset($datas)){
						echo "<div class='alert alert-light' role='alert'>Menampilkan Detail Organisasi yang dicari</div>";
					}
				?>
				<div class="row">
					<div class="col">
						<div class="card">
							<div class="row align-items-center justify-content-center">
							<span style="font-size: 5em"><i class="fas fa-code-branch"></i></span>
						</div>
						<div class="card-body" style="text-align: center">
							<?php 
								//isi array datas:
								//indeks ke-0 : data repo
								//indeks ke-1 : data proyek
								//indeks ke-2 : data anggota
								if(isset($datas)){
									echo sizeof($datas[0])." Repository";
								}else{
									echo "Temukan repository yang ada";
								} 
							?>
						</div>	
						</div>		
					</div>
					<div class="col">
						<div class="card">
						<div class="row align-items-center justify-content-center">
						<span style="font-size: 5em"><i class="fas fa-tasks"></i></span>
						</div>
						<div class="card-body" style="text-align: center">
							<?php 
								//isi array datas:
								//indeks ke-0 : data repo
								//indeks ke-1 : data proyek
								//indeks ke-2 : data anggota
								if(isset($datas)){
									echo sizeof($datas[1])." Proyek";
								}else{
									echo "Temukan Proyek-proyek yang ada";
								} 
							?>
						</div>
						</div>
					</div>
					<div class="col">
						<div class="card">
						<div class="row align-items-center justify-content-center">
						<span style="font-size: 5em"><i class="fas fa-user-friends"></i></span>
						</div>
						<div class="card-body" style="text-align: center">
							<?php 
								//isi array datas:
								//indeks ke-0 : data repo
								//indeks ke-1 : data proyek
								//indeks ke-2 : data anggota
								if(isset($datas)){
									echo sizeof($datas[2])." Anggota";
								}else{
									echo "Temukan orang-orang yang berkontribusi";
								} 
							?>
						</div>
						</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="p-2">
					<strong>Klik salah satu untuk informasi lebih lanjut</strong>
					</div>
				</div>
			</div>
			<div class="content-tabs p-3">
				<h3>Daftar Repository</h3>
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Id Repository</th>
      						<th scope="col">Nama Repository</th>
      						<th scope="col">Tanggal</th>
      						<th scope="col">Lain</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>