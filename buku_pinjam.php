<?php include "config.php"?>

<?php
//koneksi database
  $server = "localhost";
  $user = "root";
  $pass = "";
  $database = "perpustakaan";

  $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

  //tombol simpan
  if(isset($_POST['bsimpan']))
  {

    //edit or new
    if($_GET['hal'] == "edit")
    {
      //edit
      $edit = mysqli_query($koneksi, "UPDATE buku_pinjam set
                        No_Buku = '$_POST[No_Buku]',
                        Judul = '$_POST[Judul]',
                        Pengarang = '$_POST[Pengarang]',
                        Penerbit = '$_POST[Penerbit]'
                        Tahun_Terbit = '$_POST[Tahun_Terbit]'
                        WHERE buku_pinjam = '$_GET[buku_pinjam]'
                       ");
      if($edit) //finish edit
      {
        echo "<script>
            alert('Edit data suksess!');
            document.location='buku_pinjam.php';
          </script>";
      }
      else
      {
        echo "<script>
            alert('Edit data GAGAL!!');
            document.location='buku_pinjam.php';
          </script>";
      }
    }else
    {
      //new
      $simpan = mysqli_query($koneksi, "INSERT INTO sewa (No_Buku, Judul, Pengarang, Penerbit, Tahun_Terbit)
                      VALUES
                        ('$_POST[No_Buku]',
                          '$_POST[Judul]',
                          '$_POST[Pengarang]',
                          '$_POST[Penerbit]',
                          '$_POST[Tahun_Terbit]',
                    ");
      if($simpan)
      {
        echo "<script>
            alert('Simpan data suksess!');
            document.location='buku_pinjam.php';
          </script>";
      }
      else
      {
        echo "<script>
            alert('Simpan data GAGAl!!');
            document.location='buku_pinjam.php';
          </script>";
      }
    }

  }

  //Hapus
  if(isset($_GET['hal']))
  {
    //hapus data
    if ($_GET['hal'] == "hapus")
     {
      //hapus
      $hapus = mysqli_query($koneksi, "DELETE  FROM buku_pinjam WHERE No_Buku = '$_GET[No_bBku]' ");
      if($hapus) 
      {
        echo "<script>
        alert ('Hapus data Suksess!!!!');
        </script>";  
      }
    }
    
  }

  //edit
  if(isset ($_GET['hal']))
  {
      //tampilan data yang diedit
    if ($_GET['hal'] == "edit")
    {
        $tampil = mysqli_query($koneksi, "SELECT * FROM buku_pinjam WHERE no_buku = '$_GET[no_buku]' ");
        $data = mysqli_fetch_array($tampil);
        if($data)
        {
            $vId_Sewa = $data['No_Buku'];
            $vId_Cst = $data['Judul'];
            $vId_Mobil = $data['Pengarang'];
            $vTgl_transaksi = $data['Penerbit'];
            $vPembayaran = $data['Tahun_Terbit'];
        }
    }
  }
?>

<!doctype html><html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
    <a class="navbar-brand text-white" href="#">SELAMAT DATANG <b>ADMIN PERPUSTAKAAN (ROSE ROSITA)</b></a>
      <form class="form-inline my-2 my-lg-0 ml-auto">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Search</button>
      </form>
  </nav>

  <div class="row no-gutters mt-5">

    <div class="col-md-2 bg-warning mt-2 pr-3">
      <ul class="nav flex-column ml-3 mb-5">
        <li class="nav-item">
          <a class="nav-link active text-dark text-bold" href="dashboard.php"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="mahasiswa.php"><i class="fas fa-users mr-2"></i>Mahasiswa</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link active text-dark" href="kap.php"><i class="fas fa-user mr-2"></i>KAP</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link active text-dark" href="buku_pinjam.php"><i class="fas fa-car mr-2"></i>Buku Pinjam</a><hr class="bg-secondary">
        </li>
      </ul>
    </div>

    <div class="col-md-10 p-5 pt-2">
       <h3><i class="fas fa-paper-plane mr-2"></i>PEMINJAMAN</h3><hr>
       <table class="table table-striped table-bordered text-center">
          <thead class="bg-dark text-white">
            <tr>
              <th scope="col">No Buku</th>
              <th scope="col">Judul</th>
              <th scope="col">Pengarang</th>
              <th scope="col">Penerbit</th>
              <th scope="col">Tahun Terbit</th>
              <th colspan="6" scope="col">Aksi</th>
            </tr>
          </thead>
          <?php
            $no =1;
            $tampil = mysqli_query($koneksi, "SELECT * from buku_pinjam order by no_buku desc");
            while($data = mysqli_fetch_array($tampil)) :
          ?>
          <tbody>
            <tr>
              <td><?=$no++;?></td>
              <td><?=$data['no_buku'];?></td>
              <td><?=$data['judul'];?></td>
              <td><?=$data['pengarang'];?></td>
              <td><?=$data['penerbit'];?></td>
              <td><?=$data['tahun_terbit'];?></td>
              <td><a href="buku_pinjam.php?hal=edit&no_buku=<?=$data['no_buku']?>" class = "bg-warning p-2 text-white rounded" data-toggle="tooltip" title="edit">Edit</a></td>
              <td><a href="buku_pinjam.php?hal=hapus&no_buku=<?=$data['no_buku']?>" class = "bg-danger p-2 text-white rounded" data-toggle="tooltip" title="hapus">Hapus</a></td>
            </tr>
          </tbody>
          <?php endwhile; ?>
      </table>
      
      <div class="container">
      <div class="card">
          <div class="card-header text-center text-white bg-dark">
              TAMBAH DATA BUKU PINJAM
          </div>
          <div class="card-body">
              <form method="post" action="">
                  <div class="form-group">
                      <label>No Buku</label>
                      <input type="text" name="no_buku" value="<?=@$vno_buku?>" class="form-control" placeholder="Inputkan no_buku anda" required>
                      <label>Judul</label>
                      <input type="text" name="judul" value="<?=@$vjudul?>" class="form-control" placeholder="Inputkan judul anda" required>
                      <label>Pengarang</label>
                      <input type="text" name="pengarang" value="<?=@$vpengarang?>" class="form-control" placeholder="Inputkan pengarang anda" required>
                      <label>Penerbit</label>
                      <input type="text" name="penerbit" value="<?=@$vpenerbit?>" class="form-control" placeholder="Inputkan penerbit anda" required>
                      <label>Tahun Terbit</label>
                      <input type="text" name="tahun_terbit" value="<?=@$vtahun_terbit?>" class="form-control" placeholder="Inputkan tahun_terbit anda" required>
                    <button type="submit" class="btn btn-warning text-white" name="bsimpan">Simpan</button>
			  		        <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
              </form>
          </div>
      </div>

    </div>

  </div>

  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="admin.js"></script>
</body>
</html>