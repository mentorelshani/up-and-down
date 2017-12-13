<script>
    export default {
  //   	props: {
		//   show__items: {
		//     default:10,
		//     type: Number
		//   }
		// },
	 	data: function() {
	        return {
	            
	        	showItem:"10",
	        	paginatePage:1,
	        }
	    },
	    created() {
            this.setParams();
	    	this.$store.commit('setPaginatePage', this.paginatePage);
	    },

        mounted() {
        },

	    methods:{
	    	setParams:function() {
	    		this.$store.commit('setShowItem', this.showItem);
	    		// this.$store.commit('setPaginatePage', this.paginatePage);
	    	},
	    	Pagination:function(page) {
                if(page == 'min')
                {
                    this.paginatePage=1;
                    this.paginationControll();
                }

                if(page == 'prev')
                {
                    this.paginatePage--;
                    this.paginationControll();
                }

                if(page == 'next')
                {
                    this.paginatePage++;
                    this.paginationControll();
                }

                if(page == 'max')
                {
                    this.paginatePage=Math.ceil(this.lenght__building/this.show__items);
                    this.paginationControll();
                    console.log(this.lenght__building);
                    console.log(this.show__items);
                }

                if(page == 1)
                {
                    this.paginatePage=1;
                    this.paginationControll();
                }
                if(page == 2)
                {
                    this.paginatePage=2;
                    this.paginationControll();
                }
                if(page == 3)
                {
                    this.paginatePage=3;
                    this.paginationControll();
                }
                if(page == 4)
                {
                    this.paginatePage=4;
                    this.paginationControll();
                }

                this.$store.commit('setPaginatePage', this.paginatePage);
            },
            paginationControll:function(){

                if(this.paginatePage == 1)
                {
                    this.deactivate__min=true;
                    this.deactivate__prev=true;
                    this.deactivate__max=false;
                    this.deactivate__next=false;
                }

                else if ( this.paginatePage == this.lenght__building/this.show__items) 
                {
                    this.deactivate__min=false;
                    this.deactivate__prev=false;
                    this.deactivate__max=true;
                    this.deactivate__next=true;
                }

                else 
                {
                    this.deactivate__min=false;
                    this.deactivate__prev=false;
                    this.deactivate__max=false;
                    this.deactivate__next=false;
                }

                this.$store.commit('setPaginatePage', this.paginatePage);
            },
	    }
  	}
</script>

<template src="../templates/menu_itemsFooter.html">

</template>

<style>

</style>