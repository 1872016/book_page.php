<?php
	$submitPressed = filter_input(INPUT_POST, 'btnSubmit');
	if (isset($submitPressed)) {
		$isbn = filter_input(INPUT_POST, 'txtIsbn');
		$title = filter_input(INPUT_POST, 'txtTitle');
		$author = filter_input(INPUT_POST, 'txtAuthor');
		$publisher = filter_input(INPUT_POST, 'txtPublisher');
		$description = filter_input(INPUT_POST, 'txtDescription');
		$cover = filter_input(INPUT_POST, 'txtCover');
		$cat_Id = filter_input(INPUT_POST, 'txtCat_Id');
		$link = mysqli_connect('localhost','root','','pwl20194','3306')or die(mysqli_connect_error());
		$query = 'INSERT INTO book VALUES(?,?,?,?,?,?,?)';
		mysqli_autocommit($link, false);
		if ($stmt = mysqli_prepare($link, $query)) {
			mysqli_stmt_bind_param($stmt, 'ssssssi', $isbn, $title, $author, $publisher, $description, $cover, $cat_Id);
			mysqli_stmt_execute($stmt) or die(msqli_error($link));
			mysqli_commit($link);
			mysqli_stmt_close($stmt);
		}
		mysqli_close($link);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Book Page</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.js"></script>
</head>
<body>
<form action="" method="post">
	<div class="form-group">
		<label for="bookIsbn">ISBN</label>
		<input type="text" class="form-control" id="bookIsbn" name="txtIsbn">
		<label for="bookTitle">Title</label>
		<input type="text" class="form-control" id="bookTitle" name="txtTitle">
		<label for="bookAuthor">Author</label>
		<input type="text" class="form-control" id="bookAuthor" name="txtAuthor">
		<label for="bookPublisher">Publisher</label>
		<input type="text" class="form-control" id="bookPublisher" name="txtPublisher">
		<label for="bookDescription">Description</label>
		<input type="text" class="form-control" id="bookDescription" name="txtDescription">
		<label for="bookCover">Cover</label>
		<input type="text" class="form-control" id="bookCover" name="txtCover">
		<label for="bookCat_Id">Category_id</label>
		<input type="text" class="form-control" id="bookCat_Id" name="txtCat_Id">
	</div>
	<input type="submit" name="btnSubmit" class="btn btn-default">
</form>
<br>
<table id="myTable" class="display">
	<thead>
		<tr>
			<th>ISBN</th>
			<th>Title</th>
			<th>Author</th>
			<th>Publisher</th>
			<th>Description</th>
			<th>Cover</th>
			<th>Category_id</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$link = mysqli_connect('localhost','root','','pwl20194','3306')
			or die(mysqli_connect_error());
			$query = 'SELECT * FROM book';
			if ($result = mysqli_query($link, $query) or die(mysqli_error($link))) {
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>";
					echo "<td>" . $row['isbn'] . "</td>";
					echo "<td>" . $row['title'] . "</td>";
					echo "<td>" . $row['author'] . "</td>";
					echo "<td>" . $row['publisher'] . "</td>";
					echo "<td>" . $row['description'] . "</td>";
					echo "<td>" . $row['cover'] . "</td>";
					echo "<td>" . $row['category_id'] . "</td>";
					echo "</tr>";
				}
				mysqli_close($link);
			}
		?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready( function () {
    	$('#myTable').DataTable();
	} );
</script>
</body>
</html>