<script>
    import alert from '../components/service/sweetAlert.js'
    // const alert =new sweetAlert();

    export default {
        data() {
            return {
                cards:{},
                details:{
                    active:null,
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

                show__items:"20",
                paginate__page:1,
                keySearch:["cards.site_code","cards.site_number"],
                inputSearch:null,
                ascending:true,
                orderBy:'cards.site_code',
                
                buildings:[],
                entriesBuilding:[],
                elevatorsEntry:[],
                accessPointsElevator:[],
                relays:{},
                relaysConfig:{},
                clients:[],

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

                searchBy:'Filter by',
                show_addAccess:false,
                btnGiveAccess:false,
                btnEditAccessPoint:false,
                // isAddNewCard:null,
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

            accessPoint_id() {
                return this.cardAccesses.access_point_id;
            },

            elevatorId() {
                return this.cardAccesses.elevator_id;
            },

            entry_id() {
                return this.cardAccesses.entry_id;
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

            idClient() {
                return this.details.client.id;
            },

            siteCode() {
                return this.details.site_code;
            },

            cardCode() {
                return this.details.site_number;
            }
        },

        watch: {
            keySearch: function() {
                this.inputSearch=null;
                this.paginate__page=1;
                this.getAll();
            },

            show__items: function() {
                this.paginate__page=1;
                this.getAll();
            },

            entryId:function(){
                this.getAll();
                // this.getClients();
                
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

                        // this.showCardData=!this.showCardData;
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
            },

            relayChecked:function() {
                for (var i = 0; i < this.cardAccesses.relay_id.length; i++) {
                    if(this.cardAccesses.relay_id[i] == null) {
                        this.$delete(this.cardAccesses.relay_id,[i]);
                    }
                }
            },

            deleteRelays:function() {
                if(this.deleteRelayObj.relay_id.length !=0)
                    this.deleteAccessCard();
            },

            insertRelays:function() {
                if(this.insertRelayObj.relay_id.length !=0)
                    this.insterAccessCard();
            },

            accessPoint_id:function() {
                // this.cardAccesses.elevator_id=this.cardAccesses.accessPoint.elevator_id;
                // console.log('hejj hejj123');
                // this.getElevator(this.cardAccesses.elevator_id);              
            },

            elevatorId:function() {
                console.log('hejj hejj');
            },

            entry_id:function() {
                // this.getEntry(this.cardAccesses.entry_id);              
            },


            // idClient:function() {
            //     this.modal.btnAddAccess=false;
            //     this.modal.btnAdd=true;
            // },

            // siteCode:function() {
            //     this.modal.btnAddAccess=false;
            //     this.modal.btnAdd=true;
            // },

            // cardCode:function() {
            //     this.modal.btnAddAccess=false;
            //     this.modal.btnAdd=true;
            // },
        },

        methods: {
            labelClient:function(option) {

                return `${option.firstname} ${option.lastname}`; 
            },

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

                        this.dataLength=response.data.total;

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
                let vm=this;

                alert.add(function() {
                    vm.$http.post('/addCard',vm.details)
                        .then(response => {
                            vm.cardAccesses.card_id=response.data.id;
                            vm.error={};
                            vm.showCardData=!vm.showCardData;

                            vm.modal.btnAddAccess=true;
                            vm.modal.btnAdd=false;
      
                            // swal({ title:"Card hes been added!", text:null, type:"success" });
                        })
                        .catch(e => {
                            swal({ title:"Error!", text:'This row has not been added!', type:"error" });
                            vm.error=e.body;
                        });
                }); 
            },

            giveAccess:function() {

                if(this.cardAccesses.entry_id!=null && this.cardAccesses.elevator_id!=null && this.cardAccesses.access_point_id!=null) {
                    this.$http.post('/giveAccessToCard',this.cardAccesses)
                        .then(response => {
                            this.error_AccessCard={};
                            this.getAll();
                            this.getCardAccess(this.cardAccesses.card_id);

                            this.modal.btnAdd=false;
                            this.modal.btnEdit=false;
                            this.modal.btnConfigAccess=false;
                            this.modal.btnCard=false;
                            this.modal.btnAddAccess=true;

                            this.cardAccesses.relay_id=[];
                            swal({ title:"The access in card hes been added!", text:null, type:"success" });
                            // }
                        })
                        .catch(e => {
                            this.error_AccessCard=e.body;
                            swal({ title:"Select floor!", text:null, type:"error" });
                        }); 
                }   
                else {
                    swal({ title:"Choose Entey, Elevator and Access Point!", text:null, type:"warning" });
                }
            },

            edit:function() {
                let vm=this;

                alert.modify(function() {
                    vm.$http.post('/updateCard',vm.details)
                        .then(response => {
                            console.log("Klienti u përditsua me sukses = !false");
                            vm.detailsCopy=vm.details;
                            vm.error={};
                            vm.getAll();
                        })
                        .catch(e => {
                            swal({ title:"Error!", text:'This row has not been updated!', type:"error" });
                            vm.error=e.body;
                        });
                    });
            },

            getDetails:function(cardObj) {
                this.details=cardObj;
                console.log(cardObj);
                this.cardAccesses.card_id=cardObj.id;
                this.modal.title="Information Card Access";
            },

            destroy:function(idCard) {
                let vm=this;

                alert.delete(function() {
                     vm.$http.delete(`/deleteCard/`+idCard)
                        .then(response => {
                            vm.getAll();
                        })
                        .catch(e => {
                            alert.information("Error",'This row has not been removed!',"error");
                        });
                    })
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
                        this.cardAccesses.entry_id=entry_id;
                        this.cardAccesses.entry=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },

            getElevator:function(elevator_id) {
                this.$http.get('/getElevator/'+elevator_id)
                    .then(response => {
                        this.cardAccesses.elevator_id=elevator_id;
                        this.cardAccesses.elevator=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },

            getAccessPoint:function(accessPoint_id) {
                this.$http.get('/getAccessPoint/'+accessPoint_id)
                    .then(response => {
                        this.cardAccesses.access_point_id=accessPoint_id;
                        this.cardAccesses.accessPoint=response.data;

                        // if(this.modal.titele="Information Card Access") {
                        //     this.getElevator(response.data.elevator_id);
                        //     this.getEntry(response.data.elevator.entry_id);
                        // }

                        console.log(this.cardAccesses);

                    })
                    .catch(e => {
                        console.log(e);
                    })
            },

            getRealyDetailsConfig:function(accessPoint_id){

                // if(this.modal.title!="Add new card!") {
                    this.cardAccesses.relay_id=[];
                    this.$http.get('/getRelays/'+accessPoint_id+'/'+this.Card_id)
                        .then(response => {
                            this.relaysConfig=response.data;

                            this.getAccessPoint(accessPoint_id);
                            this.cardAccesses.access_point_id=accessPoint_id;
                            

                            if(this.modal.title=="Information Card Access") {     
                                this.show_addAccess=false;
                                this.btnGiveAccess=false;
                                this.btnEditAccessPoint=true;

                            }

                            this.relays=this.relaysConfig;
                            this.cardAccesses.access_point_id=accessPoint_id;
                        })
                        .catch(e => {
                            console.log(e);
                            // this.errorDetailsBuilding="This building not found";
                        });
                // }
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

                // this.deleteRelayObj.card_id=idCard;
                // this.insertRelayObj.card_id=idCard;

                this.$http.get(`/getCardAccess/`+idCard)
                    .then(response => {
                        this.cardHaveAccess=response.data;
                        this.detailsCardAccess=this.cardHaveAccess[0];

                        this.getEntry(response.data[0].id);
                        this.getElevator(response.data[0].entries[0].elevators[0].id);
                        this.getAccessPoint(response.data[0].entries[0].elevators[0].access_points[0].id);
                        this.getRealyDetailsConfig(response.data[0].entries[0].elevators[0].access_points[0].id);
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            changeSearchKey:function(searchKey) {
                this.getAll();
                this.keySearch=[];
                console.log(searchKey);
                
                if(searchKey=="everything") {
                    this.keySearch=['clients.firstname','clients.lastname','cards.site_code','cards.site_number'];
                    this.searchBy="Everything";
                }
                else if(searchKey=="client") {
                    this.keySearch=['clients.firstname','clients.lastname'];
                    this.searchBy="Client";
                }
                else {
                    this.keySearch=[searchKey];
                    if(searchKey=="cards.site_code") {
                        this.searchBy="Site Code";
                    }

                    if(searchKey=="cards.site_number") {
                        this.searchBy="Card Code";
                    }
                }
            },

            modalAdd:function() {
                this.details={};
                this.details.active=true;

                // if(this.details.client=={}) {
                //     this.details.client={};
                // }

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
                this.elevatorsEntry=[];

            
                this.modal.title="Add new card!";

                this.showCardData=true;
                this.modal.btnAdd=true;
                this.modal.btnEdit=false;
                this.modal.btnConfigAccess=false;
                this.modal.btnCard=false;
                this.modal.btnAddAccess=false;
                this.accessPointsElevator=[];
                this.getClients();
                this.getAll();
            },

            modalEdit:function(card) {
                console.log(card);
                this.Card_id=card.id;
                this.modal.title="Edit card!";
                this.modal.btnCard=false;
                this.modal.btnAdd=false;
                this.modal.btnEdit=true;
                this.modal.btnConfigAccess=false;
                this.modal.btnAddAccess=false;

                this.cardAccesses.card_id=card.id;
                this.showCardData=true;
                this.error={};
                this.getClient(card.client_id);

                this.details=card;
                // this.detailsCopy=card;
                console.log(card);

                this.getCardAccess(card.id);
            },

            modalConfig:function() {
                this.showCardData=!this.showCardData;
                // this.modal.btnEdit=false;
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
                        // this.clients=
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            accessCardEdit:function() {
                let vm=this;

                vm.cardAccesses.card_id=vm.Card_id;

                alert.modify(function() {
                    vm.$http.post('/updateCardAccess',vm.cardAccesses)
                        .then(response => {
                            // this.deleteRelayObj.relay_id=response.data.delete;
                            // this.insertRelayObj.relay_id=response.data.insert;
                            vm.getCardAccess(vm.Card_id);


                        })
                        .catch(e => {
                            swal({ title:"Error!", text:'This row has not been updated!', type:"error"});
                        });
                });
            },

            editCardAccess:function() {
                this.edit();
                this.accessCardEdit();
            },

            chooseClient:function() {
                this.details.client_id=this.details.client.id;
                this.getClient(this.details.client_id);
                console.log(this.details.client_id);
            },

            chooseEntry:function() {
                this.cardAccesses.entry_id=this.cardAccesses.entry.id;
                this.getEntry(this.cardAccesses.entry_id);

                this.getElevators(this.cardAccesses.entry_id);
                this.cardAccesses.elevator=[];
                this.cardAccesses.elevator_id=null;

                this.cardAccesses.accessPoint=[];
                this.cardAccesses.access_point_id=null;

                this.relays={};
            },

            chooseElevator:function() {
                this.cardAccesses.elevator_id=this.cardAccesses.elevator.id;
                this.getElevator(this.cardAccesses.elevator_id);
                this.getAccessPoints(this.cardAccesses.elevator_id);
                // this.getElevators(this.cardAccesses.access_point_id);

                this.cardAccesses.accessPoint=[];
                this.cardAccesses.access_point_id=null;

                this.relays={};
            },

            chooseAccessPoint:function() {
                this.relays={};
                this.cardAccesses.access_point_id=this.cardAccesses.accessPoint.id;
                this.getAccessPoint(this.cardAccesses.access_point_id);
                // if(this.modal.title="Edit card!") {
                // if(this.modal.title=="Add new card!") {
                this.getRelay(this.cardAccesses.access_point_id);
                // }
                this.cardAccesses.relay_id=[]; 

                if(this.modal.title=="Information Card Access") {
                    this.btnGiveAccess=true;
                    this.btnEditAccessPoint=false;
                }


                // }
                // this.modal.btnAdd=true;
                // this.modal.btnEdit=false;
            },

            changeStatus:function() {
                console.log(this.details.active);
                this.details.active=!this.details.active;
                // this.modalConfig();
                // this.prev();
            },

            changeStatusCard:function(card) {
                let vm=this;
                
                vm.details=card;
                vm.details.active=!this.details.active;              

                alert.modify(function() {
                    vm.$http.post('/updateCard',vm.details)
                        .then(response => {
                            console.log("Klienti u përditsua me sukses = !false");
                            vm.detailsCopy=vm.details;
                            vm.error={};
                            vm.getAll();
                        })
                        .catch(e => {
                            swal({ title:"Error!", text:'This row has not been updated!', type:"error" });
                            this.details.active=!this.details.active;
                        });
                    });
            },

            showDetailsAccessCard:function() {
                let vm=this;
                vm.details.active=!vm.details.active;
                console.log('hej');
                vm.showCardData=false;
                vm.showCardData=true;
            },

            showDetailsBuilding:function(iElevator,accessPoint_id,elevator_id,entry_id) {

                if(this.showBuilding==iElevator){
                    // this.relays={}; 
                    this.showBuilding=0;
                }
                else {
                    this.showBuilding=iElevator;
                }
                
                // if(this.modal.title="Edit card!") {
                //     this.chooseEntry(entry_id);
                //     this.chooseElevator(elevator_id);
                //     this.chooseAccessPoint(accessPoint_id);
                //     // this.getRealyDetailsConfig(accessPoint_id);
                //     // this.getCardAccess(this.Card_id);

                //     this.modal.btnAddAccess=false;
                //     this.modal.btnEdit=true;
                //     this.disabledCardInfo = false;
                // }
            },

            addNewAccess:function() {
                if(this.modal.title=="Edit card!") {
                    this.modal.btnAddAccess=true;
                    this.modal.btnEdit=false;
                    this.disabledCardInfo = true;
                }
            },

            newAccess:function() {
                this.show_addAccess=true;

                this.cardAccesses.access_point_id=null;
                this.cardAccesses.elevator_id=null;
                this.cardAccesses.accessPoint={};
                this.cardAccesses.elevator={};
                this.cardAccesses.entry_id={};
                this.cardAccesses.entry=null;

                this.relays={};
                this.btnEditAccessPoint=false;
                this.btnGiveAccess=true;
            },
        }
    }

</script>

<template src="./templates/cards.html">
</template>
