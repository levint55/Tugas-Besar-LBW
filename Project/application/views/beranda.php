
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/e23a4bb5fc.js" crossorigin="anonymous"></script>
	<script>
		var statButton;
		$(document).ready(function(){
			$(".show-stat").click(function(e){
				statButton  = e.target;
				console.log(statButton.getAttribute('data-id'));

				$("#org_details").removeClass("d-none");
				$("#org_table").addClass("d-none");
			});
			$("#btn_org_table").click(function(){
				$("#org_details").addClass("d-none");
				$("#org_table").removeClass("d-none");
			});
		});
	</script>
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
			<div class="content-tabs p-3 border-bottom border-light" id="org_table">
				<h3>Daftar Organisasi</h3>
				<form class="mt-3" id="frm_search" method="POST" action="Welcome/form_submit">
					<div>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Nama Organisasi, Perusahaan atau lainnya" aria-label="Recipient's username" name="org_name">
							<div class="input-group-append">
								<button class="btn btn-success">Tambahkan Organisasi</button>
							</div>
						</div>
					</div>
				</form>
				<br>
				<table class="table table-hover" style="background-color: white">
					<thead>
						<tr>
							<th scope="col">Id</th>
							<th scope="col">Query</th>
      						<th scope="col">Nama Lengkap Organisasi</th>
      						<th scope="col">Follower</th>
      						<th scope="col">Following</th>
      						<th scope="col">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i = 1;
							if (is_array($rows) || is_object($rows))
							{
								foreach($rows as $row){
									echo "<tr>";
									echo "<td>".$row['id']."</td>";
									echo "<td>".$row['name']."</td>";
									echo "<td>".$row['full_name']."</td>";
									echo "<td>".$row['follower']."</td>";
									echo "<td>".$row['following']."</td>";
									echo "<td><i style='font-size:2em' data-id=".$row['id']." class='fas fa-info-circle show-stat'></i></td>";
									echo "</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<div class="content-tabs p-3 d-none" id="org_details">
				<h3>Detail Organisasi</h3>
				<div class='alert alert-light' role='alert'>
					<div class="row align-items-center">
						<div class="col">
						Menampilkan Detail Organisasi yang dicari
						</div>
						<div class="col">
							<div class="row justify-content-end mr-1">
								<button id="btn_org_table" class="btn btn-success">Kembali Ke Daftar Organisasi</button>
							</div>						
						</div>
					</div>
				</div>
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
			<div class="content-tabs p-3 d-none">
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