<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                buildingsSite:[],
                setBuildings:null,
                setLengthBuildings:null,

                //data for list of buildings
                show__items:"10",
                paginate__page:1,
                key__search:'buildings.company',
                input__search:null,
                ascending:true,
                orderBy:'buildings.company',
                

                //data for details building
                companies:null,
                cities:null,
                neighborhoods:null,

                details__building: {
                    id:null,
                    company:'',
                    name:'',
                    city_id:'',
                    street:'',
                    neighborhood:'',
                    location:'(42,21)',
                    entries:[],

                },  

                error__add_objBuilding:{
                    company:null,
                    building:null

                },

                success__add_building:null,

                //data for paginate
                deactivate__min:true,
                deactivate__prev:true,
                deactivate__max:false,
                deactivate__next:false,
                
                //class css params


                //button show and hide
                addButton:false,
                editButton:false,
                clearButton:true,

            }
        },
        // props:['show__items'],

        beforeCreate() {
        },

        created() {

            this.$store.watch(
                (state)=>{
                    return this.$store.getters.main.getShowItem
                },
                (val)=>{
                    this.show__items=this.$store.getters.main.getShowItem;
                    this.Buildings();
                });

            this.$store.watch(
                (state)=>{
                    return this.$store.getters.main.getPaginatePage
                },
                (val)=>{
                    this.paginate__page=this.$store.getters.main.getPaginatePage;
                    this.Buildings();
                });
        },

        mounted() {
            this.Buildings();
            this.existingAddress();    
        },

        computed: {
            objBuildings:function() {
                return this.setBuildings;
            }, 
        },

        watch: {
            key__search: function() {
                this.input__search=null;
                this.paginate__page=1;
                this.Buildings();
            },

            show__items: function() {
                this.paginate__page=1;
                this.Buildings();
            },
        },

        methods: {
            Buildings:function() {
                this.buildingsSite={
                    limit:this.show__items,
                    page:this.paginate__page,
                    relation:this.key__search,
                    value:this.input__search,
                    asce:this.ascending,
                    orderBy:this.orderBy, 

                };     

                axios.post(`/getBuildings`,this.buildingsSite)
                .then(response => {
                    this.setBuildings=response.data.buildings;
                    this.setLengthBuildings=response.data.count;
                })
                .catch(e => {
                    console.log(e);
                });
            },

            existingAddress:function() {
                axios.get(`/getExistingAddresses`)
                .then(response => {
                    this.companies=response.data.companies;
                    this.cities=response.data.cities;
                    this.neighborhoods=response.data.neighborhoods;           
                })
                .catch(e => {
                    console.log(e);
                });
            },

            addBuilding:function() {
                axios.post(`/addBuilding`,
                    this.details__building,
                )
                .then(response => {
                    this.success__add_building="This building is save in system!";
                    this.clearBuilding();
                })
                .catch(e => {
                    if(e.response.data.company !=null)
                    {
                        this.error__add_objBuilding.company=e.response.data.company[0];
                    }
                    else if(e.response.data.building !=null)
                    {
                        this.error__add_objBuilding.building=e.response.data.building[0];
                    }
                    
                });
            },

            editBuilding:function(param_id) {
                this.details__building.id=param_id;
                this.editButton=true;
                this.addButton=false;
                this.clearButton=false;

                axios.get(`/getBuilding/`+param_id)
                .then(response => {
                    this.details__building.company=response.data.company;
                    this.details__building.name=response.data.name;
                    this.details__building.city_id=response.data.address.city_id;
                    this.details__building.street=response.data.address.street;
                    this.details__building.neighborhood=response.data.address.neighborhood;

                })
                .catch(e => {
                    console.log(e);
                });
            },

            updateBuilding:function() {
                axios.post(`/updateBuilding`,
                   this.details__building,
                )
                .then(response => {
                    console.log('je shum i fort')
                })
                .catch(e => {
                    console.log(e);
                     if(e.response.data.company !=null)
                    {
                        this.error__add_objBuilding.company=e.response.data.company[0];
                    }
                    else if(e.response.data.building !=null)
                    {
                        this.error__add_objBuilding.building=e.response.data.building[0];
                    }
                    else if(e.response.data.city_id !=null)
                    {
                        this.error__add_objBuilding.city_id=e.response.data.city_id[0];
                    }
                    else if(e.response.data.street !=null)
                    {
                        this.error__add_objBuilding.street=e.response.data.street[0];
                    }
                    else if(e.response.data.location !=null)
                    {
                        this.error__add_objBuilding.location=e.response.data.location[0];
                    }
                    else if(e.response.data.neighborhood !=null)
                    {
                        this.error__add_objBuilding.neighborhood=e.response.data.neighborhood[0];
                    }
                });

                // this.details__building.company=response.data.company;
                // this.details__building.name=response.data.building;
                // this.details__building.city_id=response.data.city_id;
                // this.details__building.street=response.data.street;
                // this.details__building.neighborhood=response.data.neighborhood;
            },

            deleteBuilding:function(param_id) {
                axios.delete(`/deleteBuilding/`+param_id)
                .then(response => {
                    console.log('U fshi me sukses');
                    this.Buildings();
                })
                .catch(e => {
                    console.log(e.respone);
                });
            },

            detailsBuilding:function(param_id) {
                axios.get(`/getBuilding/`+param_id)
                    .then(response => {

                        this.details__building = response.data;
                        console.log("");
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            clearBuilding:function(){   
                this.details__building.company='';
                this.details__building.name='';
                this.details__building.city_id='';
                this.details__building.street='';
                this.details__building.neighborhood='';

                this.error__add_building=null;
                this.succes__add_building=null;
                this.error__add_objBuilding.company=null;
                this.error__add_objBuilding.building=null;
            },

            Sort:function(orderBy,ascending){
                if (this.orderBy == orderBy) {
                    
                    if (this.ascending != ascending)
                    {
                        this.orderBy = orderBy;
                        this.ascending == ascending;
                    }
                    else {
                        this.orderBy = orderBy;
                        this.ascending = !ascending;
                    } 

                } else if (this.orderBy != orderBy){
                    
                    this.orderBy = orderBy;   
                }
                this.Buildings();
            },

            showFrmAdd:function(){
                this.addButton=true;
                this.editButton=false;
                this.clearButton=true
                ;

                this.clearBuilding();
            }, 

            // updateShowItems:function(show__items) {
            //     this.$emit('input',show__items);
            // },  
        },
    }
</script>

<template src="./templates/buildings.html">
</template>

