<script>

	import TextEditor from './helpers/TextEditor.vue'
	import Vue from 'vue'



	//Impost Component
	import Menu_Header from '../components/includes/Menu-Header.vue'
	import Menu_itemsFooter from '../components/includes/Menu-itemsFooter.vue'
	import AccessPoints from '../components/AccessPoints.vue'
	import Elevator from '../components/Elevators.vue'
	import Clients from '../components/Clients.vue'


	//Call Component
	Vue.component('MenuHeader',Menu_Header);
	Vue.component('MenuItemFooter',Menu_itemsFooter);
	Vue.component('AccessPointsTab',AccessPoints);
	Vue.component('ElevatorsTab',Elevator);
	Vue.component('ClientsTab',Clients);


	export default {
		name: 'app',
		components: {
			TextEditor
		},
		mounted: function () {
			
		},
		methods: {
			updateShowItems:function(showItem) {
                this.$emit('select',showItem);
            },
		}
	}
</script>

<template>
	<div>
		<div class="pages">
			<menu-header></menu-header>
			<div class="card__layout--main">
				<router-view class="body__view"></router-view>
			</div>
		</div>	
	</div>
</template>