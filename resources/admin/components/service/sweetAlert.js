export default {
	
	information(title,text,type) {
   		swal({
		  	title:title,
		 	text:text,
		  	type:type
		})
	},

	delete: function (action) {
		swal({
		  	title: "Are you sure?",
		  	text: "You will not be able to recover this!",
		  	type: "warning",
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
  			cancelButtonColor: '#d33',
		  	confirmButtonText: "Yes, delete it!",
		  	closeOnConfirm: false
		})
		.then((result) => {
			if (result.value) {
			  	action();
			    swal('Deleted!','Row has been deleted.','success');
			}
			else {
			    swal('Deleted!','Row has been not deleted.','error');
			}
		})
	},

	modify: function (action) {
		swal({
		  	title: "Are you sure?",
		  	text: "You will not be able to recover this!",
		  	type: "warning",
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
 			cancelButtonColor: '#d33',
		  	confirmButtonText: "Yes, updated it!",
		  	closeOnConfirm: false
		})
		.then((result) => {
			if (result.value) {
			  	action();
			    swal('Updated!','Row has been updated.','success');
			}
			else {
			    swal('Updated!','Row has been not updated.','error');
			}
		})
	},

	add: function (action) {
		swal({
		  	title: "Are you sure?",
		  	text: "You will not be able to recover this!",
		  	type: "warning",
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
  			cancelButtonColor: '#d33',
		  	confirmButtonText: "Yes, add it!",
		  	closeOnConfirm: false
		})
		.then((result) => {
			if (result.value) {
			  	action();
			    swal('Added!','Row has been add.','success');
			}
			else {
			    swal('Added!','Row has been not add.','error');
			}
		})
	},

}
