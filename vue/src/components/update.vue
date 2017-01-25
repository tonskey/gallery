<template>
	<div class="row">
		<h1 class="text-center">Update picture</h1>
		<div class="col-md-7 col-md-offset-1">
			<div v-if="block.error" class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Oh snap!</strong> {{block.error}}
			</div>
			<div v-if="block.success" class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Well done!</strong> {{block.success}}
			</div>
			<form class="form-horizontal">
				<div class="form-group">
					<input type="file" @change="file">
					<img 
						v-if="preview" 
						:src="preview" 
						width="540"
						class="img img-thumbnail" 
						height="380"
					>
				</div>
				<div class="form-group" :class="{'has-error': errors.has('title') }">
					<label class="col-sm-2 control-label">Title</label>
					<div class="col-sm-10">
						<input
							v-model="newpost.title"
							data-vv-rules="required|min:3" 
							v-validate
							type="text"
							name="title"
							class="form-control"
							placeholder="Title"
						>
						<p class="text-danger" v-if="errors.has('title')">
							{{errors.first('title')}}
						</p>
					</div>
				</div>
				<div class="form-group" :class="{'has-error': errors.has('description') }">
					<label class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10">
						<textarea
							v-model="newpost.description"
							data-vv-rules="required|min:3" 
							v-validate
							name="description"
							placeholder="Description" 
							class="form-control" 
							rows="4"
						>		
						</textarea>
						<p class="text-danger" v-if="errors.has('description')">
							{{errors.first('description')}}
						</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button 
							type="submit" 
							@click.prevent="add" 
							class="btn btn-warning"
						>	
							Update picture
						</button>
					</div>
				</div>
			</form>
		</div>		
	</div>
</template>
<script>
export default {
  	name: 'update',
  	data () {
    	return {
    		newpost:{
    			title:null,
    			body:null,
    			img:null
    		},
    		block:{
    			error:null,
    			success:null
    		},
    		preview:null,
    		changeFoto:false,
    	};
  	},
  	methods:{
  		add()
  		{  		
  			let self=this;
  			if(this.$data.errors.errors.length!=0)
  			{
  				this.block.success=null;
  				this.block.error='You have error in some field';
  				return;
  			}
  			let picture=new FormData();
  			picture.set('title',this.newpost.title);
  			picture.set('changeFoto',this.changeFoto);
  			picture.set('description',this.newpost.description);
  			picture.set('img',this.newpost.picture);
  			this.$http
  			.post('/p/'+this.newpost.id,picture,{emulateJSON:true}).then(res=>{
  				this.block.error=null;
  				self.block.success=`Your picture was updated successfully!`
  			},err=>{
  				console.log(err);
  				this.block.error=err.data;
  			})
  		},
  		file(e)
  		{
  			let self=this;
  			let file=e.target.files[0]||e.dataTransfer.files[0];
  			this.newpost.picture=file;
  			var reader=new FileReader();
  			reader.addEventListener('load',function(){
  				self.preview=reader.result;
  			},false)
  			reader.readAsDataURL(file);
  			this.changeFoto=true;
  		},
		getPost(id)
		{
			this.$http
			.get('/p/'+id)
			.then(function(response){
				this.newpost=response.data;
				this.preview=this.newpost.picture;
			})
		}
  	},
	created(){
		this.getPost(this.$route.params.id);
		this.$store.dispatch('setTitle',`Update picture`);
	}
};
</script>

<style lang="css" scoped>
</style>