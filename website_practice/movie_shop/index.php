<!DOCTYPE html>
<?php 
	header("Content-Type: text/html; charset=utf-8");
	include("connMysql1.php");
	$seldb = @mysqli_select_db($db_link, "movie_shop");
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

<html>
<head>
	<meta charset="utf-8">
	<title>動畫電影產品訂購</title>
	<style type="text/css">
      body {
            background-image: url(bg1.png);
            background-repeat: no-repeat;
            background-size: cover;
			
        }
	</style>
</head>
<body >
<h1 align="center">動畫電影-會員訂單管理系統</h1>
<p align="center">會員資料 - 目前資料筆數：<?php echo $total_records;?>，<a href="search1".php">查詢會員資料</a>  <a href="add1.php">新增會員資料</a>。</p>
<table border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
    <th>編號</th>
    <th>姓名</th>
    <th>性別</th>
    <th>生日</th>
    <th>電子郵件</th>
    <th>電話</th>
    <th>住址</th>
    <th>功能</th>
  </tr>
  <!-- 資料內容 -->
<?php
	while($row_result=mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo "<td>".$row_result["cID"]."</td>";
		echo "<td>".$row_result["cName"]."</td>";
		echo "<td>".$row_result["cSex"]."</td>";
		echo "<td>".$row_result["cBirthday"]."</td>";
		echo "<td>".$row_result["cEmail"]."</td>";
		echo "<td>".$row_result["cPhone"]."</td>";
		echo "<td>".$row_result["cAddr"]."</td>";
		echo "<td><a href='update1.php?id=".$row_result["cID"]."'>修改</a> ";
		echo "<a href='delete1.php?id=".$row_result["cID"]."'>刪除</a></td>";
		echo "</tr>";
	}
	
	// echo "<table><tr>";
	// $fieldInfo = mysqli_fetch_fields($result);
	// foreach ($fieldInfo as $fi) {
	// 		$fName= $fi->name;
	// 		echo "<th>$fName</th>";
	// } 
	// while($row_result=mysqli_fetch_assoc($result)) {
  //   foreach($row_result as $item => $value){
  //   	echo $item = $value."<br />";
  //   	echo "<hr />";
	//   }
	// }
	// echo "</tr></table>";
?>

</table>

<h2 align="center">動畫電影項目</h1>
<table border="1" align="center">
  
  <tr>
    <th>編號</th>
    <th>產品</th>
    <th>價格</th>
    <th>分類</th>
  </tr>
  <!-- 資料內容 -->
<?php
	$sql_query = "SELECT * FROM `movie`";

	$result = mysqli_query($db_link, $sql_query);

	while($row_result=mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo "<td>".$row_result["mNo"]."</td>";
		echo "<td>".$row_result["mName"]."</td>";
		echo "<td>".$row_result["mPrice"]."</td>";
		echo "<td>".$row_result["catalog"]."</td>";
		echo "</tr>";
	}
	
	// echo "<table><tr>";
	// $fieldInfo = mysqli_fetch_fields($result);
	// foreach ($fieldInfo as $fi) {
	// 		$fName= $fi->name;
	// 		echo "<th>$fName</th>";
	// } 
	// while($row_result=mysqli_fetch_assoc($result)) {
  //   foreach($row_result as $item => $value){
  //   	echo $item = $value."<br />";
  //   	echo "<hr />";
	//   }
	// }
	// echo "</tr></table>";
?>

</table>

<table border="0" align="center">
  <tr>
    <?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
    <td><a href="index.php?page=1">第一頁</a></td>
    <td><a href="index.php?page=<?php echo $num_pages-1;?>">上一頁</a></td>
    <?php } ?>
    <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
    <td><a href="index.php?page=<?php echo $num_pages+1;?>">下一頁</a></td>
    <td><a href="index.php?page=<?php echo $total_pages;?>">最後頁</a></td>
    <?php } ?>
  </tr>
</table>
<table border="0" align="center">
  <tr>
  	<td>
  	  頁數：
  	  <?php
  	  for($i=1;$i<=$total_pages;$i++){
  	  	  if($i==$num_pages){
  	  	  	  echo $i." ";
  	  	  }else{
  	  	      echo "<a href=\"index.php?page=$i\">$i</a> ";
  	  	  }
  	  }
  	  ?>
  	</td>
  </tr>
</table>
</body>
</html>