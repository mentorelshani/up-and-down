<script>
    export default {
        data() {
            return {
                cards:{},
                details:{
                    active:true,
                    client:{},
                },
                cardsSite:{},

                show__items:"10",
                paginate__page:1,
                keySearch:["cards.site_code","cards.site_number"],
                inputSearch:null,
                ascending:true,
                orderBy:'cards.site_code',
                
                buildings:{},
                entriesBuilding:{},
                accessPointsEntry:{},
                relayAccessPoint:{},
                clients:{},

                cardAccesses:{
                    building_id:null,
                    entry_id:null,
                    accessPoint_id:null,
                    relayAccess:[],
                },

                pagination:{},

                showCardData:true,
                setLengthCardsEntry:{},

                error:{
                    client_id:null,
                    site_code:null,
                    site_number:null,
                },
                modal:{
                    title:null,
                    btnCard:false,
                    btnEdit:false,
                    btnAdd:false,
                    btnConfigAccess:false,
                },

                details_access:true,
            }
        },

        props: {
            entryId:null,
        },

        beforeCreate() {
        },

        created() {
            this.cardAccesses.building_id=parseInt(this.$route.params.id);

        },

        mounted() {
            // this.getAccessPoints(1);
            this.getBuilding();
            this.getEntries(this.cardAccesses.building_id);
        },

        computed: {

        },

        watch: {

            keySearch: function() {
                this.inputSearch=null;
                this.paginate__page=1;
                this.getAll();
            },

            show__items: function() {
                this.paginate__page=2;
                this.getAll();
            },

            entryId:function(){
                this.getAll();
                this.getClients();
                
                this.$store.watch(
                    (state)=>{
                        return this.$store.getters.getShowItem
                    },
                    (val)=>{
                        this.show__items=this.$store.getters.getShowItem;
                        this.getAll();
                    });

                this.$store.watch(
                    (state)=>{
                        return this.$store.getters.getPaginatePage
                    },
                    (val)=>{
                        this.paginate__page=this.$store.getters.getPaginatePage;
                        this.getAll();
                    });
            },

            error:function() {
                if(this.error != null) {
                    console.log('sad');
                    if(this.error.client_id != null || this.error.site_code != null || this.error.site_number != null ) {

                        this.showCardData=!this.showCardData;
                        this.modal.btnAdd=false;
                        this.modal.btnEdit=false;
                        this.modal.btnConfigAccess=true;
                        this.modal.btnCard=false;
                    }
                }

                 console.log('sad123');
            },

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
                console.log(this.cardsSite);
                this.$http.post('/getCards/'+this.entryId,this.cardsSite)
                    .then(response => {
                        this.cards=response.data.data;
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

                // this.watchPagination();
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

            getBuilding: function() {
                this.$http.get(`/getAllBuildings`)
                .then(response => {
                    console.log('dasd');
                    this.buildings=response.data.buildings;          
                })
                .catch(e => {
                    console.log(e);
                });
            },

            getEntries: function(param) {
                this.$http.get('/getBuilding/'+param)
                    .then(response => {
                        this.entriesBuilding=response.data.entries;
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                        // this.errorDetailsBuilding="This building not found";
                    });
            },

            getAccessPoints:function(param) {
                this.$http.get('/getAccessPoints/'+param)
                    .then(response => {
                        this.accessPointsEntry=response.data;
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                        // this.errorDetailsBuilding="This building not found";
                    });
            },

            getRelay:function(param){
                this.$http.get('/getRelays/'+param)
                    .then(response => {
                        this.relayAccessPoint=response.data;
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                        // this.errorDetailsBuilding="This building not found";
                    });
            },

            getCardAccess:function(idCard) {
                console.log(idCard);
                this.$http.get(`/getCardAccess/`+idCard)
                    .then(response => {
                        this.cardAccesses=response.data;
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            changeSearchKey:function(searchKey) {
                this.keySearch=[];
                console.log(searchKey);
                
                if(searchKey=="anything") {
                    this.keySearch=['clients.firstname','clients.lastname','cards.site_code','cards.site_number'];
                }
                else if(searchKey=="client") {
                    this.keySearch=['clients.firstname','clients.lastname'];
                }
                else {
                    this.keySearch=[searchKey];
                }
            },

            modalAdd:function() {
                this.modal.title="Add new card!";
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=true;
                this.modal.btnCard=false;
            },

            modalEdit:function() {
                this.modal.title="Edit card!";
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=true;
                this.btnCard=false;
            },

            modalConfig:function() {
                this.showCardData=!this.showCardData;
                this.modal.btnAdd=true;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=false;
                this.modal.btnCard=true;
            },

            prev:function() {
                // console.log('dfa');
                this.showCardData=!this.showCardData;
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=true;
                this.modal.btnCard=false;
            },

            getClients:function() {
                this.$http.get('/getClients/'+this.entryId)
                    .then(response => {
                        this.clients=response.data;
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            chooseClient:function() {
                this.details.client_id=this.details.client.id;
            },

            chooseEntry:function() {
                this.cardAccesses.entry_id=this.cardAccesses.entry.id;
                this.getAccessPoints(this.cardAccesses.entry_id);
            },

            chooseAccessPoint:function() {
                this.cardAccesses.accessPoint_id=this.cardAccesses.accessPoint.id;
                this.getRelay(this.cardAccesses.accessPoint_id);
                // this.getAccessPoints(this.cardAccesses.accessPoint_id);
            },

            changeStatus:function() {
                this.details.active=!this.details.active;
            },

            showDetailsAccessCard:function() {
                this.details_access=!this.details_access;
            }


        }
    }

</script>

<template src="./templates/cards.html">
</template>
