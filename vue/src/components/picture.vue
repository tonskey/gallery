<template>
<div v-if="picture" class="row">
	<div class="col-md-12">
		<div class="page-header">
 			<h2>
 				{{picture.title}}
 			</h2>
		</div>
		<div class="wrap">
			<img 
				:src="picture.picture" 
				:alt="picture.title"
				class="img img-thumbnail"
			>
		</div>
		<br>
		<div class="wrap text-center">
			<p>{{picture.description}}</p>
		</div>
		Views:{{picture.views}} <br>
		Created: {{picture.created_at}} <br>
	</div>
</div>
</template>
<script>
export default {
	name: 'picture',
	data (){
		return{
			picture:null,
		}
	},
	methods:{
		getPost(id)
		{
			this.$http
			.get('/p/'+id)
			.then(function(response){
				this.picture=response.data;
				document.title=`${this.picture.title} -Picture gallery`;
			})
		}
	},
	created(){
		this.getPost(this.$route.params.id);
	}
};
</script>

<style lang="css" scoped>
.wrap{
	width:100%;
	display:flex;
	flex-direction: row;
	justify-content: center;
	align-content: center;
}
.wrap img{
	width:640px;
	height:480px;
}
.wrap p{
	width:500px;
}
</style>
