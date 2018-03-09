<script>
    import sweetAlert from '../components/service/sweetAlert.js'
    const alert =new sweetAlert();

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

                detailsCopy:{},
                cardsSite:{},
                Card_id:null,

                deleteRelayObj:{
                    card_id:null,
                    relay_id:[],
                },
                insertRelayObj:{
                    card_id:null,
                    relay_id:[],
                },

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
                relaysConfig:{},
                clients:{},

                cardHaveAccess:{},
                detailsCardAccess:{},// look maybe this var should delete 
                cardAccesses:{
                    building_id:null,
                    entry_id:null,
                    access_point_id:null,
                    relay_id:[],
                    card_id:null,
                    accessPoint:{id:null},
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
                disabledCardInfo:false,
            }
        },

        props: {
            entryId:null,
        },

        beforeCreate() {
        },

        created() {
            this.cardAccesses.building_id=parseInt(this.$route.params.id);
            // alert.confirm('Change!','Are you sure','warning','Save')     
        },

        mounted() {
            // this.getElevators(1);
            this.getBuilding();
            this.getEntries(this.cardAccesses.building_id);
        },

        computed: {
            relayChecked() {
                return this.cardAccesses.relay_id;
            },

            deleteRelays() {
                return this.deleteRelayObj.relay_id; 
            },

            insertRelays() {
                return this.insertRelayObj.relay_id; 
            },

            relayCheckedLength() {
                return this.cardAccesses.relay_id.length;
            },

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
                    if(this.error.client_id != null || this.error.site_code != null || this.error.site_number != null ) {

                        this.showCardData=!this.showCardData;
                        this.modal.btnAdd=false;
                        this.modal.btnEdit=false;
                        this.modal.btnConfigAccess=true;
                        this.modal.btnCard=false;
                    }
                }
            },

            relaysConfig:function() {
                var j = 0;
                for (var i = 0; i < this.relaysConfig.length; i++) {
                    if(this.relaysConfig[i].checked == true) { 
                        this.cardAccesses.relay_id[j++]=this.relaysConfig[i].id;
                    }
                }

                // if(j==0 || this.showCardData==false) {
                //     this.modal.btnAddAccess=true;
                //     this.modal.btnEdit=false;
                //     // this.disabledCardInfo = true;
                // }
                // else {
                //     this.modal.btnAddAccess=false;
                //     this.modal.btnEdit=true;
                //     // this.disabledCardInfo = true;
                // }
            },

            relayChecked:function() {
                for (var i = 0; i < this.cardAccesses.relay_id.length; i++) {
                    if(this.cardAccesses.relay_id[i] == null) {
                        this.$delete(this.cardAccesses.relay_id,[i]);
                    }
                }
            },

            // relayCheckedLength:function() {
            //     if(this.relayCheckedLength ==0.) {

            //     }
            //     console.log();
            // },

            deleteRelays:function() {
                if(this.deleteRelayObj.relay_id.length !=0)
                    this.deleteAccessCard();
            },

            insertRelays:function() {
                if(this.insertRelayObj.relay_id.length !=0)
                    this.insterAccessCard();
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
                this.$http.post('/getCards/'+this.entryId,this.cardsSite)
                    .then(response => {
                        this.cards=response.data.data;

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
                        this.getCardAccess(this.Card_id);
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
                        this.detailsCopy=this.details;
                        this.error={};
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u përditsua me sukses = false");
                        console.log(e.body);
                        this.error=e.body;
                    });
            },

            getDetails:function(cardObj) {
                this.details=cardObj;
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

            getClient:function(client_id) {
                this.$http.get('/getClient/'+client_id)
                    .then(response => {
                        this.details.client=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },

            getEntry:function(entry_id) {
                this.$http.get('/getEntry/'+entry_id)
                    .then(response => {
                        this.cardAccesses.entry=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },

            getElevator:function(elevator_id) {
                this.$http.get('/getElevator/'+elevator_id)
                    .then(response => {
                        this.cardAccesses.elevator=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },

            getAccessPoint:function(accessPoint_id) {
                this.$http.get('/getAccessPoint/'+accessPoint_id)
                    .then(response => {
                        this.cardAccesses.accessPoint=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },

            getRealyDetailsConfig:function(accessPoint_id){

                if(this.modal.title!="Add new card!") {
                    this.cardAccesses.relay_id=[];
                    this.$http.get('/getRelays/'+accessPoint_id+'/'+this.Card_id)
                        .then(response => {
                            this.relaysConfig=response.data;
                            this.cardAccesses.access_point_id=response.data[0].access_point_id;

                            if(this.modal.title == "Edit card!") {
                                this.relays=this.relaysConfig;
                                this.cardAccesses.access_point_id=accessPoint_id;
                                // this.cardAccesses.access_point_id=this.relaysConfig[0].access_point_id;
                            }
                        })
                        .catch(e => {
                            console.log(e);
                            // this.errorDetailsBuilding="This building not found";
                        });
                }
            },

            deleteAccessCard:function(){
                this.$http.delete(`/deleteAccessFromCard`,{body:this.deleteRelayObj})
                    .then(response => {
                        console.log('U fshia me sukses!');
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            insterAccessCard:function(){
                this.$http.post('/giveAccessToCard',this.insertRelayObj)
                    .then(response => {
                        console.log('Menti osht shume i BOS');
                    })
                    .catch(e => {
                        console.log("Access u dha me sukses = false");
                        console.log(e.body);
                        this.error_AccessCard=e.body;
                    }); 
            },

            deleteAllAccessCard:function(card_id){
                this.$http.delete(`/deleteAccessFromCard/`,card_id)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            getCardAccess:function(idCard) {
                this.showBuilding=0;
                this.cardHaveAccess={};
                this.Card_id=idCard;

                this.deleteRelayObj.card_id=idCard;
                this.insertRelayObj.card_id=idCard;

                this.$http.get(`/getCardAccess/`+idCard)
                    .then(response => {
                        this.cardHaveAccess=response.data;
                        this.detailsCardAccess=this.cardHaveAccess[0];

                        this.chooseEntry(response.data[0].id);
                        this.chooseElevator(response.data[0].entries[0].elevators[0].id);
                        this.chooseAccessPoint(response.data[0].entries[0].elevators[0].access_points[0].id);
                        this.getRealyDetailsConfig(response.data[0].entries[0].elevators[0].access_points[0].id);
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
                this.cardAccesses={};

                this.cardAccesses.building_id=parseInt(this.$route.params.id);
                this.cardAccesses.entry_id=null;
                this.cardAccesses.entry={};
                this.cardAccesses.elevator_id=null;
                this.cardAccesses.elevator={};
                this.cardAccesses.access_point_id=null;
                this.cardAccesses.accessPoint={};

                this.cardAccesses.card_id=null;
                this.cardAccesses.relay_id=[];
                this.relays={};
                this.elevatorsEntry={};

            
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

            modalEdit:function(card) {
                this.Card_id=card.id;
                this.modal.title="Edit card!";
                this.modal.btnCard=false;
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=true;
                this.modal.btnAddAccess=false;

                this.cardAccesses.card_id=card.id;
                this.showCardData=true;
                this.error={};
                this.details=card;
                // this.detailsCopy=card;
                console.log(card);

                this.getCardAccess(card.id);
            },

            modalConfig:function() {
                this.showCardData=!this.showCardData;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=false;
                this.modal.btnCard=true;

                if(this.modal.title == "Edit card!")
                {
                    this.modal.btnEdit=true;
                    this.modal.btnConfigAccess=false;
                    this.modal.btnCard=true;
                }
                else {
                    if(this.details.client=={} ) {
                        this.modal.btnAdd=true;
                        this.modal.btnAddAccess=false;
                    }
                    else {
                        this.modal.btnAdd=true;
                        this.modal.btnAddAccess=false;
                    }
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

            accessCardEdit:function() {
                this.cardAccesses.card_id=this.Card_id;

                this.$http.post('/updateCardAccess',this.cardAccesses)
                    .then(response => {
                        console.log(response.data);
                        this.deleteRelayObj.relay_id=response.data.delete;
                        this.insertRelayObj.relay_id=response.data.insert;
                    })
                    .catch(e => {
                        console.log(e.body);
                 
                    });
            },

            editCardAccess:function() {
                this.edit();
                this.accessCardEdit();
            },

            chooseClient:function(client_id) {
                this.getClient(client_id);
            },

            chooseEntry:function(entry_id) {
                this.getEntry(entry_id);
                this.cardAccesses.entry_id=entry_id;

                this.getElevators(entry_id);
                this.cardAccesses.elevator={};
                this.cardAccesses.elevator_id=null;

                this.cardAccesses.accessPoint={};
                this.cardAccesses.access_point_id={};

                this.relays={};
            },

            chooseElevator:function(elevator_id) {
                this.getElevator(elevator_id);
                this.getAccessPoints(elevator_id);
                this.cardAccesses.elevator_id=elevator_id;
                // this.getElevators(this.cardAccesses.access_point_id);
                this.relays={};
            },

            chooseAccessPoint:function(accessPoint_id) {
                this.relays={};
                this.getAccessPoint(accessPoint_id);
                this.cardAccesses.access_point_id=accessPoint_id;
                // if(this.modal.title="Edit card!") {
                // if(this.modal.title=="Add new card!") {
                this.getRelay(this.cardAccesses.access_point_id);
                // }
                this.cardAccesses.relay_id=[]; 

                if(this.modal.title=="Edit card!") {
                    this.detailsConpy=this.details; 
                    this.getRealyDetailsConfig(accessPoint_id);
                }
                // }
                // this.modal.btnAdd=true;
                // this.modal.btnEdit=false;
            },

            changeStatus:function() {
                console.log(this.details.active);
                this.details.active=!this.details.active;
                this.modalConfig();
                this.prev();
            },

            changeStatusCard:function(card) {
                this.details=card;
                this.details.active=!this.details.active;
                
                swal({
                    title: 'Are you sure?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, seve it!'
                }).then((result) => {
                    if (result.value) {
                        this.edit();
                        alert.information("Success",null,"success");
                    }
                    else {
                        this.details.active=!this.details.active;
                    }
                })
            },

            showDetailsAccessCard:function() {

                this.details_access=!this.details_access;
            },

            showDetailsBuilding:function(iElevator,accessPoint_id,elevator_id,entry_id) {

                if(this.showBuilding==iElevator){
                    // this.relays={}; 
                    this.showBuilding=0;
                }
                else {
                    this.showBuilding=iElevator;
                }
                
                if(this.modal.title="Edit card!") {
                    this.chooseEntry(entry_id);
                    this.chooseElevator(elevator_id);
                    this.chooseAccessPoint(accessPoint_id);
                    // this.getRealyDetailsConfig(accessPoint_id);
                    // this.getCardAccess(this.Card_id);

                    this.modal.btnAddAccess=false;
                    this.modal.btnEdit=true;
                    this.disabledCardInfo = false;
                }
            },

            addNewAccess:function() {
                if(this.modal.title="Edit card!") {
                    this.modal.btnAddAccess=true;
                    this.modal.btnEdit=false;
                    this.disabledCardInfo = true;
                }
            }

        }
    }

</script>

<template src="./templates/cards.html">
</template>
