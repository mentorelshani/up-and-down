export default {
	
	information(title,text,type) {
   		swal({
		  	title:title,
		 	text:text,
		  	type:type,
		  	customClass: 'sweetalert-lg'
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
		  	confirmButtonText: "Confirm",
		  	closeOnConfirm: false,
		  	customClass: 'sweetalert-lg'

		})
		.then((result) => {
			if (result.value) {
			  	action();
			    swal({
			    	title:'Deleted!',
			    	text:'Row has been deleted.',
			    	type:'success',
		  			customClass: 'sweetalert-lg'
			    });
			}
			else {
				swal({
			    	title:'Deleted!',
			    	text:'Row has not been deleted.',
			    	type:'error',
		  			customClass: 'sweetalert-lg'
			    });
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
		  	confirmButtonText: "Confirm",
		  	closeOnConfirm: false,
		  	customClass: 'sweetalert-lg'
		})
		.then((result) => {
			if (result.value) {
			  	action();
			  	swal({
			    	title:'Updated!',
			    	text:'Row has been updated.',
			    	type:'success',
		  			customClass: 'sweetalert-lg'
			    });
			}
			else {
				swal({
			    	title:'Updated!',
			    	text:'Row has not been updated.',
			    	type:'error',
		  			customClass: 'sweetalert-lg'
			    });
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
		  	confirmButtonText: "Confirm",
		  	closeOnConfirm: false,
		  	customClass: 'sweetalert-lg'
		})
		.then((result) => {
			if (result.value) {
			  	action();
			  	swal({
			    	title:'Added!',
			    	text:'Row has been added.',
			    	type:'success',
		  			customClass: 'sweetalert-lg'
			    });
			}
			else {
				swal({
			    	title:'Added!',
			    	text:'Row has not been added.',
			    	type:'error',
		  			customClass: 'sweetalert-lg'
			    });
			}
		})
	},

	removeBuilding: function (action) {
		swal({
		  	title: "Are you sure?",
		  	text: "You will remove building from access list!",
		  	type: "warning",
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
  			cancelButtonColor: '#d33',
		  	confirmButtonText: "Confirm",
		  	closeOnConfirm: true,
		  	customClass: 'sweetalert-lg'

		})
		// .then((result) => {
		// 	if (result.value) {
		// 	  	action();
		// 	}
		// 	else {
		// 	}
		// })
	},

}
