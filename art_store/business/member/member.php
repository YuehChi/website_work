<!DOCTYPE html>
<?php
	header("Content-Type: text/html; charset=utf-8");
	include("connMysql.php");
	$seldb = @mysqli_select_db($db_link, "final");
	if (!$seldb) die("資料庫選擇失敗！");

	//預設每頁筆數
	$pageRow_records = 5;
	//預設頁數
	$num_pages = 1;
	//若已經有翻頁，將頁數更新
	if (isset($_GET['page'])) {
	  $num_pages = $_GET['page'];
	}
	//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
	$startRow_records = ($num_pages -1) * $pageRow_records;
	//未加限制顯示筆數的SQL敘述句
	$sql_query = "SELECT * FROM `member`";
	//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
	$sql_query_limit = $sql_query." LIMIT ".$startRow_records.", ".$pageRow_records;
	//以加上限制顯示筆數的SQL敘述句查詢資料到 $result 中
	$result = mysqli_query($db_link, $sql_query_limit);
	//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_result 中
	$all_result = mysqli_query($db_link, $sql_query);
	//計算總筆數
	$total_records = mysqli_num_rows($all_result);
	//計算總頁數=(總筆數/每頁筆數)後無條件進位。
	$total_pages = ceil($total_records/$pageRow_records);
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>member</title>
		<link rel="stylesheet" type="text/css" href="../../css/b_in.css">
  </head>
  <body>
  	<p id="topic">會員資料</h1>
		<div>
			<p><a href="../content.php">回管理主頁</a></p>
			<p><a href="member_add.php">新增會員資料</a></p>
			<p>資料數：<?php echo $total_records;?></p>
			
		</div>

		<div id="show">
			<table id = "tb" align="center">
			  <!-- 表格表頭 -->
			  <tr>
			    <th class = "content">id</th>
			    <th class = "content">姓名&nbsp</th>
			    <th class = "content">生日&nbsp</th>
			    <th class = "content">帳號&nbsp</th>
			    <th class = "content">密碼&nbsp</th>
			    <th class = "content">性別&nbsp</th>
			    <th class = "content">Email&nbsp</th>
			    <th class = "content">電話&nbsp</th>
			    <th class = "content">地址&nbsp</th>
			  </tr>
		<!-- 資料內容 -->
		<?php
			while($row_result=mysqli_fetch_assoc($result)){
				echo "<tr>";
				echo "<td>".$row_result["id"]."</td>";
				echo "<td>".$row_result["name"]."</td>";
				echo "<td>".$row_result["birthday"]."</td>";
				echo "<td>".$row_result["account"]."</td>";
				echo "<td>".$row_result["password"]."</td>";
				echo "<td>".$row_result["sex"]."</td>";
				echo "<td>".$row_result["email"]."</td>";
				echo "<td>".$row_result["phone"]."</td>";
				echo "<td>".$row_result["address"]."</td>";
				echo "<td><a href='member_update.php?id=".$row_result["id"]."'>&nbsp修改</a> ";
				echo "<a href='member_delete.php?id=".$row_result["id"]."'>&nbsp刪除</a></td>";
				echo "</tr>";
			}
		?>
			</table>
			<br>
			<table align="center">
	  		<tr>
		    <?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
		    <td><a href="member.php?page=1">第一頁</a></td>
		    <td><a href="member.php?page=<?php echo $num_pages-1;?>">上一頁</a></td>
		    <?php } ?>
		    <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
		    <td><a href="member.php?page=<?php echo $num_pages+1;?>">下一頁&nbsp</a></td>
		    <td><a href="member.php?page=<?php echo $total_pages;?>">尾頁</a></td>
		    <?php } ?>
			  </tr>
			</table>
			<br>
			<table align="center">
	  		<tr>
	  		<td>
	  	  頁數：
	  	  <?php
	  	  for($i=1;$i<=$total_pages;$i++){
	  	  	  if($i==$num_pages){
	  	  	  	  echo $i." ";
	  	  	  }
						else{
	  	  	      echo "<a href=\"member.php?page=$i\">$i</a> ";
	  	  	  }
	  	  }
	  	  ?>
	  		</td>
	  		</tr>
			</table>
		</div>
  </body>
</html>
