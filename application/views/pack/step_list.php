<div class="row">
	<article class="col-sm-12">
		<div class="data-block clearfix">
			<header>
				<h2><span class="elusive icon-folder-open"></span> Step List (Current Pack : <?php echo $pack_name;?>)</h2>
				<h2 class="pull-right"><a class="btn btn-inverse" href="<?php echo base_url( 'pack/index/')?>">Go back</button></a>
			</header>
			<?php echo $notice;?>
			<div class="col-sm-12">
			<?php echo form_open( '', array('role'=>'form', 'id'=>'myform')); ?>
				<div class="table-responsive">
					<table class="table table-striped table-hover table-media">
						<thead>
							<tr>
								<th class="">Order</th>
								<th>CheckPoint</th>
								<th class="col-sm-2">Action</th>
								<th class="col-sm-2">Locator</th>
								<th>Element</th>
								<th>Data</th>
								<th class="col-sm-1"><div class="btn btn-sm add_one" title="add" href="#"><span class="elusive icon-plus"></span></div></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach( $datas as $v):?>
							<tr>
								<td><input type="text" class="form-control orderby" name="step[<?php echo $v['id']?>][orderby]" value="<?php echo intval( $v['orderby'] ); ?>"></td>
								<td><input type="text" class="form-control" name="step[<?php echo $v['id']?>][checkpoint]" value="<?php echo htmlspecialchars( $v['checkpoint'] );?>"></td>
								<td><?php echo getSelectForm( 'step_action', 'step['.$v['id'].'][action]', $v['action']); ?></td>
								<td><?php echo getSelectForm( 'step_locator', 'step['.$v['id'].'][locator]', $v['locator']); ?></td>
								<td><input type="text" class="form-control" name="step[<?php echo $v['id']?>][element]" value="<?php echo htmlspecialchars( $v['element'] );?>"></td>
								<td><input type="text" class="form-control" name="step[<?php echo $v['id']?>][data]" value="<?php echo htmlspecialchars( $v['data'] ); ?>"></td>
								<td style="text-align:center;">
									<div class="btn-group">
										<div class="btn btn-sm add_one" title="add" href="#"><span class="elusive icon-plus"></span></div>
										<div class="btn btn-sm del_one" title="edit" href="#"><span class="elusive icon-minus"></span></div>
									</div>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
					
				</div>
				<div class="form-group">
					<input class="btn btn-info mysubmit" type="button" style="margin-bottom:10px;" name="save" value="Save" uri="<?php echo 'pack/step_save/'.$_SESSION['pack_id'];?>">
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


	$('table').on('click', '.add_one', function(){

		var s = '',
			self = $(this),
			len = $('table tr').length;
		$.get( '/project/ajax_get_step_data', function( data ){
			data = eval('('+data+')');
			
			s += '<tr>';
			s += '<td><input type="text" class="form-control orderby" name="add['+len+'][orderby]" value="'+ len +'"></td>';
			s += '<td><input type="text" class="form-control" name="add['+len+'][checkpoint]" value=""></td>';
			s += '<td>' + getSelectForm( data.action , 'add['+len+'][action]' ) + '</td>';
			s += '<td>' + getSelectForm( data.locator , 'add['+len+'][locator]' ) + '</td>';
			s += '<td><input type="text" class="form-control" name="add['+len+'][element]" value=""></td>';
			s += '<td><input type="text" class="form-control" name="add['+len+'][data]" value=""></td>';
			s += '<td style="text-align:center;">';
			s += '<div class="btn-group">';
			s += '<div class="btn btn-sm add_one" title="add" href="#"><span class="elusive icon-plus"></span></div>';
			s += '<div class="btn btn-sm del_one" title="edit" href="#"><span class="elusive icon-minus"></span></div></td>';
			s += '</div>';
			s += '</td>';
			s += '</tr>';
			self.closest('tr').after(s);
			resetOrder();
			blindAutoComplete();
		});
		
	});

	$('table').on( 'click', '.del_one', function(){
		$(this).closest('tr').remove();
		resetOrder();
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

	function resetOrder(){
		$('.orderby').each(function( i ){
			$(this).val( i+1 );
		});
	}

	function blindAutoComplete() {
		
		$('.alias').autocomplete( '/ele_repository/ajax_autocomplete', {

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