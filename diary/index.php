<!DOCTYPE html>
<?php
require("../function/common.php");
if($login === false)header("Location: ../login/");
$date = $_GET["date"] ?? date("Y-m-d");
?>
<html lang="zh-Hant-TW">
<head>
<?php
require("../res/template/comhead.php");
showmeta();
?>
<title>日記-<?php echo $cfg['website']['name']; ?></title>
<link href="../res/css/diary.css" rel="stylesheet">
</head>
<body Marginwidth="-1" Marginheight="-1" Topmargin="0" Leftmargin="0">
<?php
require("../res/template/header.php");
?>
<div class="row">
	<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">
	<?php
	$week = array("日", "一", "二", "三", "四", "五", "六");
	?>
	<h2>日記 <?php echo $date; ?> 星期<?php echo $week[date("w", strtotime($date))]; ?></h2>
	<ul class="pager">
		<li><a href="?date=<?php echo date("Y-m-d", strtotime($date)-86400); ?>&meal=<?php echo $meal; ?>">←  前一天</a></li>
		<?php
		if ($date < date("Y-m-d")) {
		?>
		<li><a href="?date=<?php echo date("Y-m-d", strtotime($date)+86400); ?>&meal=<?php echo $meal; ?>">後一天  →</a></li>
		<li><a href="?date=<?php echo date("Y-m-d"); ?>&meal=<?php echo $meal; ?>">今天  →→</a></li>
		<?php
		}
		?>
	</ul>
	<script type="text/javascript">
		function change_stats(id) {
		if (id <= 0 || id > 4) return ;
		if (document.all["meal"+id+"tool"].style.display=="none") {
			document.all["meal"+id+"tool"].style.display="";
			document.all["meal"+id+"food"].style.display="";
		} else {
			document.all["meal"+id+"tool"].style.display="none";
			document.all["meal"+id+"food"].style.display="none";
		}
		}
	</script>
	<?php
	$sum["calories"] = 0;
	for ($meal=1; $meal <= 4; $meal++) { 
	?>
	<div class="row">
		<div class="col-xs-3 col-md-1"><img src="../res/image/diary/meal<?php echo $meal; ?>.png" width="50px" onclick="change_stats(<?php echo $meal; ?>)"></div>
		<div class="col-xs-9 col-md-11">
		<div id="meal<?php echo $meal; ?>tool" style="display: none; padding-top: 0px; padding-bottom: 0px;" class="jumbotron">
			<button type="button" class="btn btn-info" style="color: #000; background-color: rgba(0, 0, 0, 0); border-color: rgba(0, 0, 0, 0);" onclick="alert('此功能尚未完成唷~')">
			<span class="glyphicon glyphicon-barcode"></span>
			</button>
			<a href="../search/?date=<?php echo $date; ?>&meal=<?php echo $meal; ?>" class="btn" role="button" style="color: #000; background-color: rgba(0, 0, 0, 0); border-color: rgba(0, 0, 0, 0);">
			<span class="glyphicon glyphicon-search"></span>
			</a>
		</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
		<div id="meal<?php echo $meal; ?>food" style="display: none; text-align: center; padding-top: 10px; padding-bottom: 10px;" class="jumbotron">
		<?php
		$query = new query;
		$query->table = "diary";
		$query->where = array(
			array("uid", $login["uid"]),
			array("date", $date),
			array("meal", $meal)
		);
		$row = SELECT($query);
		if (count($row) != 0) {
			foreach ($row as $temp) {
			$query2 = new query;
			$query2->table = "food";
			$query2->where = array(
				array("fid", $temp["fid"])
			);
			$row2 = fetchone(SELECT($query2));
			$sum["calories"] += $row2["calories"];
			?>
			<a href="../info/?fid=<?php echo $row2["fid"]; ?>"><?php echo $row2["name"]; ?></a>
			<a href="del.php?hash=<?php echo $temp["hash"];?>&date=<?php echo $date; ?>&meal=<?php echo $temp["meal"]; ?>"><span class="glyphicon glyphicon-remove"></span></a><br>
			<?php
			}
		} else {
			echo "目前沒有加入";
		}
		?>
		</div>
		</div>
	</div>
	<?php
	}
	?>
	今日總共攝取<?php echo $sum["calories"]; ?>大卡
<?php
	include("../res/template/footer.php");
?>
<script type="text/javascript">
	<?php
	foreach (explode(",", $_GET["show"]) as $temp) {
	echo "change_stats(".$temp.");\n";
	}
	?>
</script>
</body>
</html>