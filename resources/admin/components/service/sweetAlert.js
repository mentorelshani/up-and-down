
export default class sweetAlert {
	information(title,text,type) {
   		swal({
		  	title:title,
		 	text:text,
		  	type:type
		})
	};

	confirm(title,text,type,btnText) {
		swal({
		  	title: title,
		  	text: text,
		  	type: type,
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: btnText

    	}).then((result) => {        
            var abc = result.value ;
            }
        )
        return abc;
	};

}