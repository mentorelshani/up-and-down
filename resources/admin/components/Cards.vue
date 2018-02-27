<script>
    export default {
        data() {
            return {
                cards:{},
                details:{
                    active:true,
                    client:{},
                    site_code:null,
                    site_number:null,
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
                elevatorsEntry:{},
                accessPointsElevator:{},
                relays:{},
                clients:{},

                cardHaveAccess:{},
                // detailsCardAccess:{},// look maybe this var should delete 
                cardAccesses:{
                    building_id:null,
                    entry_id:null,
                    accessPoint_id:null,
                    relay_id:[],
                    card_id:null,
                },

                pagination:{},

                showCardData:true,
                setLengthCardsEntry:{},

                error_AccessCard:{},
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
                    btnAddAccess:false,
                },

                details_access:true,
                showBuilding:0,
            }
        },

        props: {
            entryId:null,
        },

        beforeCreate() {
        },

        created() {
            this.cardAccesses.building_id=parseInt(this.$route.params.id);
            this.getRelay(406);

        },

        mounted() {
            // this.getElevators(1);
            this.getBuilding();
            this.getEntries(this.cardAccesses.building_id);
        },

        computed: {

        },

        watch: {
            keySearch: function() {
                this.inputSearch=null;
                this.paginate__page=1;
                // this.getAll();
            },

            show__items: function() {
                this.paginate__page=2;
                // this.getAll();
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

            // detailsCardAccess:function() {
            //     // if(this.detailsCardAccess != null) {
            //         // for(var i=0;i<)
            //         console.log(this.cardAccesses.relay_id.length);
            //         // this.cardAccesses.relay_id=this.detailsCardAccess.relays;
            //         console.log('fasfasdasd');
            //     // }
            // }
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
            },

            add:function() {
                this.$http.post('/addCard',this.details)
                    .then(response => {
                        this.cardAccesses.card_id=response.data.id;
                        console.log(this.details);
                        console.log("Card u regjistrua me sukses = !false");
                        this.error={};
                        this.giveAccess();
                    })
                    .catch(e => {
                        console.log("Klienti u regjistrua me sukses = false");
                        console.log(e.body);
                        this.error=e.body;
                    });
            },

            giveAccess:function() {
                 this.$http.post('/giveAccessToCard',this.cardAccesses)
                    .then(response => {
                        this.error_AccessCard={};
                        this.getAll();
                        this.getCardAccess(this.cardAccesses.card_id);
                        this.modal.btnAddAccess=true;
                        this.modal.btnAdd=false;

                        this.cardAccesses.relay_id=[];
                    })
                    .catch(e => {
                        console.log("Access u dha me sukses = false");
                        console.log(e.body);
                        this.error_AccessCard=e.body;
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
                this.$http.delete(`/deleteCard/`+idCard)
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
                    this.buildings=response.data;          
                })
                .catch(e => {
                    console.log(e);
                });
            },

            getEntries: function(building_id) {
                this.$http.get('/getBuilding/'+building_id)
                    .then(response => {
                        this.entriesBuilding=response.data.entries;
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                        // this.errorDetailsBuilding="This building not found";
                    });
            },

            getElevators:function(entry_id) {
                this.$http.get('/getElevators/'+entry_id)
                    .then(response => {
                        this.elevatorsEntry=response.data;
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                        // this.errorDetailsBuilding="This building not found";
                    });
            },

            getAccessPoints:function(elevatore_id) {
                this.$http.get('/getAccessPointsByElevator/'+elevatore_id)
                    .then(response => {
                        this.accessPointsElevator=response.data;
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                        // this.errorDetailsBuilding="This building not found";
                    });
            },

            getRelay:function(accessPoint_id){
                this.$http.get('/getRelays/'+accessPoint_id)
                    .then(response => {
                        this.relays=response.data;
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                        // this.errorDetailsBuilding="This building not found";
                    });
            },

            getRealyDetailsConfig:function(accessPoint_id,relay){
                this.$http.get('/getRelay/'+accessPoint_id+'/'+relay)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                        // this.errorDetailsBuilding="This building not found";
                    });
            },

            getCardAccess:function(idCard) {
                this.showBuilding=0;
                console.log(idCard);
                this.cardHaveAccess={};
                this.$http.get(`/getCardAccess/`+idCard)
                    .then(response => {
                        this.cardHaveAccess=response.data;
                        this.detailsCardAccess=this.cardHaveAccess[0].entries[0].elevators[0].access_points[0];
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
                this.details={};
                this.details.active=true;
                this.details.client={};

                this.cardHaveAccess={};
                this.cardAccesses.entry={};
                this.cardAccesses.elevator={};
                this.relays={};
                this.elevatorsEntry={};
                this.cardAccesses.relay_id=[];
            
                this.modal.title="Add new card!";

                this.showCardData=true;
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=true;
                this.modal.btnCard=false;
                this.modal.btnAddAccess=false;
                this.accessPointsElevator={};
                this.getClients();
                this.getAll();
            },

            modalEdit:function(card_id) {
                this.modal.title="Edit card!";
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=true;
                this.modal.btnAddAccess=false;

                this.btnCard=false;
            },

            modalConfig:function() {
                this.showCardData=!this.showCardData;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=false;
                this.modal.btnCard=true;

                // if(this.details.client != null ) {
                //     this.modal.btnAdd=false;
                //     this.modal.btnAddAccess=true;
                // }
                // else {
                //     this.modal.btnAdd=true;
                //     this.modal.btnAddAccess=false;
                // }

                if(this.details.client=={} ) {
                    this.modal.btnAdd=true;
                    this.modal.btnAddAccess=false;
                }
                else {
                    this.modal.btnAdd=true;
                    this.modal.btnAddAccess=false;
                }
            },

            prev:function() {
                // console.log('dfa');
                this.showCardData=!this.showCardData;
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=true;
                this.modal.btnCard=false;
                this.modal.btnAddAccess=false;
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

            getDetailsAccess:function(accessPoint_id) {
                // this.getRelay(accessPoint_id);
                for (var i = 0; i < this.relays.length; i++) {
                    if(this.relays[i].created_at != this.relays[i].updated_at)
                    {
                        this.getRealyDetailsConfig(accessPoint_id,this.relays[i].id);
                        console.log(this.relays[i].id);
                    }
                    // this.cardAccesses.relay_id.push({i:this.})
                }

            },

            chooseClient:function() {

                this.details.client_id=this.details.client.id;
            },

            chooseEntry:function() {
                this.cardAccesses.entry_id=this.cardAccesses.entry.id;
                this.getElevators(this.cardAccesses.entry_id);
                this.cardAccesses.elevator={};
                this.cardAccesses.elevator_id=null;

                this.relays={};
            },

            chooseElevator:function() {
                this.cardAccesses.elevator_id=this.cardAccesses.elevator.id;
                this.getAccessPoints(this.cardAccesses.elevator_id);
                // this.getElevators(this.cardAccesses.accessPoint_id);
                this.relays={};
            },

            chooseAccessPoint:function() {
                this.relays={};
                this.cardAccesses.accessPoint_id=this.cardAccesses.accessPoint.id;
                this.getRelay(this.cardAccesses.accessPoint_id);
                this.cardAccesses.relay_id=[];               
            },

            changeStatus:function() {
                console.log(this.details.active);
                this.details.active=!this.details.active;
                this.modalConfig();
                this.prev();
            },

            showDetailsAccessCard:function() {

                this.details_access=!this.details_access;
            },

            showDetailsBuilding:function(iElevator,iAccessPoint,iEntry,iBuilding,idAccessPoint) {
                if(this.showBuilding==iElevator){
                    // this.relays={}; 
                    this.showBuilding=0;
                }
                else {
                    this.showBuilding=iElevator;
                    // this.getRelay(idAccessPoint); mundemi me ba Edit buton per kete pune 
                }
                
                // this.cardAccesses.relay_id=this.cardHaveAccess[iBuilding].entries[iEntry].elevators[iElevator-1].access_points[iAccessPoint].relays;
                // this.detailsCardAccess=this.cardHaveAccess[iBuilding].entries[iEntry].elevators[iElevator-1].access_points[iAccessPoint];
                // console.log(this.cardHaveAccess[iBuilding].entries[iEntry].elevators[iElevator-1].access_points[iAccessPoint]);

                // console.log(this.detailsCardAccess);
                // console.log('xzzxc');
            },

        }
    }

</script>

<template src="./templates/cards.html">
</template>
