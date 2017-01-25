<template>
	<div class="row">
		<h1 class="text-center">Update post</h1>
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
			<form v-if="post" class="form-horizontal">
				<div class="form-group" :class="{'has-error': errors.has('title') }">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input
							v-model="post.title"
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
				<div class="form-group" :class="{'has-error': errors.has('body') }">
					<label class="col-sm-2 control-label">Body</label>
					<div class="col-sm-10">
						<textarea
							v-model="post.body"
							data-vv-rules="required|min:3" 
							v-validate
							name="body"
							placeholder="Body" 
							class="form-control" 
							rows="8"
						>		
						</textarea>
						<p class="text-danger" v-if="errors.has('body')">
							{{errors.first('body')}}
						</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button 
							type="submit" 
							@click.prevent="update" 
							class="btn btn-warning"
						>
							Update post
						</button>
					</div>
				</div>
			</form>
		</div>		
	</div>
</template>
<script>
export default {
  	name: 'addpost',
  	data () {
    	return {
    		post:null,
    		block:{
    			error:null,
    			success:null
    		}
    	};
  	},
  	created(){
		this.$store.dispatch('setTitle',`Updated post`);
		let self=this;
  		this.$http
  		.get('posts/'+this.$route.params.id)
  		.then(res=>{
  			console.log(res.data);
  			self.post=res.data;
  			console.log(self.post);
  		})
  	},
  	methods:{
  		update()
  		{  		
  			if(this.$data.errors.errors.length!=0)
  			{
  				this.block.success=null;
  				this.block.error='You have error in some field';
  				return;
  			}
  			let self=this;
  			console.log(this.post);
  			this.$http
  			.put('posts/'+this.post.id,self.post).then(res=>{
  				this.block.error=null;
  				self.block.success=`Your post was updated successfully!`
  			},err=>{
  				console.log(err);
  			})
  		}
  	}
};
</script>

<style lang="css" scoped>
</style>