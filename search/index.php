<!DOCTYPE html>
<?php
require("../function/common.php");
if($login === false)header("Location: ../login/");
?>
<html lang="zh-Hant-TW">
<head>
<meta charset="UTF-8">
<?php
require("../res/template/comhead.php");
?>
<title>搜尋-<?php echo $cfg['website']['name']; ?></title>
</head>
<body Marginwidth="-1" Marginheight="-1" Topmargin="0" Leftmargin="0">
<?php
require("../res/template/header.php");
?>
<div class="row">
	<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">
		<h2>搜尋</h2>
		<div class="row">
			<div class="col-xs-12">
				<form method="get">
					<input type="hidden" name="date" value="<?php echo @$_GET["date"]; ?>">
					<input type="hidden" name="meal" value="<?php echo @$_GET["meal"]; ?>">
					<div class="input-group">
						<span class="input-group-addon">搜尋</span>
						<input class="form-control" name="name" type="text" value="<?php echo @$_GET["name"]; ?>">
						<span class="input-group-btn">
					    	<button type="submit" class="btn btn-info">
								<span class="glyphicon glyphicon-search"></span>
							</button>
					    </span>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form method="post" action="../function/diary.php">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="return" value="diary">
				<input type="hidden" name="date" value="<?php echo @$_GET["date"]; ?>">
				<input type="hidden" name="meal" value="<?php echo @$_GET["meal"]; ?>">
				<ul class="list-group" id="contact-list">
				<?php
				$query = new query;
				$query->table = "food";
				$query->where = array("name", str_replace("+", "[+]", @$_GET["name"]), "REGEXP");
				$row = SELECT($query);
				if(count($row) > 0){
					foreach($row as $temp){
					?>
						<li class="list-group-item" style="height: 120px">
					        <a style="display: block" href="../info/?fid=<?php echo $temp["fid"]; ?>&date=<?php echo $_GET["date"]; ?>&meal=<?php echo $_GET["meal"]; ?>">
					        <div class="col-xs-4 col-md-2">
					            <?php
					            if ($temp["hasphoto"] != 0) {
					            ?><img src="../res/image/food/<?php echo $temp["familyid"]; ?>.jpg" style="max-height: 100px; max-width: 100%;"><?php
					            } else {
					            ?><img src="../res/image/search/No_photo_available.png" style="max-height: 100px; max-width: 100%;"><?php
					            }
					            ?>
					        </div>
					        <div class="col-xs-6 col-md-8">
					            <span><?php echo $temp["name"]; ?></span><br>
					            <span><?php echo $temp["calories"]; ?>大卡</span>
					        </div>
					        </a>
					        <div class="col-xs-2 col-md-2">
					        	<?php
					        	if (@$_GET["date"] != "" && @$_GET != "") {
					        	?>
					        	<button type="submit" class="btn btn-info" style="color: #000; background-color: rgba(0, 0, 0, 0); border-color: rgba(0, 0, 0, 0);" name="fid" value="<?php echo $temp["fid"]; ?>">
									<span class="glyphicon glyphicon-plus"></span>
								</button>
					        	<?php
					        	} else {
					        	?>
					        	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#Modal" style="color: #000; background-color: rgba(0, 0, 0, 0); border-color: rgba(0, 0, 0, 0);" onclick="add('<?php echo $temp["fid"]; ?>')">
									<span class="glyphicon glyphicon-plus"></span>
								</button>
					        	<?php
					        	}
					        	?>
					        </div>
					    </li>
					<?php
					}
				}
				?>
				</ul>
				</form>
			</div>
		</div>
		<script type="text/javascript">
			function add(id){
				fid.value = id;
			}
		</script>
		<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form method="post" action="../function/diary.php">
					<input type="hidden" name="action" value="add">
					<input type="hidden" name="return" value="diary">
					<input type="hidden" name="fid" id="fid">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="ModalLabel">加入日記</h4>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<span class="input-group-addon">日期</span>
							<input class="form-control" name="date" type="date" value="<?php echo date("Y-m-d"); ?>" required>
						</div>
      					<input type="image" src="../res/image/1.png" width="50px" border="0" name="meal" value="1">
      					<input type="image" src="../res/image/2.jpg" width="50px" border="0" name="meal" value="2">
      					<input type="image" src="../res/image/3.jpg" width="50px" border="0" name="meal" value="3">
      					<input type="image" src="../res/image/4.jpg" width="50px" border="0" name="meal" value="4">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					</div>
					</form>
				</div>
			</div>
		</div>
<?php
	include("../res/template/footer.php");
?>
</body>
</html>