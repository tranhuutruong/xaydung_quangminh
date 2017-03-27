<?php
	$chinhanh=getAll("select photo,link from #_slider where hienthi=1 and type='chinhanh' order by stt,id desc");
	//$main_logo=getOne("select photo,link from #_")
?>
<div class="container">
	<div class="row">
		<div id="branch">
			<div class="slick_11">
				<?php foreach ($chinhanh as $item): ?>
					<div class="branch_item">
						<a href="<?php echo $item['link'] ?>">
							<img src="<?php echo _upload_hinhanh_l.$item['photo'] ?>" alt="">
						</a>
					</div>
				<?php endforeach ?>
			</div>
			<!-- <div class="main_logo">
				<a href="">
					<img src="" alt="">
				</a>
			</div> -->
		</div>
	</div>
</div>