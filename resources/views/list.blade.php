<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AJAX TODO LIST Project</title>
	<link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
	<script>
	    /*window.Laravel =  <?php echo json_encode([
	        'csrfToken' => csrf_token(),
	    ]); ?>*/
	</script>
	<style>
		body {
			margin: 20px auto;
		}
	</style>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">

				<div class="search">
					<input type="text" name="search" id="search" class="form-control" placeholder="Search Item....">
					<hr>
				</div>
				
				<div class="panel panel-default">
					
					<div class="panel-heading">
						<h3 class="panel-title">
							AJAX ToDo List 
							<a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</a>
						</h3>
					</div>
					
					<div class="panel-body" id="items">
						<ul class="list-group">
							@foreach($items as $item)
								<li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">
									{{ $item->item }}
									<input type="hidden" id="itemId" value="{{ $item->id }}" />
								</li>
							@endforeach
							{{-- <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">Item 1</li> --}}
						</ul>
					</div>
				</div>

				<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">

							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 id="title" class="modal-title">Add New Item</h4>
							</div>

							<div class="modal-body">
								<input type="hidden" id="id" />
								<p>
									<input type="text" name="addItem" id="addItem" placeholder="Write item here..." class="form-control" />
								</p>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" id="delete" style="display:none">Delete</button>
								<button type="button" class="btn btn-primary" data-dismiss="modal" style="display:none" id="saveChange">Save Change</button>
								<button type="button" class="btn btn-success" id="AddButton" data-dismiss="modal">Add Item</button>
							</div>

						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

			</div>
		</div>
	</div>

	{{ csrf_field() }}
	
	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script>
		$(document).ready(function () {

			/* Show Add Item Modal*/
			$(document).on('click', '#addNew', function () {
			// $('#addNew').on('click', function () {
					$('#title').text('Add New Item');
					$('#addItem').val('');
					$('#delete').hide(400);
					$('#saveChange').hide(400);
					$('#AddButton').show(400);
			});

			/* Show Item Modal for Delete/Edit */
			$(document).on('click', '.ourItem', function () {
			// $('.ourItem').each(function () {
				// $(this).on('click', function () {
					let text = $(this).text();
						text = $.trim(text);
					let id = $(this).find('#itemId').val();
					$('#title').text('Edit Item');
					$('#addItem').val(text);
					$('#id').val(id);
					$('#delete').show(400);
					$('#saveChange').show(400);
					$('#AddButton').hide(400);
					// console.log(id);
				// })
			});

			/* Add Item Database */
			$('#AddButton').on('click', function () {
				let text = $('#addItem').val();
				// $.post('todo', {'text': text, '_token':Laravel.csrfToken }, function (data) {
				if( text == '') {
					alert('Please type anything for item.');
				} else {
					$.post('todo', {'text': text, '_token':$('input[name=_token]').val() }, function (data) {
						console.log(data);
						$("#items").load(location.href + ' #items');
					});
				}
			});

			/* Delete Item  */
			$('#delete').on('click', function () {
				let id = $('#id').val();
				console.log(id);

				$.post('delete', {'id': id, '_token':$('input[name=_token]').val() }, function (data) {
					console.log(data);
					$("#items").load(location.href + ' #items');
				});
			});

			/* Edit Item  */
			$('#saveChange').on('click', function () {
				let id = $('#id').val();
				let value = $('#addItem').val();
				console.log(id);

				$.post('update', {'id': id, 'value': value, '_token':$('input[name=_token]').val() }, function (data) {
					console.log(data);
					$("#items").load(location.href + ' #items');
				});
			});

			/*Auto Complete (jQuery UI)*/
			$( function() {
			  // var availableTags = [
			  //   "ActionScript",
			  //   "AppleScript",
			  // ];
			  $( "#search" ).autocomplete({
			    source: "http://todo.dev/search"
			  });
			} );

			
		});
	</script>
</body>
</html>