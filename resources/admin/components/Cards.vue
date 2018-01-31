<script>
    export default {
        data() {
            return {
                cards:{},
                details:{},
                cardsSite:{},

                show__items:"20",
                paginate__page:1,
                keySearch:["cards.site_code","cards.site_number"],
                inputSearch:null,
                ascending:true,
                orderBy:'cards.site_code',
                

                pagination:{},


                setLengthCardsEntry:{},

                error:{},
                modal:{
                    title:null,
                    btnEdit:false,
                    btnAdd:false,
                },
            }
        },

        props: {
            entryId:null,
        },

        beforeCreate() {
        },

        created() {
        },

        mounted() {
            // console.log(this.entryId);
        },

        computed: {
        },

        watch: {
             keySearch: function() {
                this.inputSearch=null;
                this.paginate__page=1;
                this.Buildings();
            },

            show__items: function() {
                this.paginate__page=1;
                this.Buildings();
            },

            entryId:function(){
                this.getAll();
            }

        },

        methods: {
            getAll:function() {
                this.cardsSite={
                    limit:this.show__items,
                    page:this.paginate__page,
                    relation:this.keySearch,
                    value:this.inputSearch,
                    asce:this.ascending,
                    orderBy:this.orderBy, 

                };   

                this.$http.post('/getCardsByEntry/'+this.entryId,this.cardsSite)
                    .then(response => {
                        this.cards=response.data;
                        console.log(response.data);

                        this.setLengthCardsEntry=response.data.total;

                        this.pagination.current_page=response.data.current_page;
                        this.pagination.from=response.data.from;
                        this.pagination.last_page=response.data.last_page;
                        this.pagination.per_page=response.data.per_page;
                        this.pagination.to=response.data.to;
                        this.pagination.total=response.data.total;
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            add:function() {
                this.$http.post('/addCard',this.details)
                    .then(response => {
                        console.log(this.details);
                        console.log("Card u regjistrua me sukses = !false");
                        this.error={};
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u regjistrua me sukses = false");
                        console.log(e.body);
                        this.error=e.body;
                    });
            },

            edit:function() {
                this.$http.post('/updateCard',this.details)
                    .then(response => {
                        console.log("Klienti u përditsua me sukses = !false");
                        this.error={};
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u përditsua me sukses = false");
                        console.log(e.body);
                        this.error=e.body;
                    });
            },

            destroy:function(idCard) {
                this.$http.delete(`/deleteClard/`+idCard)
                    .then(response => {
                        console.log("Klienti u fshi me sukses = !false");
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u fshi me sukses = false");
                        console.log(e.body);
                    });
            },

            getDetails:function(idCard) {
                this.$http.get(`/getClient/`+idCard)
                    .then(response => {
                        this.details=response.data;
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            changeSearchKey:function(searchKey) {
                this.relation=[];
                console.log(searchKey);
                
                if(searchKey=="anything") {
                    this.cardsPage.relation=['buildings.company','buildings.name','cities.name','addresses.street','addresses.neighborhood'];
                }
                else {
                    this.cardsPage.relation=[searchKey];
                }
            },

            modalAdd:function() {
                this.modal.title="Add new card!";
                this.modal.btnAdd=true;
                this.modal.btnEdit=false;
            },

            modalEdit:function() {
                this.modal.title="Edit card!";
                this.modal.btnAdd=false;
                this.modal.btnEdit=true;
            },
        }
    }

</script>

<template src="./templates/cards.html">
</template>
