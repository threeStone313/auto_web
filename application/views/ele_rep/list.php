<div class="row">
	<article class="col-sm-12">
		<div class="data-block clearfix">
			<header>
				<h2><span class="elusive icon-folder-open"></span> Element List</h2>
				<h2 class="pull-right"><a class="btn btn-inverse" href="<?php echo base_url( 'ele_repository/add/' )?>">Add One</a></h2>
			</header>
			<?php echo $notice;?>
			<!-- Navigation form -->

			<div class="col-sm-5" style="margin-top:10px">
			<?php echo form_open( 'ele_repository/index', array('role'=>'search', 'method'=> 'get')); ?>
				<div class="input-group">
					<input type="text" id="search-alias" class="form-control" placeholder="Search Alias" name="s" value="<?php echo htmlspecialchars($search);?>">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default"><span class="elusive icon-search"></span></button>
					</span>
				</div>
			</form>
			</div>

			<!-- /Navigation form -->
			<div class="col-sm-12">
				<?php echo form_open( '', array('role'=>'form', 'id'=>'myform')); ?>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Alias</th>
									<th>Locator</th>
									<th>Element</th>
									<th class="col-sm-2"></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach( $datas as $v):?>
								<tr>
									<td><?php echo htmlspecialchars( $v['alias'] ); ?></td>
									<td><?php echo $locator[$v['locator']];?></td>
									<td><?php echo htmlspecialchars( $v['element'] );?></td>
									<td style="text-align:center;">
										<div class="btn-group">
											<div class="btn btn-sm" title="edit" href="<?php echo base_url( 'ele_repository/edit/'.$v['id'] )?>"><span class="elusive icon-pencil"></span></div>
											<div class="btn btn-sm" title="delete" href="<?php echo base_url( 'ele_repository/delete/'.$v['id'] )?>"><span class="elusive icon-trash"></span></div>
										</div>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						
					</div>
			    </form>
			    <div class="pagination-right">
					<ul class="pagination"><?php echo $pagelinks;?></ul>
				</div>
			</div>
		</div>
	</article>
</div>
<script>
(function($){

	//submit to different action
	$('.mysubmit .btn').on('click', function(){
		var action = 'http://'+ window.location.host + '/' + $(this).attr('uri');
			form = document.getElementById('myform');
		form.action = action;
		form.submit();
	});


	$('.add_one').on('click', function(){

		var s = '',
			self = $(this),
			len = $('table tr').length;
		$.get( '/project/ajax_get_step_data', function( data ){
			data = eval('('+data+')');
			
			s += '<tr>';
			s += '<td><input type="text" class="form-control" name="add['+len+'][alias]"></td>';
			s += '<td>' + getSelectForm( data.locator , 'add['+len+'][locator]' ) + '</td>';
			s += '<td><input type="text" class="form-control" name="add['+len+'][element]" value=""></td>';
			s += '<td style="text-align:center;"><div class="btn btn-sm del_one" title="edit" href="#"><span class="elusive icon-minus"></span></div></td>';
			s += '</tr>';
			$('table tbody tr').first().before(s);


			if( $('table tbody tr').length > 10 ) {
				$('table tbody tr').last().remove();
			}

		});
		
	});

	$('table').on( 'click', '.del_one', function(){
		$(this).closest('tr').remove();
	} );

	function getSelectForm( data, name ) {

		var s='';
		s += '<select class="form-control" name="' + name +'" >';
		for( key in data ) {
			s += '<option value="'+key+'" >'+ data[key] +'</option>';
		}
		s += '</select>';
		return s;
	}

	$('.btn-group .btn').on( 'click', function(){
		var self = $(this);
		if( self.attr('title') == 'delete' ) {
			if( confirm( 'Are you sure to delete this element?' ) ){
				window.location = self.attr('href');
			} else {
				return false;
			}		
		} else {
			window.location = self.attr('href');
		}
	} );

	$('#search-alias').autocomplete( '/ele_repository/ajax_autocomplete', {

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

})(jQuery);
</script>