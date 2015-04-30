<div class="row">
	<article class="col-sm-12">
		<div class="data-block clearfix">
			<header>
				<h2><span class="elusive icon-folder-open"></span> Project List</h2>
				<h2 class="pull-right"><a class="btn btn-inverse" href="<?php echo base_url( 'project/add' )?>">Add One</a></h2>
			</header>
			<?php echo $notice;?>
			<!-- Navigation form -->
			<div class="col-sm-5" style="margin-top:10px">
				<?php echo form_open( 'project/index', array('role'=>'search', 'class'=>'navbar-form', 'method'=> 'get')); ?>
					<div class="input-group">
						<input type="text" id="search-project" class="form-control" placeholder="Search Project" name="s" value="<?php echo htmlspecialchars($search);?>">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default"><span class="elusive icon-search"></span></button>
						</span>
					</div>
				</form>
			</div>
			<!-- /Navigation form -->
			<div class="col-sm-12">
			<?php echo form_open( '', array('role'=>'form','id'=>'myform' ,'class'=>'')); ?>
				<div class="col-sm-9">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-media">
							<thead>
								<tr>
									<th></th>
									<th class="col-sm-5">Project Name</th>
									<th>Tags</th>
									<th class="col-sm-3">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach( $datas as $project ):?>
								<tr>
									<td><input type="checkbox" name="exec[]" value="<?php echo $project['id'];?>"></td>
									<td><?php echo $project['pname'];?></td>
									<td><?php echo $project['tags'];?></td>
									<td style="text-align:center;">
										<div class="btn-group">
											<span class="btn btn-sm" title="view" href="<?php echo base_url( 'project/case_list/'.$project['id'] )?>"><span class="elusive icon-eye-open"></span></span>
											<?php if( $project['aid'] == $_SESSION['admin']['id'] ):?>
											<span class="btn btn-sm" title="edit" href="<?php echo base_url( 'project/edit/'.$project['id'] )?>"><span class="elusive icon-pencil"></span></span>
											<span class="btn btn-sm" title="delete" href="<?php echo base_url( 'project/delete/'.$project['id'] )?>"><span class="elusive icon-trash"></span></span>
											<?php endif;?>
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
									<button class="btn btn-info execute" type="submit" style="margin-bottom:10px;" uri="execute/project_run">Execute!</button>
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

	$('.execute').on('click', function(){
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
		
		$('#search-project').autocomplete( '/project/ajax_project_auto', {

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