<?php include "config.php"?>

<?php
//koneksi database
  $server = "localhost";
  $user = "root";
  $pass = "";
  $database = "rental_mobil";

  $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

  //tombol simpan
  if(isset($_POST['bsimpan']))
  {

    //edit or new
    if($_GET['hal'] == "edit")
    {
      //edit
      $edit = mysqli_query($koneksi, "UPDATE customer set
                        Id = '$_POST[Id]',
                        Nama_Cst = '$_POST[Nama_Cst]',
                        Alamat = '$_POST[Alamat]'
                        WHERE Id = '$_GET[Id]'
                       ");
      if($edit) //finish edit
      {
        echo "<script>
            alert('Edit data suksess!');
            document.location='customer.php';
          </script>";
      }
      else
      {
        echo "<script>
            alert('Edit data GAGAL!!');
            document.location= 'customer.php';
          </script>";
      }
    }else
    {
      //new
      $simpan = mysqli_query($koneksi, "INSERT INTO customer (Id, Nama_Cst, Alamat)
                      VALUES ('$_POST[Id]',
                              '$_POST[Nama_Cst]',
                              '$_POST[Alamat]')
                    ");
      if($simpan)
      {
        echo "<script>
            alert('Simpan data suksess!');
            document.location='customer.php';
          </script>";
      }
      else
      {
        echo "<script>
            alert('Simpan data GAGAl!!');
            document.location='customer.php';
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
      $hapus = mysqli_query($koneksi, "DELETE  FROM customer WHERE Id = '$_GET[Id]' ");
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
        $tampil = mysqli_query($koneksi, "SELECT * FROM customer WHERE Id = '$_GET[Id]' ");
        $data = mysqli_fetch_array($tampil);
        if($data)
        {
            $vId = $data['Id'];
            $vNama_Cst = $data['Nama_Cst'];
            $vAlamat = $data['Alamat'];
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
    <a class="navbar-brand text-white" href="#">SELAMAT DATANG <b>ADMIN RENTAL MOBIL (SYAHRUL  ROMADHONI)</b></a>
      <form class="form-inline my-2 my-lg-0 ml-auto">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Search</button>
      </form>

      
    </div>
  </nav>

  <div class="row no-gutters mt-5">

    <div class="col-md-2 bg-warning mt-2 pr-3">
      <ul class="nav flex-column ml-3 mb-5">
        <li class="nav-item">
          <a class="nav-link active text-dark text-bold" href="dashboard.php"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="customer.php"><i class="fas fa-users mr-2"></i>Customer</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link active text-dark" href="karyawan.php"><i class="fas fa-user mr-2"></i>Karyawan</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link active text-dark" href="mobil.php"><i class="fas fa-car mr-2"></i>Mobil</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="sewa.php"><i class="fas fa-paper-plane mr-2"></i>Sewa</a><hr class="bg-secondary">
        </li>
      </ul>
    </div>

    <div class="col-md-10 p-5 pt-2">
       <h3><i class="fas fa-users mr-2"></i>CUSTOMER</h3><hr>
       <table class="table table-striped table-bordered text-center ">
          <thead class="bg-dark text-white">
            <tr>
              <th scope="col">No</th>
              <th scope="col">Id Customer</th>
              <th scope="col">Nama</th>
              <th scope="col">Alamat</th>
              <th colspan="3" scope="col">Aksi</th>
            </tr>
          </thead>
          <?php
            $no =1;
            $tampil = mysqli_query($koneksi, "SELECT * from customer order by Id desc");
            while($data = mysqli_fetch_array($tampil)) :
          ?>
          <tbody>
            <tr>
              <td><?=$no++;?></td>
              <td><?=$data['Id'];?></td>
              <td><?=$data['Nama_Cst'];?></td>
              <td><?=$data['Alamat'];?></td>
              <td><a href="customer.php?hal=edit&Id=<?=$data['Id']?>" class = "bg-warning p-2 text-white rounded" data-toggle="tooltip" title="edit">Edit</a></td>
              <td><a href="customer.php?hal=hapus&Id=<?=$data['Id']?>" class = "bg-danger p-2 text-white rounded" data-toggle="tooltip" title="hapus">Hapus</a></td>
            </tr>
          </tbody>
          <?php endwhile; ?>
      </table>

    <!-- Awal Tambah Data-->  
    <div class="container">
    <div class="card">
        <div class="card-header text-center text-white bg-dark">
            TAMBAH DATA CUSTOMER
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label>Id</label>
                    <input type="text" name="Id" value="<?=@$vId?>" class="form-control" placeholder="Inputkan Id anda" required>
                    <label>Nama</label>
                    <input type="text" name="Nama_Cst" value="<?=@$vNama_Cst?>" class="form-control" placeholder="Inputkan Nama anda" required>
                    <label>Alamat</label>
                    <input type="text" name="Alamat" value="<?=@$vAlamat?>" class="form-control" placeholder="Inputkan Alamat anda" required>
                </div>
                <button type="submit" class="btn btn-warning text-white" name="bsimpan">Simpan</button>
			  		    <button type="reset" class="btn btn-danger text-white" name="breset">Kosongkan</button>

            </form>          
        </div>
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