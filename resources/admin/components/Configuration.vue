<script>
    export default {
 		data: function() {
            return {
            	btnShowBuildings:false,
            	moduleBuildings:false,
            	buildings:false,
            	detailsBuilding:{},

            	buildingsAccess:[],
            	modules:{
            		role_modules:[
		            	{
		            		module:"Users",
		            		read:false,
		            		write:false,
		            		delete:false,
		            		access:false,
		            	},
		            	{
		            		module:"Services/Products",
		            		read:false,
		            		write:false,
		            		delete:false,
		            		access:false,
		            	},
		            	{
		            		module:"Configuration",
		            		read:false,
		            		write:false,
		            		delete:false,
		            		access:false,
		            	},
		            	{
		            		module:"Clients",
		            		read:false,
		            		write:false,
		            		delete:false,
		            		access:false,
		            	},
		            	{
		            		module:"Cards",
		            		read:false,
		            		write:false,
		            		delete:false,
		            		access:false,
		            	},
		            ],
		            name:null,
            	},

            	modulesAccess:[],
            }
        },
        props: {
        },

        filters: {
        },

        beforeCreate() {
        },

        created() {
        	this.getBuildings();
        },

        mounted() {
        },

        computed: { 
        },

        watch: {
        },

        methods:{

        	getBuildings:function() {
        		this.$http.get(`/getAllBuildings`)
        		.then(response => {
        			console.log(response.data);
        			this.buildings=response.data;
        		})
        		.catch(e => {
        			console.log(e.body);
        		})
        	},

        	getBuilding(idB) {
        		this.$http.get(`/getBuilding/`+idB)
        		.then(response => {
        			console.log(response.data);
        			this.detailsBuilding=response.data;
        		})
        		.catch(e => {
        			console.log(e.body);
        		})
        	},

        	showModuleBuildings:function() {
        		this.moduleBuildings=!this.moduleBuildings;
        		this.btnShowBuildings=!this.btnShowBuildings;
        	},
        	
        	giveAccess:function(i) {

        		this.modules.role_modules[i].access=true;
        	},

        	giveAccessBuilding:function(idB,name,i) {
        		console.log(idB);
        		console.log(i);
		      	this.buildingsAccess.push({
		      		id_building: idB,
		      		name: name,
		      		read: false,
        			write: false,
        			delete: false,
        		});

		      	this.$delete(this.buildings, i);

        	},

        	removeAccess:function(i) {

        		this.modules.role_modules[i].access=false;
        	},

        	removeAccessBuilding:function(idB,name,i) {
        		this.getBuilding(idB);
        		this.buildings.push(this.detailsBuilding);
		      	this.$delete(this.buildingsAccess, i);
        	},

        	activeRead:function(obj,i){
        		this.modules.role_modules[i].read=!this.modules.role_modules[i].read;
        		console.log(this.modules[i].read);
        	},

        	activeWrite:function(obj,i){
        		this.modules.role_modules[i].write=!this.modules.role_modules[i].write;
        		console.log(this.modules[i].write);
        	},

        	activeDelete:function(obj,i){
        		this.modules.role_modules[i].delete=!this.modules.role_modules[i].delete;
        		console.log(this.modules[i].delete);
        	},

        	activeReadBuilding:function(obj,i){
        		this.buildingsAccess[i].read=!this.buildingsAccess[i].read;
        	},

        	activeWriteBuilding:function(obj,i){
        		this.buildingsAccess[i].write=!this.buildingsAccess[i].write;
        	},

        	activeDeleteBuilding:function(obj,i){
        		this.buildingsAccess[i].delete=!this.buildingsAccess[i].delete;
        	},

        	deleteObject: function(index) {
		      	this.$delete(this.items, index);
		    },
        },
    }
</script>

<template src="./templates/configuration.html">
</template>
