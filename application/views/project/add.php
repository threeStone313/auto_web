<div class="row">

	<!-- Data block -->
	<article class="col-sm-12">
		<div class="data-block">
			<header>
				<h2><span class="elusive icon-calendar"></span> Add a project</h2>
				<h2 class="pull-right"><a class="btn btn-inverse" href="<?php echo base_url('project/index');?>">Go Back</button></a>
			</header>
			<section class="tab-content">
				<!-- Tab #horizontal -->
				<div id="horizontal" class="tab-pane active">

					<?php echo form_open( 'project/create', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<?php echo $notice;?>
						<div class="col-sm-7">
							<div class="form-group">
								<label class="col-sm-4 control-label" >Project Name</label>
								<div class="col-sm-8">
									<input type="text" placeholder="" class="form-control" name="pname">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" >Tags</label>
								<div class="col-sm-8">
									<input type="text" placeholder="" class="form-control" name="tags">
									<p class="help-block">Please use ',' to separate the tags</p>
								</div>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<div class="data-block panel-group panel-group-collapsed" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
													Owner
												</a>
											</h4>
										</div>
										<div id="collapseOne" class="panel-collapse collapse in">
											<div class="panel-body">
												<table class="table table-striped table-hover table-media">
													<tbody>
														<?php foreach( $owner_list as $owner ): ?>
														<tr>
															<?php $defalut_checked = $owner['id'] == $_SESSION['admin']['id'] ? ' disabled checked ' : '';?>
															<td><input type="checkbox" value="<?php echo $owner['id'];?>" name="owner[]" <?php echo $defalut_checked;?>></td>
															<td><?php echo $owner['nickname'];?> <?php if( $defalut_checked ):?><span class="label label-info">Creater</span><?php endif;?></td>
														</tr>
														<?php endforeach;?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									
								</div>
							    <!-- /Data block with collapsed panels -->
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button class="btn btn-lg btn-default" type="submit">Submit</button>
							</div>
						</div>
					</form>

				</div>
				<!-- /Tab #horizontal -->
			</section>
			<footer>
			</footer>
		</div>
	</article>
	<!-- /Data block -->
</div>