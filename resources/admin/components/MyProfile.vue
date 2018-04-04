<script>
    export default {
 		data: function() {
            return {
            	showEditForm:true,
            	showFrmDetails:true,
            	showFrmAccess:false,

            	showMinAccess:false,
            	showMaxAccess:true,
            	showMinDetails:true,
            	showMaxDetails:false,
            }
        },
        props: {
        },

        filters: {
        },

        beforeCreate() {
        },

        created() {
        },

        mounted() {
        },

        computed: { 
        },

        watch: {
        },

        methods:{
        	editModal:function() {
        		this.showEditForm=!this.showEditForm;
        	},

        	update:function() {
        		this.showEditForm=!this.showEditForm;
        	},

        	FrmDetails:function() {
        		this.showFrmDetails=!this.showFrmDetails;

        		this.showMinDetails=!this.showMinDetails;
        		this.showMaxDetails=!this.showMaxDetails;
        	},

        	FrmAccess:function() {
        		this.showFrmAccess=!this.showFrmAccess;

        		this.showMinAccess=!this.showMinAccess;
        		this.showMaxAccess=!this.showMaxAccess;
        	},

        },
    }
</script>

<template src="./templates/myProfile.html">
</template>
