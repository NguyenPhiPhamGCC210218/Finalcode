<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
   
</head>
<style>


h1 {
    text-align: center;
    padding: 20px;
    background-color: #333;
    color: #fff;
    margin: 0;
}

.container {
    width: 80%;
    margin: auto;
    padding: 20px;
}

section {
    margin-bottom: 40px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #4CAF50;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

p {
    text-align: center;
}

.btn {
    display: inline-block;
    padding: 8px 16px;
    margin: 4px 2px;
    background-color: #4CAF50;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 4px;
}

.btn:hover {
    background-color: #45a049;
}

</style>
<body>
<?php
    // session_start();
    include_once("connection.php"); 
?>

<script language="javascript">
        function deleteConfirm(){
                if(confirm("Are you sure to delete!"))
                    {
                        return true;
                    }
                else{
                    return false;
                }
            }
             </script>
             <?php
                include_once ("connection.php");
                if(isset($_GET["function"])=="del"){
                    if(isset($_GET["id"])){
                        $id =$_GET["id"];
                        mysqli_query($conn,"DELETE FROM category WHERE Cat_ID ='$id'");
                    }
                }
            ?>

            <style>
                th{
                     text-align: center;
                     font-size: 18px;
  }
  a{
    color: #000;
    text-decoration: none;
    font-weight: bold;
}

</style>
            <div class="container">
            <div class="coverblock">
        <form name="frm" method="post" action="">
            <a class="backhome" href="index.php">←Back to shop</a>
        <h1 class="h1manaCat">Management Product Category</h1>
        <p>
        <a href="?page=add_category" class="ManaAddCat"> <img src="./product-imgs/addicon.png" alt=""> Add Categogy</a>
        </p>
        <table id="tablecategory" class="table table-striped table-bordered"  cellspacing="0" width="100%" style="text-align: center; color:#000;">
            <thead>
                <tr>
                    <th><strong>No.</strong></th>
                    <th><strong>Category Name</strong></th>
                     <th><strong>Description</strong></th>
                    <th><strong>Edit</strong></th>
                    <th><strong>Delete</strong></th>
                </tr>
             </thead>
			<tbody>
            <?php
                $No=1;
                $result = mysqli_query($conn, "SELECT * FROM category");
                while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
                {
            ?>
			<tr>
              <td class="cotCheckBox"><?php echo $No; ?></td>
              <td><?php echo $row["Cat_Name"]; ?></td>
              <td><?php echo $row["Cat_Des"]; ?></td>
              <td style='text-align:center'><a href="?page=update_category&&id=<?php echo $row["Cat_ID"]; ?>">
              <img src='./product-imgs/editicon.png' border='0' /> Edit</a></td>

              <td style="text-align:center"><a href="?page=category_management&&function=del&&id=<?php echo $row["Cat_ID"]; ?>"
               onclick="return deleteConfirm()">
               <img src="./product-imgs/deleteicon.png" border='0' >Delete</a></td>
            </tr>
            <?php
                $No++;
                }
                ?>
		
			</tbody>
        </table>  
        

        
</body>
</html>