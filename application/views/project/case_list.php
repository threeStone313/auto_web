<div class="row">
	<article class="col-sm-12">
		<div class="data-block clearfix">
			<header>
				<h2><span class="elusive icon-folder-open"></span> Case List (Current Project : <?php echo $project_name;?>)</h2>
				<h2 class="pull-right"><a class="btn btn-inverse" href="<?php echo base_url( 'project/case_add/' )?>">Add One</a>&nbsp;<a class="btn btn-inverse" href="<?php echo base_url( 'project/index' )?>">Go Back</a></h2>
			</header>
			<?php echo $notice;?>
			<!-- Navigation form -->
			<div class="col-sm-5" style="margin-top:10px">
				<?php echo form_open( 'project/case_list/'.$_SESSION['project_id'], array('role'=>'search', 'class'=>'navbar-form', 'method'=> 'get')); ?>
					<div class="input-group">
						<input type="text" id="search-case" class="form-control" placeholder="Search Case" name="s" value="<?php echo htmlspecialchars($search);?>">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default"><span class="elusive icon-search"></span></button>
						</span>
					</div>
				</form>
			</div>
			<!-- /Navigation form -->
			<div class="col-sm-12">
			<?php echo form_open( '', array('role'=>'form', 'name'=>'myform', 'id'=>'myform')); ?>
				<div class="col-sm-9">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-media">
							<thead>
								<tr>
									<th></th>
									<th class="col-sm-1">Order</th>
									<th>Case Name</th>
									<th>Tags</th>
									<th class="col-sm-3">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach( $datas as $case ):?>
								<tr>
									<td><input type="checkbox" name="exec[]" value="<?php echo $case['id'];?>"></td>
									<td><input type="text" class="form-control" name="order[<?php echo $case['id'];?>]" value="<?php echo $case['orderby'];?>"></td>
									<td><?php echo $case['cname'];?></td>
									<td><?php echo $case['tags'];?></td>
									<td style="text-align:center">
										<div class="btn-group">
											<div class="btn btn-sm" title="view" href="<?php echo base_url( 'project/step_list/'.$case['id'] )?>"><span class="elusive icon-eye-open"></span></div>
											<div class="btn btn-sm" title="edit" href="<?php echo base_url( 'project/case_edit/'.$case['id'] )?>"><span class="elusive icon-pencil"></span></div>
											<div class="btn btn-sm" title="delete" href="<?php echo base_url( 'project/case_delete/'.$case['id'] )?>"><span class="elusive icon-trash"></span></div>
										</div>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						
					</div>
					<div class="pagination-right">
						<ul class="pagination"><?php echo $pagelinks;?></ul>
					</div>
					<div class="form-group">
						<input class="btn btn-info mysubmit" type="button" style="margin-bottom:10px;" name="order" value="Save Order" uri="project/case_order">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="data-block panel-group panel-group-collapsed" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										Options
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="form-group row">
										<label for="" class="col-sm-12">IP address</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" name="ip" placeholder="Ip" value="<?php echo $this->session->userdata('ip');?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="" class="col-sm-12">Browser</label>
										<div class="col-sm-12">
											<select class="form-control" name="browser">
												<option value="firefox" selected>FireFox</option>
												<option value="chrome">Chrome</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="" class="col-sm-12">Resolution  (responsive only)</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" name="width" placeholder="Width">
											<input type="text" class="form-control" name="height" placeholder="Height">
										</div>
									</div>
									<button class="btn btn-info mysubmit" type="button" style="margin-bottom:10px;" uri="execute/case_run">Execute!</button>	
								</div>
							</div>
						</div>
					</div>
				</div>
		    </form>
			</div>
		</div>
	</article>
</div>
<script>
(function($){
	//submit to different action
	$('.mysubmit.btn').on('click', function(){
		var action = 'http://'+ window.location.host + '/' + $(this).attr('uri');
			form = document.getElementById('myform');
		form.action = action;
		form.submit();
	});
	
	$('.btn-group .btn').on( 'click', function(){
		var self = $(this);
		if( self.attr('title') == 'delete' ) {
			if( confirm( 'Are you sure to delete this project?' ) ){
				window.location = self.attr('href');
			} else {
				return false;
			}		
		} else {
			window.location = self.attr('href');
		}
	} );

	function blindAutoComplete() {
		
		$('#search-case').autocomplete( '/project/ajax_case_auto', {

			scrollHeight: 300,
	        matchContains: true,    
	        autoFill: false,
	        formatItem: function(row) {
	        	return row[1];
	        },
	        formatResult: function(row) {
				return row[1];
			}

		});
	}

	blindAutoComplete();

})(jQuery);
</script>