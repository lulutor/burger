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
          <h1><strong>Liste des items </strong><a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span>Ajouter</a></h1>
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Catégories</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              <?php
                require 'database.php';
                $db = Database::connect();
                $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name
                   AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC');
                while($item = $statement->fetch()) {
                  echo '<tr>';
                  echo '<td>' . $item['name'] . '</td>';
                  echo '<td>' . $item['description'] . '</td>';
                  echo '<td>' . number_format((float)$item['price'],2,'.','') . '</td>';
                  echo '<td>' . $item['category'] . '</td>';
                  echo '<td width=300>';
                  echo '<a class="btn btn-default" href="view.php?id=' . $item['id'] . '"><span class="glyphicon glyphicon-eye-open"></span>Voir</a>';
                  echo '<a class="btn btn-primary" href="update.php?id=' . $item['id'] . '"><span class="glyphicon glyphicon-eye-pencil"></span>Modifier</a>';
                  echo '<a class="btn btn-danger" href="delete.php?id=' . $item['id'] . '"><span class="glyphicon glyphicon-eye-remove"></span>Suprimer</a>';
                  echo '</td>';
                  echo '</tr>';
                }
                Database::disconect();
               ?>

            </tbody>
          </table>
        </div>
      </div>
  </body>
</html>
