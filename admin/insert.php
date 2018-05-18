<?php
  require 'database.php';

  $nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";
  if(!empty($_POST))
  {
    $name                 = checkInput($_POST['name']);
    $description          = checkInput($_POST['description']);
    $price                = checkInput($_POST['price']);
    $category             = checkInput($_POST['category']);
    $image                = checkInput($_FILES['image']['name']);
    $imagePath            = '../images/' . basename($image);
    $imageExtension       = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess            = true;
    $isUploadSuccess      = false;

    if(empty($name)) {
      $nameError = 'Ce champ ne peut pas être vide';
      $isSucces = false;
    }
    if(empty($description)) {
      $nameError = 'Ce champ ne peut pas être vide';
      $isSucces = false;
    }
    if(empty($price)) {
      $nameError = 'Ce champ ne peut pas être vide';
      $isSucces = false;
    }
    if(empty($category)) {
      $nameError = 'Ce champ ne peut pas être vide';
      $isSucces = false;
    }
    if(empty($image)) {
      $nameError = 'Ce champ ne peut pas être vide';
      $isSucces = false;
    }
    else {
      $isUploadSuccess = true;
      if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
      {
        $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
        $isUploadSuccess = false;
      }
      if(file_exists($imagePath))
      {
        $imageError = "Le fichier existe deja";
        $isUploadSuccess = false;
      }
      if($_FILES["image"]["size"]> 500000)
      {
        $imageError = "Le fichier ne doit pas depasser les 500KB";
        $isUploadSuccess = false;
      }
      if($isUploadSuccess)
      {
        if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
        {
          $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
          $isUploadSuccess = false;
        }
      }
    }

    if($isSuccess && $isUploadSuccess)
    {
      $db = Database::connect();
      $statement = $db->prepare("INSERT INTO items (name,description,price,category,image) values(?,?,?,?,?)");
      $statement->execute(array($name,$description,$price,$category,$image));
      Database::disconnect();
      header("Location: index.php");
    }

  }

  function checkInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Code</title>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css" />
  </head>
  <body>
      <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>
      <div class="container admin">
        <div class="row">
            <h1><strong>Ajouter un item</strong></h1>
            <br />

            <!-- Début formulair"-->
            <form>
              <div class="form" action="insert.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                <span class="help-inline"><?php echo $nameError; ?></span>
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                <span class="help-inline"><?php echo $descriptionError; ?></span>
              </div>
              <div class="form-group">
                <label for="price">Prix: (en €)</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                <span class="help-inline"><?php echo $priceError; ?></span>
              </div>

              <!--Liste déroulante pour les catégories tres interessent-->
              <div class="form-group">
                <label for="category">Catégories</label>
                <select class="form-control" id="category" name="category">
                  <?php
                    $db = Database::connect();
                    foreach($db->query('SELECT * FROM categories') as $row)
                    {
                      echo '<option value="'.$row['id'].'">' . $row['name'] .'</option>';
                    }
                    Database::disconnect();
                  ?>
                </select>
                <span class="help-inline"><?php echo $categoryError; ?></span>
              </div>

              <!--input avec type ="file" pour avoir l'image-->
              <div class="form-group">
                <label for="image">Sélectionner une image</label>
                <input type="file" class="form-control" id="image" name="price">
                <span class="help-inline"><?php echo $imageError; ?></span>
              </div>

            <br />
            <div class="form-actions">
              <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
              <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
            </div>

          </form>
          <!--fin formulaire-->
          </div>
      </div>
  </body>
</html>
