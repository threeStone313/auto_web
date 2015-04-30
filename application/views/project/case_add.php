<div class="row">

	<!-- Data block -->
	<article class="col-sm-12">
		<div class="data-block">
			<header>
				<h2><span class="elusive icon-calendar"></span> Add a case</h2>
				<h2 class="pull-right"><a class="btn btn-inverse" href="<?php echo base_url('project/case_list/'.$_SESSION['project_id']);?>">Go Back</button></a>
			</header>
			<section class="tab-content">
				<!-- Tab #horizontal -->
				<div id="horizontal" class="tab-pane active">

					<?php echo form_open( 'project/case_create', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<?php echo $notice;?>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Case Name</label>
							<div class="col-sm-5">
								<input type="text" placeholder="" class="form-control" name="cname">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Tags</label>
							<div class="col-sm-5">
								<input type="text" placeholder="" class="form-control" name="tags">
								<p class="help-block">Please use ',' to separate the tags. like: t1,t2</p>
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