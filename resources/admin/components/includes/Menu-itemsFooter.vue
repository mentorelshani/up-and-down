<script>
    export default {
	 	data: function() {
	        return {
	   
	        	showItem:20,
	        	paginatePage:1,
                totalPage:null,
                activePage:true,
                minPage:1,
                maxPage:5,

                showPaginate:true,
	        }
	    },

        props: {
            lengthBuildings:null,
            lengthEntries:null,
            lengthCardsEntry:null,
            sitePage:null,
            pagination:{},
        },

	    created() {
            this.setParams();
	    	this.$store.commit('setPaginatePage', this.paginatePage );
	    },

        mounted() {
            this.totalPage = Math.ceil( this.lengthBuildings / this.$store.getters.getShowItem );
        },

        watch: {
            lengthBuildings:function() {
                this.totalPage = Math.ceil( this.lengthBuildings / this.$store.getters.getShowItem );
            },

            lengthEntries:function() {
                this.totalPage = Math.ceil( this.lengthEntries / this.$store.getters.getShowItem );
            },

            showItem:function() {
                this.totalPage = Math.ceil( this.lengthBuildings / this.$store.getters.getShowItem );
                
                this.minPage=1;
                this.maxPage=5;
                this.paginatePage=1;

                if( this.showItem == "10000" ) {
                    this.showPaginate = false;
                }
                else {
                    this.showPaginate = true;
                }
            }
        },

	    methods:{
	    	setParams:function() {
	    		this.$store.commit('setShowItem', this.showItem);
	    		// this.$store.commit('setPaginatePage', this.paginatePage);
	    	},
	    	Pagination:function(page) {
                if( page == 'min') {
                    this.paginatePage=1;
                    this.paginationControll();

                    this.minPage=1;
                    this.maxPage=5;
                }

                else if( page == 'prev' ) {
                    this.paginatePage--;
                    this.paginationControll();

                    this.minPage--;
                    this.maxPage--;

                    if( this.minPage < 1) {
                        this.maxPage = 5;
                        this.minPage = 1;
                    }
                }

                else if(page == 'next') {
                    this.paginatePage++;
                    this.paginationControll();

                    this.minPage++;
                    this.maxPage++;

                    if(this.maxPage >this.totalPage) {

                        this.maxPage = this.totalPage;
                        this.minPage = this.totalPage-5;
                    }
                }

                else if(page == 'max') {
                    this.paginatePage=Math.ceil(this.lengthBuildings/this.$store.getters.getShowItem);
                    this.paginationControll();
                    
                    this.minPage=this.totalPage-5;
                    this.maxPage=this.totalPage;
                }
                else {
                    this.paginatePage=page;
                    this.paginationControll();
                }
 
                this.$store.commit('setPaginatePage', this.paginatePage);
            },
            paginationControll:function(){

                if(this.paginatePage == 1 || this.paginatePage < 1 ) {
                    this.paginatePage =1;
                }
                else if ( this.paginatePage == this.totalPage || this.paginatePage > this.totalPage) {
                    this.paginatePage=this.totalPage;
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